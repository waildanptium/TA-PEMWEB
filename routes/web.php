<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Customer;
use App\Http\Controllers\Kasir;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ===== PUBLIK =====
Route::get('/', [Customer\HomeController::class, 'index'])->name('home');
Route::get('/produk', [Customer\CatalogController::class, 'index'])->name('catalog');
Route::get('/produk/{product}', [Customer\CatalogController::class, 'show'])->name('catalog.show');

// ===== Redirect setelah login sesuai role =====
Route::get('/dashboard', function () {
    return match (auth()->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'kasir' => redirect()->route('kasir.pos'),
        default => redirect()->route('home'),
    };
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===== PELANGGAN =====
Route::middleware(['auth', 'role:pelanggan'])->group(function () {
    Route::get('/keranjang', [Customer\CartController::class, 'index'])->name('cart');
    Route::post('/keranjang', [Customer\CartController::class, 'store'])->name('cart.store');
    Route::patch('/keranjang/{item}', [Customer\CartController::class, 'update'])->name('cart.update');
    Route::delete('/keranjang/{item}', [Customer\CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/checkout', [Customer\CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [Customer\CheckoutController::class, 'process'])->name('checkout.process');

    Route::get('/pesanan', [Customer\OrderController::class, 'index'])->name('orders');
    Route::get('/pesanan/{order}', [Customer\OrderController::class, 'show'])->name('orders.show');
});

// ===== KASIR (admin juga boleh) =====
Route::middleware(['auth', 'role:kasir,admin'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/', [Kasir\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/pos', [Kasir\PosController::class, 'index'])->name('pos');
    Route::post('/pos', [Kasir\PosController::class, 'store'])->name('pos.store');
    Route::get('/riwayat', [Kasir\TransactionController::class, 'index'])->name('history');
    Route::get('/struk/{order}', [Kasir\TransactionController::class, 'show'])->name('receipt');
});

// ===== ADMIN =====
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('produk', Admin\ProductController::class)->except('show');
    Route::resource('kategori', Admin\CategoryController::class)->only(['index', 'store', 'destroy']);
    Route::resource('pegawai', Admin\EmployeeController::class)->only(['index', 'store', 'update']);
    Route::resource('transaksi', Admin\TransactionController::class)->only(['index', 'show', 'update']);
});

require __DIR__.'/auth.php';