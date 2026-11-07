<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function store(Request $request, Product $produk)
    {
        $data = $request->validate(['percent' => 'required|integer|min:1|max:90']);

        $max = $produk->price > 0 ? (int) floor((1 - $produk->cost_price / $produk->price) * 100) : 0;
        if ($data['percent'] > $max) {
            return back()->with('error', "Diskon maksimal {$max}% agar harga tidak di bawah modal.");
        }

        $produk->update(['discount_percent' => $data['percent']]);

        return back()->with('success', 'Diskon diterapkan.');
    }

    public function destroy(Product $produk)
    {
        $produk->update(['discount_percent' => 0]);

        return back()->with('success', 'Diskon dicabut.');
    }
}