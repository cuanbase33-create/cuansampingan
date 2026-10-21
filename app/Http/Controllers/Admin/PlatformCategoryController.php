<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlatformCategory;
use Illuminate\Http\Request;

class PlatformCategoryController extends Controller
{
    public function index()
    {
        $categories = PlatformCategory::withCount('platforms')->orderBy('sort_order')->orderBy('name')->paginate(15);
        return view('admin.platform_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.platform_categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:platform_categories,name',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['sort_order'] = $request->sort_order ?? 0;

        PlatformCategory::create($validated);

        return redirect()->route('admin.platform-categories.index')->with('success', 'Kategori Platform berhasil ditambahkan.');
    }

    public function edit(PlatformCategory $platform_category)
    {
        return view('admin.platform_categories.edit', ['category' => $platform_category]);
    }

    public function update(Request $request, PlatformCategory $platform_category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:platform_categories,name,' . $platform_category->id,
            'sort_order' => 'nullable|integer',
        ]);

        $validated['sort_order'] = $request->sort_order ?? 0;

        $platform_category->update($validated);

        return redirect()->route('admin.platform-categories.index')->with('success', 'Kategori Platform berhasil diperbarui.');
    }

    public function destroy(PlatformCategory $platform_category)
    {
        if ($platform_category->platforms()->count() > 0) {
            return back()->with('error', 'Kategori Platform tidak dapat dihapus karena masih digunakan oleh platform.');
        }

        $platform_category->delete();

        return redirect()->route('admin.platform-categories.index')->with('success', 'Kategori Platform berhasil dihapus.');
    }
}
