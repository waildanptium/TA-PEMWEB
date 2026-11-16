<x-toko-layout title="Checkout">
    <h1 class="text-2xl font-extrabold text-[#382112] mb-6">Checkout</h1>

    <div class="grid md:grid-cols-2 gap-6 items-start">
        <!-- KOLOM KIRI: FORM PENGIRIMAN & PEMBAYARAN -->
        <form method="POST" action="{{ route('checkout.process') }}" class="card space-y-5 border border-orange-100 p-6">
            @csrf

            <!-- Alamat Pengiriman -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat pengiriman</label>
                <textarea name="shipping_address" rows="4" placeholder="Masukkan alamat lengkap pengiriman..."
                          class="w-full rounded-xl border border-orange-200 px-4 py-3 text-sm bg-white focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition"
                          required>{{ old('shipping_address') }}</textarea>
            </div>

            <!-- Metode Pembayaran (Tanpa Dropdown Biru) -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Metode pembayaran</label>
                <div class="space-y-2.5">
                    <!-- Transfer Bank -->
                    <label class="flex items-center justify-between p-3.5 rounded-xl border border-orange-200 bg-white cursor-pointer transition hover:bg-orange-50/50 has-[:checked]:border-orange-500 has-[:checked]:bg-orange-50">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="payment_method" value="transfer" {{ old('payment_method', 'transfer') === 'transfer' ? 'checked' : '' }} class="accent-orange-500 w-4 h-4">
                            <span class="text-sm font-semibold text-gray-800">Transfer Bank</span>
                        </div>
                        <span class="text-xs text-gray-400">BCA / Mandiri / BRI</span>
                    </label>

                    <!-- QRIS -->
                    <label class="flex items-center justify-between p-3.5 rounded-xl border border-orange-200 bg-white cursor-pointer transition hover:bg-orange-50/50 has-[:checked]:border-orange-500 has-[:checked]:bg-orange-50">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="payment_method" value="qris" {{ old('payment_method') === 'qris' ? 'checked' : '' }} class="accent-orange-500 w-4 h-4">
                            <span class="text-sm font-semibold text-gray-800">QRIS</span>
                        </div>
                        <span class="text-xs text-gray-400">Scan Instan</span>
                    </label>

                    <!-- COD -->
                    <label class="flex items-center justify-between p-3.5 rounded-xl border border-orange-200 bg-white cursor-pointer transition hover:bg-orange-50/50 has-[:checked]:border-orange-500 has-[:checked]:bg-orange-50">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="payment_method" value="cod" {{ old('payment_method') === 'cod' ? 'checked' : '' }} class="accent-orange-500 w-4 h-4">
                            <span class="text-sm font-semibold text-gray-800">Bayar di Tempat (COD)</span>
                        </div>
                        <span class="text-xs text-gray-400">Bayar saat kurir tiba</span>
                    </label>
                </div>
            </div>

            <button class="btn w-full py-3">Buat Pesanan</button>
        </form>

        <!-- KOLOM KANAN: RINGKASAN PESANAN (Total sudah masuk ke dalam kotak) -->
        <div class="card border border-orange-100 p-6 space-y-3">
            <h2 class="font-bold text-lg text-[#382112] mb-2">Ringkasan Pesanan</h2>

            <div class="space-y-2.5 text-sm text-gray-700">
                @foreach($items as $i)
                    <div class="flex justify-between items-center">
                        <span>{{ $i->product->name }} <span class="text-gray-400">x{{ $i->qty }}</span></span>
                        <span class="font-medium">Rp {{ number_format($i->qty * $i->product->final_price, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>

            <hr class="border-orange-100 my-3">

            @if($bundleDiscount > 0)
                <div class="flex justify-between text-sm text-orange-600 font-medium">
                    <span>Hemat paket</span>
                    <span>- Rp {{ number_format($bundleDiscount, 0, ',', '.') }}</span>
                </div>
            @endif

            <div class="flex justify-between items-center pt-1 font-extrabold text-lg text-[#382112]">
                <span>Total</span>
                <span class="text-orange-500">Rp {{ number_format($total - $bundleDiscount, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
</x-toko-layout>