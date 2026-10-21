<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\ContentCategory;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category');

        if ($request->has('category') && $request->category != '') {
            $query->where('content_category_id', $request->category);
        }

        if ($request->has('search') && $request->search != '') {
            $search = addcslashes($request->search, '%_\\');
            $query->where('title', 'like', '%' . $search . '%');
        }

        $books = $query->orderBy('sort_order')->orderBy('title')->paginate(15);
        $categories = ContentCategory::where('type', 'bacaan')->orderBy('name')->get();

        return view('admin.books.index', compact('books', 'categories'));
    }

    public function create()
    {
        $categories = ContentCategory::where('type', 'bacaan')->orderBy('name')->get();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content_category_id' => 'required|exists:content_categories,id',
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'purchase_url' => 'required|url:http,https|max:500',
            'cover_image' => 'nullable|url:http,https|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['is_published'] = $request->has('is_published');
        $validated['sort_order'] = $request->sort_order ?? 0;

        Book::create($validated);

        return redirect()->route('admin.books.index')->with('success', 'Bacaan Rekomendasi berhasil ditambahkan.');
    }

    public function edit(Book $book)
    {
        $categories = ContentCategory::where('type', 'bacaan')->orderBy('name')->get();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'content_category_id' => 'required|exists:content_categories,id',
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'purchase_url' => 'required|url:http,https|max:500',
            'cover_image' => 'nullable|url:http,https|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['is_published'] = $request->has('is_published');
        $validated['sort_order'] = $request->sort_order ?? 0;

        $book->update($validated);

        return redirect()->route('admin.books.index')->with('success', 'Bacaan Rekomendasi berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Bacaan Rekomendasi berhasil dihapus.');
    }
}

