<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Bundle;
use App\Services\BundlePricing;

class CartController extends Controller
{
    public function index()
    {
        $total = $items->sum(fn ($i) => $i->qty * $i->product->final_price);
        $bundleDiscount = (new BundlePricing)->discount($items->pluck('qty', 'product_id')->all());

        return view('customer.cart', compact('items', 'total', 'bundleDiscount'));
    }

     public function storeBundle(Bundle $bundle)
    {
        abort_unless($bundle->is_active, 404);
        $bundleItems = $bundle->items()->with('product')->get();

        foreach ($bundleItems as $it) {
            if (!$it->product || !$it->product->is_active || $it->product->stock < $it->qty) {
                return back()->with('error', 'Paket tidak tersedia: stok kurang.');
            }
        }

        foreach ($bundleItems as $it) {
            $item = CartItem::firstOrNew(['user_id' => auth()->id(), 'product_id' => $it->product_id]);
            $item->qty = min(($item->qty ?? 0) + $it->qty, $it->product->stock);
            $item->save();
        }

        return back()->with('success', 'Paket masuk keranjang.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty'        => 'required|integer|min:1',
        ]);

        $product = Product::where('is_active', true)->findOrFail($data['product_id']);
        $item = CartItem::firstOrNew(['user_id' => auth()->id(), 'product_id' => $product->id]);
        $item->qty = min(($item->qty ?? 0) + $data['qty'], $product->stock);
        $item->save();

        return back()->with('success', 'Produk masuk keranjang.');
    }

    public function update(Request $request, CartItem $item)
    {
        abort_unless($item->user_id === auth()->id(), 403);
        $data = $request->validate(['qty' => 'required|integer|min:1']);
        $item->update(['qty' => min($data['qty'], $item->product->stock)]);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function destroy(CartItem $item)
    {
        abort_unless($item->user_id === auth()->id(), 403);
        $item->delete();

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}