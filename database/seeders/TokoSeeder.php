<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TokoSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@makmurjaya.test'], [
            'name' => 'Admin Makmur Jaya', 'password' => Hash::make('password'), 'role' => 'admin',
        ]);
        User::updateOrCreate(['email' => 'kasir@makmurjaya.test'], [
            'name' => 'Kasir 1', 'password' => Hash::make('password'), 'role' => 'kasir',
        ]);
        User::updateOrCreate(['email' => 'budi@makmurjaya.test'], [
            'name' => 'Budi Pelanggan', 'password' => Hash::make('password'), 'role' => 'pelanggan',
        ]);

        $data = [
            'Sembako' => [
                ['SMB001', 'Beras Premium 5kg', 62000, 70000, 40],
                ['SMB002', 'Minyak Goreng 2L', 32000, 36000, 30],
                ['SMB003', 'Gula Pasir 1kg', 15000, 17500, 50],
            ],
            'Minuman' => [
                ['MNM001', 'Air Mineral 600ml', 2500, 3500, 100],
                ['MNM002', 'Teh Botol 450ml', 4000, 5500, 60],
            ],
            'Makanan Ringan' => [
                ['SNK001', 'Keripik Singkong 200g', 8000, 11000, 25],
                ['SNK002', 'Biskuit Kelapa', 6000, 8500, 4],
            ],
            'Kebutuhan Rumah' => [
                ['RMH001', 'Sabun Cuci Piring 800ml', 12000, 15000, 35],
                ['RMH002', 'Deterjen 1kg', 18000, 22000, 28],
            ],
        ];

        foreach ($data as $catName => $products) {
            $cat = Category::firstOrCreate(['slug' => Str::slug($catName)], ['name' => $catName]);
            foreach ($products as [$code, $name, $cost, $price, $stock]) {
                Product::updateOrCreate(['code' => $code], [
                    'category_id' => $cat->id, 'name' => $name, 'cost_price' => $cost,
                    'price' => $price, 'stock' => $stock, 'min_stock' => 5, 'is_active' => true,
                    'description' => "$name, tersedia di Toko Makmur Jaya.",
                ]);
            }
        }
    }
}