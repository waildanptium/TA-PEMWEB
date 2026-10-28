<x-toko-layout title="Checkout">
    <h1 class="text-2xl font-bold mb-4">Checkout</h1>

    <div class="grid md:grid-cols-2 gap-6">
        <form method="POST" action="{{ route('checkout.process') }}" class="card space-y-3">
            @csrf
            <div><label>Alamat pengiriman</label>
                <textarea name="shipping_address" rows="4" class="input" required>{{ old('shipping_address') }}</textarea></div>
            <div><label>Metode pembayaran</label>
                <select name="payment_method" class="input">
                    <option value="transfer">Transfer Bank</option>
                    <option value="qris">QRIS</option>
                    <option value="cod">Bayar di Tempat (COD)</option>
                </select></div>
            <button class="btn w-full">Buat Pesanan</button>
        </form>

        <div class="card">
            <h2 class="font-bold mb-2">Ringkasan</h2>
            @foreach($items as $i)
                <div class="flex justify-between"><span>{{ $i->product->name }} x{{ $i->qty }}</span>
                    <span>Rp {{ number_format($i->qty*$i->product->price,0,',','.') }}</span></div>
            @endforeach
            <hr class="my-2">
            <div class="flex justify-between font-bold text-lg"><span>Total</span><span>Rp {{ number_format($total,0,',','.') }}</span></div>
        </div>
    </div>
</x-toko-layout>