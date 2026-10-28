<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')->where('is_active', true)
            ->when($request->q, fn ($q, $v) => $q->where('name', 'like', "%$v%"))
            ->when($request->category, fn ($q, $v) => $q->where('category_id', $v))
            ->when($request->min, fn ($q, $v) => $q->where('price', '>=', (int) $v))
            ->when($request->max, fn ($q, $v) => $q->where('price', '<=', (int) $v));

        match ($request->sort) {
            'murah' => $products->orderBy('price'),
            'mahal' => $products->orderByDesc('price'),
            default => $products->latest(),
        };

        return view('customer.catalog', [
            'products'   => $products->paginate(12)->withQueryString(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);

        return view('customer.show', ['product' => $product->load('category')]);
    }
}