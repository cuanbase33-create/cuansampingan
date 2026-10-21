<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_platforms' => \App\Models\Platform::count(),
            'total_articles' => \App\Models\Article::count(),
            'total_books' => \App\Models\Book::count(),
            'total_article_views' => \App\Models\Article::sum('view_count'),
        ];

        return view('admin.dashboard.index', compact('stats'));
    }
}
