<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContentCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = ContentCategory::query();

        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        $categories = $query->orderBy('type')->orderBy('name')->paginate(15);
        
        $types = [
            'artikel' => 'Artikel', 
            'bacaan' => 'Bacaan Rekomendasi', 
            'free_resource' => 'Free Resource', 
            'digital_product' => 'Digital Product'
        ];

        return view('admin.categories.index', compact('categories', 'types'));
    }

    public function create()
    {
        $types = [
            'artikel' => 'Artikel', 
            'bacaan' => 'Bacaan Rekomendasi', 
            'free_resource' => 'Free Resource', 
            'digital_product' => 'Digital Product'
        ];
        
        return view('admin.categories.create', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => ['required', Rule::in(['artikel', 'bacaan', 'free_resource', 'digital_product'])],
            'name' => 'required|string|max:100',
        ]);

        ContentCategory::create([
            'type' => $request->type,
            'name' => $request->name,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(ContentCategory $category)
    {
        $types = [
            'artikel' => 'Artikel', 
            'bacaan' => 'Bacaan Rekomendasi', 
            'free_resource' => 'Free Resource', 
            'digital_product' => 'Digital Product'
        ];
        
        return view('admin.categories.edit', compact('category', 'types'));
    }

    public function update(Request $request, ContentCategory $category)
    {
        $request->validate([
            'type' => ['required', Rule::in(['artikel', 'bacaan', 'free_resource', 'digital_product'])],
            'name' => 'required|string|max:100',
        ]);

        $category->update([
            'type' => $request->type,
            'name' => $request->name,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(ContentCategory $category)
    {
        // Check if there are associated contents before deleting
        if ($category->articles()->count() > 0 || 
            $category->books()->count() > 0 || 
            $category->freeResources()->count() > 0 || 
            $category->digitalProducts()->count() > 0) {
            
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh konten.');
        }

        $category->delete();
        
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
