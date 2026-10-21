<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tutorial;
use App\Models\ContentCategory;
use App\Services\ViewCountService;

class TutorialController extends Controller
{
    public function index(Request $request)
    {
        $query = Tutorial::where('is_published', true)->with('category');

        if ($request->has('kategori') && $request->kategori != '') {
            $categorySlug = $request->kategori;
            $query->whereHas('category', function($q) use ($categorySlug) {
                $q->where('slug', $categorySlug)->where('type', 'tutorial');
            });
        }

        $tutorials = $query->orderBy('published_at', 'desc')->paginate(10);
        $categories = ContentCategory::where('type', 'tutorial')->get();

        $popularTutorials = Tutorial::where('is_published', true)
                                   ->orderBy('view_count', 'desc')
                                   ->take(5)
                                   ->get();

        $latestSidebarTutorials = Tutorial::where('is_published', true)
                                        ->orderBy('published_at', 'desc')
                                        ->take(5)
                                        ->get();

        return view('public.tutorials.index', compact('tutorials', 'categories', 'popularTutorials', 'latestSidebarTutorials'));
    }

    public function show($slug)
    {
        $tutorial = Tutorial::where('slug', $slug)
                          ->where('is_published', true)
                          ->with('category')
                          ->firstOrFail();

        if (class_exists(ViewCountService::class)) {
            app(ViewCountService::class)->recordView($tutorial, request()->ip());
        } else {
            $tutorial->increment('view_count');
        }

        $popularTutorials = Tutorial::where('is_published', true)
                                   ->orderBy('view_count', 'desc')
                                   ->take(5)
                                   ->get();

        $latestSidebarTutorials = Tutorial::where('is_published', true)
                                        ->orderBy('published_at', 'desc')
                                        ->take(5)
                                        ->get();

        $relatedTutorials = collect();
        if ($tutorial->category) {
            $relatedTutorials = Tutorial::where('is_published', true)
                                      ->where('content_category_id', $tutorial->content_category_id)
                                      ->where('id', '!=', $tutorial->id)
                                      ->orderBy('published_at', 'desc')
                                      ->take(3)
                                      ->get();
        }

        return view('public.tutorials.show', compact('tutorial', 'popularTutorials', 'latestSidebarTutorials', 'relatedTutorials'));
    }
}
