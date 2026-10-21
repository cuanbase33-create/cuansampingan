<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlatformCategory;
use App\Models\Article;
use App\Models\Book;
use App\Models\FreeResource;
use App\Models\DigitalProduct;
use App\Models\Tutorial;

class HomeController extends Controller
{
    public function index()
    {
        $platformCategories = PlatformCategory::orderBy('sort_order')->get();
        
        $latestArticles = Article::where('is_published', true)
                            ->orderBy('published_at', 'desc')
                            ->take(3)
                            ->get();

        $latestBooks = Book::where('is_published', true)
                            ->orderBy('created_at', 'desc')
                            ->take(4)
                            ->get();

        $latestTutorials = Tutorial::where('is_published', true)
                            ->orderBy('published_at', 'desc')
                            ->take(3)
                            ->get();

        $latestResources = FreeResource::where('is_published', true)
                                ->orderBy('created_at', 'desc')
                                ->take(4)
                                ->get();

        $latestProducts = DigitalProduct::where('is_published', true)
                                ->orderBy('created_at', 'desc')
                                ->take(4)
                                ->get();

        return view('public.home', compact(
            'platformCategories', 
            'latestArticles', 
            'latestBooks', 
            'latestTutorials',
            'latestResources', 
            'latestProducts'
        ));
    }
}
