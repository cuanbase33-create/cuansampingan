<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DigitalProduct;
use App\Models\ContentCategory;

class DigitalProductController extends Controller
{
    public function index(Request $request)
    {
        $query = DigitalProduct::where('is_published', true)->with('category');

        if ($request->has('kategori') && $request->kategori != '') {
            $categorySlug = $request->kategori;
            $query->whereHas('category', function($q) use ($categorySlug) {
                $q->where('slug', $categorySlug)->where('type', 'digital_product');
            });
        }

        $products = $query->orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(12);
        $categories = ContentCategory::where('type', 'digital_product')->get();

        return view('public.digital_products.index', compact('products', 'categories'));
    }
}
