<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\ContentCategory;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::where('is_published', true)->with('category');

        if ($request->has('kategori') && $request->kategori != '') {
            $categorySlug = $request->kategori;
            $query->whereHas('category', function($q) use ($categorySlug) {
                $q->where('slug', $categorySlug)->where('type', 'bacaan');
            });
        }

        $books = $query->orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(12);
        $categories = ContentCategory::where('type', 'bacaan')->get();

        return view('public.books.index', compact('books', 'categories'));
    }
}
