<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlatformCategory;

class PlatformController extends Controller
{
    public function show($slug)
    {
        $category = PlatformCategory::where('slug', $slug)->firstOrFail();
        
        $platforms = $category->platforms()->with('categories')->where('is_active', true)->orderBy('sort_order')->get();
        
        $allCategories = PlatformCategory::orderBy('sort_order')->get();

        return view('public.platforms.show', compact('category', 'platforms', 'allCategories'));
    }
}
