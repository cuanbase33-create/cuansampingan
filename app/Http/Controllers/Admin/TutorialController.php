<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tutorial;
use App\Models\ContentCategory;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;

class TutorialController extends Controller
{
    public function index(Request $request)
    {
        $query = Tutorial::with('category');

        if ($request->has('category') && $request->category != '') {
            $query->where('content_category_id', $request->category);
        }

        if ($request->has('search') && $request->search != '') {
            $search = addcslashes($request->search, '%_\\');
            $query->where('title', 'like', '%' . $search . '%');
        }

        $tutorials = $query->orderBy('created_at', 'desc')->paginate(15);
        $categories = ContentCategory::where('type', 'tutorial')->orderBy('name')->get();

        return view('admin.tutorials.index', compact('tutorials', 'categories'));
    }

    public function create()
    {
        $categories = ContentCategory::where('type', 'tutorial')->orderBy('name')->get();
        return view('admin.tutorials.create', compact('categories'));
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

        Tutorial::create($validated);

        return redirect()->route('admin.tutorials.index')->with('success', 'Tutorial berhasil ditambahkan.');
    }

    public function edit(Tutorial $tutorial)
    {
        $categories = ContentCategory::where('type', 'tutorial')->orderBy('name')->get();
        return view('admin.tutorials.edit', compact('tutorial', 'categories'));
    }

    public function update(Request $request, Tutorial $tutorial)
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
        if ($is_published && !$tutorial->is_published) {
            $validated['published_at'] = now();
        } elseif (!$is_published) {
            $validated['published_at'] = null;
        }
        $validated['is_published'] = $is_published;

        $tutorial->update($validated);

        return redirect()->route('admin.tutorials.index')->with('success', 'Tutorial berhasil diperbarui.');
    }

    public function destroy(Tutorial $tutorial)
    {
        $tutorial->delete();
        return redirect()->route('admin.tutorials.index')->with('success', 'Tutorial berhasil dihapus.');
    }
}
