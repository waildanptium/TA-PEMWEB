<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Order;

class TransactionController extends Controller
{
    public function index()
    {
        return view('kasir.history', [
            'orders' => Order::where('cashier_id', auth()->id())->latest()->paginate(15),
        ]);
    }

    public function show(Order $order)
    {
        abort_if(auth()->user()->isKasir() && $order->cashier_id !== auth()->id(), 403);

        return view('kasir.receipt', ['order' => $order->load(['items.product', 'cashier'])]);
    }
}