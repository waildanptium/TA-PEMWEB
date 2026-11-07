<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bundle;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BundleController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'p1'    => 'required|exists:products,id|different:p2',
            'p2'    => 'required|exists:products,id',
            'price' => 'required|integer|min:1',
        ]);

        $products = Product::findMany([$data['p1'], $data['p2']]);

        if ($data['price'] < $products->sum('cost_price')) {
            return back()->with('error', 'Harga paket di bawah total modal.');
        }
        if ($data['price'] >= $products->sum('price')) {
            return back()->with('error', 'Harga paket harus lebih murah dari harga normal.');
        }

        $name = $products->pluck('name')->implode(' + ');
        if (Bundle::where('name', $name)->exists()) {
            return back()->with('error', 'Paket sudah ada.');
        }

        DB::transaction(function () use ($name, $data, $products) {
            $bundle = Bundle::create(['name' => $name, 'price' => $data['price'], 'is_active' => true]);
            foreach ($products as $p) {
                $bundle->items()->create(['product_id' => $p->id, 'qty' => 1]);
            }
        });

        return back()->with('success', 'Paket dibuat.');
    }

    public function destroy(Bundle $paket)
    {
        $paket->delete();

        return back()->with('success', 'Paket dihapus.');
    }
}