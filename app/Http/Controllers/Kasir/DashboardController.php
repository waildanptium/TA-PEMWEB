<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $orders = Order::where('cashier_id', auth()->id())->whereDate('created_at', today());

        return view('kasir.dashboard', [
            'count'    => (clone $orders)->count(),
            'total'    => (clone $orders)->sum('total'),
            'lowStock' => Product::whereColumn('stock', '<=', 'min_stock')->orderBy('stock')->take(10)->get(),
        ]);
    }
}