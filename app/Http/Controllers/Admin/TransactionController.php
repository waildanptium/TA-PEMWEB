<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with(['user', 'cashier'])
            ->when($request->channel, fn ($q, $v) => $q->where('channel', $v))
            ->when($request->status, fn ($q, $v) => $q->where('status', $v))
            ->latest()->paginate(20)->withQueryString();

        return view('admin.transaksi.index', compact('orders'));
    }

    public function show(Order $transaksi)
    {
        $transaksi->load(['items.product', 'user', 'cashier']);

        return view('admin.transaksi.show', ['order' => $transaksi]);
    }

    public function update(Request $request, Order $transaksi)
    {
        $data = $request->validate([
            'status'         => 'required|in:pending,diproses,dikirim,selesai,batal',
            'payment_status' => 'required|in:unpaid,paid',
        ]);

        if ($transaksi->status === 'batal') {
            return back()->with('error', 'Pesanan yang sudah dibatalkan tidak bisa diubah.');
        }

        DB::transaction(function () use ($data, $transaksi) {
            if ($data['status'] === 'batal') {
                foreach ($transaksi->items as $item) {
                    Product::where('id', $item->product_id)->increment('stock', $item->qty);
                }
            }
            $transaksi->update($data);
        });

        return back()->with('success', 'Transaksi diperbarui.');
    }
}