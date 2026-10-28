<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        return view('customer.orders', [
            'orders' => Order::where('user_id', auth()->id())->latest()->paginate(10),
        ]);
    }

    public function show(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        return view('customer.order-show', ['order' => $order->load('items.product')]);
    }
}