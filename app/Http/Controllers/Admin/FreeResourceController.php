<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentCategory;
use App\Models\FreeResource;
use Illuminate\Http\Request;

class FreeResourceController extends Controller
{
    public function index(Request $request)
    {
        $query = FreeResource::with('category');

        if ($request->has('category') && $request->category != '') {
            $query->where('content_category_id', $request->category);
        }

        if ($request->has('search') && $request->search != '') {
            $search = addcslashes($request->search, '%_\\');
            $query->where('title', 'like', '%' . $search . '%');
        }

        $resources = $query->orderBy('created_at', 'desc')->paginate(15);
        $categories = ContentCategory::where('type', 'free_resource')->orderBy('name')->get();

        return view('admin.free_resources.index', compact('resources', 'categories'));
    }

    public function create()
    {
        $categories = ContentCategory::where('type', 'free_resource')->orderBy('name')->get();
        return view('admin.free_resources.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content_category_id' => 'required|exists:content_categories,id',
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'access_url' => 'required|url:http,https|max:500',
            'cover_image' => 'nullable|url:http,https|max:255',
        ]);

        $validated['is_published'] = $request->has('is_published');

        FreeResource::create($validated);

        return redirect()->route('admin.free-resources.index')->with('success', 'Free Resource berhasil ditambahkan.');
    }

    public function edit(FreeResource $free_resource)
    {
        $categories = ContentCategory::where('type', 'free_resource')->orderBy('name')->get();
        return view('admin.free_resources.edit', compact('free_resource', 'categories'));
    }

    public function update(Request $request, FreeResource $free_resource)
    {
        $validated = $request->validate([
            'content_category_id' => 'required|exists:content_categories,id',
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'access_url' => 'required|url:http,https|max:500',
            'cover_image' => 'nullable|url:http,https|max:255',
        ]);

        $validated['is_published'] = $request->has('is_published');

        $free_resource->update($validated);

        return redirect()->route('admin.free-resources.index')->with('success', 'Free Resource berhasil diperbarui.');
    }

    public function destroy(FreeResource $free_resource)
    {
        $free_resource->delete();
        return redirect()->route('admin.free-resources.index')->with('success', 'Free Resource berhasil dihapus.');
    }
}

