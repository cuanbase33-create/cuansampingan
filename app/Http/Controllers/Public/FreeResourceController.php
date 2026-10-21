<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FreeResource;
use App\Models\ContentCategory;

class FreeResourceController extends Controller
{
    public function index(Request $request)
    {
        $query = FreeResource::where('is_published', true)->with('category');

        if ($request->has('kategori') && $request->kategori != '') {
            $categorySlug = $request->kategori;
            $query->whereHas('category', function($q) use ($categorySlug) {
                $q->where('slug', $categorySlug)->where('type', 'free_resource');
            });
        }

        $resources = $query->orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(12);
        $categories = ContentCategory::where('type', 'free_resource')->get();

        return view('public.free_resources.index', compact('resources', 'categories'));
    }
}
