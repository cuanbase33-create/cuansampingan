<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use App\Models\PlatformCategory;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    public function index(Request $request)
    {
        $query = Platform::with('categories');

        if ($request->has('category') && $request->category != '') {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('platform_categories.id', $request->category);
            });
        }

        if ($request->has('search') && $request->search != '') {
            $search = addcslashes($request->search, '%_\\');
            $query->where('name', 'like', '%' . $search . '%');
        }

        $platforms = $query->orderBy('sort_order')->orderBy('name')->paginate(15);
        $categories = PlatformCategory::orderBy('sort_order')->get();

        return view('admin.platforms.index', compact('platforms', 'categories'));
    }

    public function create()
    {
        $categories = PlatformCategory::orderBy('sort_order')->get();
        return view('admin.platforms.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'exists:platform_categories,id',
            'logo' => 'required|url:http,https|max:255',
            'name' => 'required|string|max:150',
            'short_description' => 'required|string|max:200',
            'access_url' => 'required|url:http,https|max:500',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->sort_order ?? 0;
        // set primary category for backwards-compatibility
        $validated['platform_category_id'] = $validated['category_ids'][0] ?? null;

        $platform = Platform::create($validated);
        $platform->categories()->sync($validated['category_ids']);

        return redirect()->route('admin.platforms.index')->with('success', 'Platform berhasil ditambahkan.');
    }

    public function edit(Platform $platform)
    {
        $platform->load('categories');
        $categories = PlatformCategory::orderBy('sort_order')->get();
        return view('admin.platforms.edit', compact('platform', 'categories'));
    }

    public function update(Request $request, Platform $platform)
    {
        $validated = $request->validate([
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'exists:platform_categories,id',
            'logo' => 'required|url:http,https|max:255',
            'name' => 'required|string|max:150',
            'short_description' => 'required|string|max:200',
            'access_url' => 'required|url:http,https|max:500',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->sort_order ?? 0;
        $validated['platform_category_id'] = $validated['category_ids'][0] ?? null;

        $platform->update($validated);
        $platform->categories()->sync($validated['category_ids']);

        return redirect()->route('admin.platforms.index')->with('success', 'Platform berhasil diperbarui.');
    }

    public function destroy(Platform $platform)
    {
        $platform->delete();
        return redirect()->route('admin.platforms.index')->with('success', 'Platform berhasil dihapus.');
    }
}

