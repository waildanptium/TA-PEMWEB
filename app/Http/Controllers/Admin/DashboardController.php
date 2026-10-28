<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Order::whereDate('created_at', today())->where('status', '!=', 'batal');

        $profitToday = OrderItem::whereHas('order', fn ($q) => $q->whereDate('created_at', today())->where('status', '!=', 'batal'))
            ->get()
            ->sum(fn ($i) => ($i->price - $i->cost_price) * $i->qty);

        return view('admin.dashboard', [
            'salesToday'  => (clone $today)->sum('total'),
            'trxToday'    => (clone $today)->count(),
            'profitToday' => $profitToday,
            'lowStock'    => Product::whereColumn('stock', '<=', 'min_stock')->orderBy('stock')->get(),
            'topProducts' => OrderItem::selectRaw('product_id, SUM(qty) as total_qty')
                ->groupBy('product_id')->orderByDesc('total_qty')->with('product')->take(5)->get(),
        ]);
    }
}