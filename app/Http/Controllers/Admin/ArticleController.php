<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ContentCategory;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with('category');

        if ($request->has('category') && $request->category != '') {
            $query->where('content_category_id', $request->category);
        }

        if ($request->has('search') && $request->search != '') {
            $search = addcslashes($request->search, '%_\\');
            $query->where('title', 'like', '%' . $search . '%');
        }

        $articles = $query->orderBy('created_at', 'desc')->paginate(15);
        $categories = ContentCategory::where('type', 'artikel')->orderBy('name')->get();

        return view('admin.articles.index', compact('articles', 'categories'));
    }

    public function create()
    {
        $categories = ContentCategory::where('type', 'artikel')->orderBy('name')->get();
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content_category_id' => 'required|exists:content_categories,id',
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'body' => 'required|string',
            'thumbnail' => 'nullable|url:http,https|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:320',
        ]);

        // Sanitize body HTML
        $validated['body'] = Purifier::clean($request->body);
        $validated['is_published'] = $request->has('is_published');
        $validated['published_at'] = $validated['is_published'] ? now() : null;

        Article::create($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit(Article $article)
    {
        $categories = ContentCategory::where('type', 'artikel')->orderBy('name')->get();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'content_category_id' => 'required|exists:content_categories,id',
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'body' => 'required|string',
            'thumbnail' => 'nullable|url:http,https|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:320',
        ]);

        // Sanitize body HTML
        $validated['body'] = Purifier::clean($request->body);
        $is_published = $request->has('is_published');
        
        // Handle publishing timestamp
        if ($is_published && !$article->is_published) {
            $validated['published_at'] = now();
        } elseif (!$is_published) {
            $validated['published_at'] = null;
        }
        $validated['is_published'] = $is_published;

        $article->update($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus.');
    }
}

