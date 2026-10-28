<x-toko-layout title="Detail Pesanan">
    <h1 class="text-2xl font-bold mb-4">{{ $order->invoice_no }}</h1>

    <div class="card mb-4">
        <div class="mb-2">Status:
            @foreach(['pending'=>'Menunggu pembayaran','diproses'=>'Diproses','dikirim'=>'Dikirim','selesai'=>'Selesai'] as $k => $label)
                <span class="badge" style="{{ $order->status==$k ? 'background:#15803d;color:#fff' : '' }}">{{ $label }}</span>
            @endforeach
            @if($order->status=='batal')<span class="badge" style="background:#b91c1c;color:#fff">Dibatalkan</span>@endif
        </div>
        <div>Metode bayar: {{ $order->payment_method }} ({{ $order->payment_status == 'paid' ? 'Lunas' : 'Belum dibayar' }})</div>
        <div>Alamat: {{ $order->shipping_address }}</div>
        @if($order->payment_status == 'unpaid' && $order->payment_method != 'cod')
            <div class="mt-2 p-2 bg-yellow-100 rounded text-sm">Silakan lakukan pembayaran. Admin akan mengonfirmasi setelah pembayaran diterima.</div>
        @endif
    </div>

    <table class="tbl">
        <tr><th>Produk</th><th>Harga</th><th>Qty</th><th>Subtotal</th></tr>
        @foreach($order->items as $i)
            <tr><td>{{ $i->product->name }}</td><td>{{ number_format($i->price,0,',','.') }}</td>
                <td>{{ $i->qty }}</td><td>{{ number_format($i->price*$i->qty,0,',','.') }}</td></tr>
        @endforeach
        <tr><th colspan="3">Total</th><th>Rp {{ number_format($order->total,0,',','.') }}</th></tr>
    </table>
</x-toko-layout>