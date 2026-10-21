<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\ContentCategory;
use App\Services\ViewCountService;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::where('is_published', true)->with('category');

        if ($request->has('kategori') && $request->kategori != '') {
            $categorySlug = $request->kategori;
            $query->whereHas('category', function($q) use ($categorySlug) {
                $q->where('slug', $categorySlug)->where('type', 'artikel');
            });
        }

        $articles = $query->orderBy('published_at', 'desc')->paginate(10);
        $categories = ContentCategory::where('type', 'artikel')->get();

        $popularArticles = Article::where('is_published', true)
                                  ->orderBy('view_count', 'desc')
                                  ->take(5)
                                  ->get();

        $latestSidebarArticles = Article::where('is_published', true)
                                        ->orderBy('published_at', 'desc')
                                        ->take(5)
                                        ->get();

        return view('public.articles.index', compact('articles', 'categories', 'popularArticles', 'latestSidebarArticles'));
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)
                          ->where('is_published', true)
                          ->with('category')
                          ->firstOrFail();

        // Simple view count increment (ideally via ViewCountService, but we inline simple approach if service is not ready)
        // If ViewCountService is implemented, use it instead.
        if (class_exists(ViewCountService::class)) {
            app(ViewCountService::class)->recordView($article, request()->ip());
        } else {
            $article->increment('view_count');
        }

        $popularArticles = Article::where('is_published', true)
                                  ->orderBy('view_count', 'desc')
                                  ->take(5)
                                  ->get();

        $latestSidebarArticles = Article::where('is_published', true)
                                        ->orderBy('published_at', 'desc')
                                        ->take(5)
                                        ->get();

        $relatedArticles = collect();
        if ($article->category) {
            $relatedArticles = Article::where('is_published', true)
                                      ->where('content_category_id', $article->content_category_id)
                                      ->where('id', '!=', $article->id)
                                      ->orderBy('published_at', 'desc')
                                      ->take(3)
                                      ->get();
        }

        return view('public.articles.show', compact('article', 'popularArticles', 'latestSidebarArticles', 'relatedArticles'));
    }
}
