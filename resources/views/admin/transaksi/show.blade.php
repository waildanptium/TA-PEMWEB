<x-toko-layout title="Detail Transaksi">
    <h1 class="text-2xl font-bold mb-4">{{ $order->invoice_no }}</h1>

    <div class="card mb-4">
        <div>Tanggal: {{ $order->created_at->format('d/m/Y H:i') }}</div>
        <div>Channel: {{ $order->channel }}</div>
        <div>Pelanggan: {{ $order->user->name ?? '-' }} | Kasir: {{ $order->cashier->name ?? '-' }}</div>
        <div>Metode bayar: {{ $order->payment_method }}</div>
        @if($order->shipping_address)<div>Alamat: {{ $order->shipping_address }}</div>@endif
    </div>

    <table class="tbl mb-4">
        <tr><th>Produk</th><th>Harga</th><th>Qty</th><th>Subtotal</th></tr>
        @foreach($order->items as $i)
            <tr>
                <td>{{ $i->product->name }}</td>
                <td>{{ number_format($i->price,0,',','.') }}</td>
                <td>{{ $i->qty }}</td>
                <td>{{ number_format($i->price*$i->qty,0,',','.') }}</td>
            </tr>
        @endforeach
        <tr><th colspan="3">Diskon</th><th>{{ number_format($order->discount,0,',','.') }}</th></tr>
        <tr><th colspan="3">Total</th><th>Rp {{ number_format($order->total,0,',','.') }}</th></tr>
    </table>

    <form method="POST" action="{{ route('admin.transaksi.update', $order) }}" class="card flex flex-wrap gap-2 items-end">
        @csrf @method('PUT')
        <div><label>Status pesanan</label>
            <select name="status" class="input">
                @foreach(['pending','diproses','dikirim','selesai','batal'] as $s)
                    <option value="{{ $s }}" @selected($order->status==$s)>{{ $s }}</option>
                @endforeach
            </select></div>
        <div><label>Pembayaran</label>
            <select name="payment_status" class="input">
                <option value="unpaid" @selected($order->payment_status=='unpaid')>Belum dibayar</option>
                <option value="paid" @selected($order->payment_status=='paid')>Lunas</option>
            </select></div>
        <button class="btn">Simpan</button>
        <span class="text-sm text-gray-500">Membatalkan pesanan akan mengembalikan stok.</span>
    </form>
</x-toko-layout>