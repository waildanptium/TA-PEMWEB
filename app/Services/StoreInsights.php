<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class StoreInsights
{
    const WARN_DAYS = 30;
    const BUNDLE_DISCOUNT = 10;

    // Produk aktif, stok ada, kadaluwarsa dalam WARN_DAYS hari (termasuk yang sudah lewat)
    public function expiring()
    {
        return Product::where('is_active', true)
            ->where('stock', '>', 0)
            ->whereNotNull('expiry_date')
            ->whereDate('expiry_date', '<=', today()->addDays(self::WARN_DAYS))
            ->orderBy('expiry_date')
            ->get();
    }

    // Saran diskon: makin dekat kadaluwarsa makin besar; tambah 10% jika
    // laju jual 30 hari terakhir tidak akan menghabiskan stok sebelum kadaluwarsa;
    // dibatasi agar harga baru tidak di bawah harga modal.
    public function discountSuggestions()
    {
        $sold = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.status', '!=', 'batal')
            ->where('orders.created_at', '>=', now()->subDays(30))
            ->groupBy('order_items.product_id')
            ->selectRaw('order_items.product_id, SUM(order_items.qty) as qty')
            ->pluck('qty', 'product_id');

        return $this->expiring()->map(function ($p) use ($sold) {
            $days = (int) today()->diffInDays($p->expiry_date, false);

            if ($days < 0) {
                return (object) ['product' => $p, 'days' => $days, 'percent' => 0,
                    'new_price' => $p->price, 'note' => 'Sudah kadaluwarsa, tarik dari rak'];
            }

            $percent = $days <= 7 ? 30 : ($days <= 14 ? 20 : 10);
            $perDay = ($sold[$p->id] ?? 0) / 30;
            if ($perDay * $days < $p->stock) {
                $percent += 10;
            }

            $maxPercent = $p->price > 0 ? (int) floor((1 - $p->cost_price / $p->price) * 100) : 0;
            $capped = $percent > $maxPercent;
            $percent = max(min($percent, $maxPercent), 0);

            return (object) [
                'product'   => $p,
                'days'      => $days,
                'percent'   => $percent,
                'new_price' => (int) round($p->price * (100 - $percent) / 100),
                'note'      => $capped ? 'Dibatasi harga modal' : '',
            ];
        });
    }

    // Paket hemat: pasangan produk yang paling sering dibeli dalam satu pesanan
    public function bundles(int $limit = 5)
    {
        $pairs = DB::table('order_items as a')
            ->join('order_items as b', function ($j) {
                $j->on('a.order_id', '=', 'b.order_id')->on('a.product_id', '<', 'b.product_id');
            })
            ->join('orders as o', 'o.id', '=', 'a.order_id')
            ->where('o.status', '!=', 'batal')
            ->groupBy('a.product_id', 'b.product_id')
            ->havingRaw('COUNT(*) >= 2')
            ->selectRaw('a.product_id as p1, b.product_id as p2, COUNT(*) as freq')
            ->orderByDesc('freq')
            ->limit($limit)
            ->get();

        $products = Product::where('is_active', true)
            ->whereIn('id', $pairs->pluck('p1')->merge($pairs->pluck('p2')))
            ->get()->keyBy('id');

        return $pairs->filter(fn ($r) => isset($products[$r->p1], $products[$r->p2]))
            ->map(function ($r) use ($products) {
                $a = $products[$r->p1];
                $b = $products[$r->p2];
                $normal = $a->price + $b->price;
                $bundle = max((int) round($normal * (100 - self::BUNDLE_DISCOUNT) / 100), $a->cost_price + $b->cost_price);

                return (object) ['a' => $a, 'b' => $b, 'freq' => $r->freq,
                    'normal' => $normal, 'bundle' => $bundle, 'saving' => $normal - $bundle];
            })->values();
    }
}