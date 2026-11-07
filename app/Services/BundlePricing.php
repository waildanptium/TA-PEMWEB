<?php

namespace App\Services;

use App\Models\Bundle;

class BundlePricing
{
    // Paket aktif yang semua produknya aktif
    public function active()
    {
        return Bundle::with('items.product')->where('is_active', true)->get()
            ->filter(fn ($b) => $b->items->isNotEmpty()
                && $b->items->every(fn ($i) => $i->product && $i->product->is_active))
            ->values();
    }

    // $qtyByProduct: [product_id => qty]. Return total potongan paket (Rp).
    // Stok qty dipakai satu kali: produk yang sama tidak dihitung di dua paket.
    public function discount(array $qtyByProduct): int
    {
        $pool = $qtyByProduct;
        $total = 0;

        foreach ($this->active() as $b) {
            $sets = PHP_INT_MAX;
            $normal = 0;
            foreach ($b->items as $it) {
                $sets = min($sets, intdiv($pool[$it->product_id] ?? 0, max($it->qty, 1)));
                $normal += $it->product->final_price * $it->qty;
            }
            if ($sets > 0) {
                $total += $sets * max(0, $normal - $b->price);
                foreach ($b->items as $it) {
                    $pool[$it->product_id] -= $sets * $it->qty;
                }
            }
        }

        return (int) $total;
    }

    // Data paket untuk JavaScript di halaman POS
    public function forFrontend()
    {
        return $this->active()->map(fn ($b) => [
            'id'    => $b->id,
            'name'  => $b->name,
            'price' => $b->price,
            'items' => $b->items->map(fn ($i) => [
                'product_id' => $i->product_id,
                'qty'        => $i->qty,
                'price'      => $i->product->final_price,
            ])->values(),
        ])->values();
    }
}