<x-toko-layout title="Struk">
    <div class="card" style="max-width:380px;margin:auto">
        <div class="text-center">
            <div class="font-bold text-lg">TOKO MAKMUR JAYA</div>
            <div class="text-xs text-gray-500">{{ $order->invoice_no }}</div>
            <div class="text-xs text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }} | Kasir: {{ $order->cashier->name ?? '-' }}</div>
        </div>
        <hr class="my-2">
        @foreach($order->items as $i)
            <div class="flex justify-between text-sm">
                <span>{{ $i->product->name }} x{{ $i->qty }}</span>
                <span>{{ number_format($i->price*$i->qty,0,',','.') }}</span>
            </div>
        @endforeach
        <hr class="my-2">
        <div class="flex justify-between text-sm"><span>Subtotal</span><span>{{ number_format($order->subtotal,0,',','.') }}</span></div>
        <div class="flex justify-between text-sm"><span>Diskon</span><span>{{ number_format($order->discount,0,',','.') }}</span></div>
        <div class="flex justify-between font-bold"><span>Total</span><span>{{ number_format($order->total,0,',','.') }}</span></div>
        <div class="flex justify-between text-sm"><span>Bayar ({{ $order->payment_method }})</span><span>{{ number_format($order->paid_amount,0,',','.') }}</span></div>
        <div class="flex justify-between text-sm"><span>Kembali</span><span>{{ number_format(max($order->paid_amount-$order->total,0),0,',','.') }}</span></div>
        <div class="text-center text-xs mt-3">Terima kasih sudah berbelanja!</div>
        <div class="flex gap-2 mt-4 print:hidden">
            <button onclick="window.print()" class="btn">Cetak</button>
            <a href="{{ route('kasir.pos') }}" class="btn btn-gray">Transaksi Baru</a>
        </div>
    </div>
</x-toko-layout>