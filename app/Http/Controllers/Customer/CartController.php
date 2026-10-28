<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $items = CartItem::with('product')->where('user_id', auth()->id())->get();
        $total = $items->sum(fn ($i) => $i->qty * $i->product->price);

        return view('customer.cart', compact('items', 'total'));
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