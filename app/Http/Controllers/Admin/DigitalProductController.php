<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentCategory;
use App\Models\DigitalProduct;
use Illuminate\Http\Request;

class DigitalProductController extends Controller
{
    public function index(Request $request)
    {
        $query = DigitalProduct::with('category');

        if ($request->has('category') && $request->category != '') {
            $query->where('content_category_id', $request->category);
        }

        if ($request->has('search') && $request->search != '') {
            $search = addcslashes($request->search, '%_\\');
            $query->where('title', 'like', '%' . $search . '%');
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(15);
        $categories = ContentCategory::where('type', 'digital_product')->orderBy('name')->get();

        return view('admin.digital_products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = ContentCategory::where('type', 'digital_product')->orderBy('name')->get();
        return view('admin.digital_products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content_category_id' => 'required|exists:content_categories,id',
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'purchase_url' => 'required|url:http,https|max:500',
            'cover_image' => 'nullable|url:http,https|max:255',
        ]);

        $validated['is_published'] = $request->has('is_published');

        DigitalProduct::create($validated);

        return redirect()->route('admin.digital-products.index')->with('success', 'Digital Product berhasil ditambahkan.');
    }

    public function edit(DigitalProduct $digital_product)
    {
        $categories = ContentCategory::where('type', 'digital_product')->orderBy('name')->get();
        return view('admin.digital_products.edit', compact('digital_product', 'categories'));
    }

    public function update(Request $request, DigitalProduct $digital_product)
    {
        $validated = $request->validate([
            'content_category_id' => 'required|exists:content_categories,id',
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'purchase_url' => 'required|url:http,https|max:500',
            'cover_image' => 'nullable|url:http,https|max:255',
        ]);

        $validated['is_published'] = $request->has('is_published');

        $digital_product->update($validated);

        return redirect()->route('admin.digital-products.index')->with('success', 'Digital Product berhasil diperbarui.');
    }

    public function destroy(DigitalProduct $digital_product)
    {
        $digital_product->delete();
        return redirect()->route('admin.digital-products.index')->with('success', 'Digital Product berhasil dihapus.');
    }
}

