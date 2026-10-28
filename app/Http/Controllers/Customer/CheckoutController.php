<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $items = CartItem::with('product')->where('user_id', auth()->id())->get();
        if ($items->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Keranjang masih kosong.');
        }
        $total = $items->sum(fn ($i) => $i->qty * $i->product->price);

        return view('customer.checkout', compact('items', 'total'));
    }

    public function process(Request $request)
    {
        $data = $request->validate([
            'shipping_address' => 'required|string|max:500',
            'payment_method'   => 'required|in:transfer,qris,cod',
        ]);

        $items = CartItem::where('user_id', auth()->id())->get();
        if ($items->isEmpty()) {
            return redirect()->route('cart');
        }

        try {
            $order = DB::transaction(function () use ($data, $items) {
                $subtotal = 0;
                $lines = [];

                foreach ($items as $item) {
                    $p = Product::lockForUpdate()->find($item->product_id);
                    if (!$p || !$p->is_active || $p->stock < $item->qty) {
                        throw new \Exception('Stok ' . ($p->name ?? 'produk') . ' tidak mencukupi.');
                    }
                    $subtotal += $p->price * $item->qty;
                    $lines[] = [$p, $item->qty];
                }

                $order = Order::create([
                    'invoice_no'       => 'INV-' . now()->format('ymdHis') . rand(10, 99),
                    'user_id'          => auth()->id(),
                    'channel'          => 'online',
                    'subtotal'         => $subtotal,
                    'discount'         => 0,
                    'total'            => $subtotal,
                    'payment_method'   => $data['payment_method'],
                    'payment_status'   => 'unpaid',
                    'status'           => 'pending',
                    'shipping_address' => $data['shipping_address'],
                ]);

                foreach ($lines as [$p, $qty]) {
                    $p->decrement('stock', $qty);
                    $order->items()->create([
                        'product_id' => $p->id, 'qty' => $qty,
                        'price' => $p->price, 'cost_price' => $p->cost_price,
                    ]);
                }

                CartItem::where('user_id', auth()->id())->delete();

                return $order;
            });
        } catch (\Exception $e) {
            return redirect()->route('cart')->with('error', $e->getMessage());
        }

        return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibuat.');
    }
}