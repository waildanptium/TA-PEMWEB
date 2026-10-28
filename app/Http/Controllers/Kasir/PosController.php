<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    const MAX_DISCOUNT_PERCENT = 10;

    public function index()
    {
        $products = Product::where('is_active', true)->orderBy('name')
            ->get(['id', 'code', 'name', 'price', 'stock']);

        return view('kasir.pos', ['products' => $products, 'maxDiscount' => self::MAX_DISCOUNT_PERCENT]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'items'          => 'required|array|min:1',
            'items.*.id'     => 'required|exists:products,id',
            'items.*.qty'    => 'required|integer|min:1',
            'payment_method' => 'required|in:tunai,transfer,qris',
            'paid'           => 'required|integer|min:0',
            'discount'       => 'nullable|integer|min:0',
        ]);

        try {
            $order = DB::transaction(function () use ($data) {
                $subtotal = 0;
                $lines = [];

                foreach ($data['items'] as $row) {
                    $p = Product::lockForUpdate()->findOrFail($row['id']);
                    if (!$p->is_active || $p->stock < $row['qty']) {
                        throw new \Exception("Stok {$p->name} tidak cukup.");
                    }
                    $subtotal += $p->price * $row['qty'];
                    $lines[] = [$p, $row['qty']];
                }

                $discount = (int) ($data['discount'] ?? 0);
                if ($discount > $subtotal * self::MAX_DISCOUNT_PERCENT / 100) {
                    throw new \Exception('Diskon maksimal ' . self::MAX_DISCOUNT_PERCENT . '% dari subtotal.');
                }

                $total = $subtotal - $discount;
                if ($data['payment_method'] === 'tunai' && $data['paid'] < $total) {
                    throw new \Exception('Uang yang dibayarkan kurang.');
                }

                $order = Order::create([
                    'invoice_no'     => 'POS-' . now()->format('ymdHis') . rand(10, 99),
                    'cashier_id'     => auth()->id(),
                    'channel'        => 'pos',
                    'subtotal'       => $subtotal,
                    'discount'       => $discount,
                    'total'          => $total,
                    'paid_amount'    => $data['payment_method'] === 'tunai' ? $data['paid'] : $total,
                    'payment_method' => $data['payment_method'],
                    'payment_status' => 'paid',
                    'status'         => 'selesai',
                ]);

                foreach ($lines as [$p, $qty]) {
                    $p->decrement('stock', $qty);
                    $order->items()->create([
                        'product_id' => $p->id, 'qty' => $qty,
                        'price' => $p->price, 'cost_price' => $p->cost_price,
                    ]);
                }

                return $order;
            });
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json(['redirect' => route('kasir.receipt', $order)]);
    }
}