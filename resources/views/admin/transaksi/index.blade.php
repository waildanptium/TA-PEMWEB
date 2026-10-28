<x-toko-layout title="Transaksi">
    <h1 class="text-2xl font-bold mb-4">Semua Transaksi</h1>

    <form method="GET" class="flex gap-2 mb-4">
        <select name="channel" class="input"><option value="">Semua channel</option>
            <option value="pos" @selected(request('channel')=='pos')>POS (Kasir)</option>
            <option value="online" @selected(request('channel')=='online')>Online</option></select>
        <select name="status" class="input"><option value="">Semua status</option>
            @foreach(['pending','diproses','dikirim','selesai','batal'] as $s)
                <option value="{{ $s }}" @selected(request('status')==$s)>{{ $s }}</option>
            @endforeach</select>
        <button class="btn">Filter</button>
    </form>

    <table class="tbl">
        <tr><th>Invoice</th><th>Tanggal</th><th>Channel</th><th>Pelanggan/Kasir</th><th>Total</th><th>Bayar</th><th>Status</th><th></th></tr>
        @foreach($orders as $o)
            <tr>
                <td>{{ $o->invoice_no }}</td>
                <td>{{ $o->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $o->channel }}</td>
                <td>{{ $o->user->name ?? $o->cashier->name ?? '-' }}</td>
                <td>Rp {{ number_format($o->total,0,',','.') }}</td>
                <td>{{ $o->payment_status }}</td>
                <td><span class="badge">{{ $o->status }}</span></td>
                <td><a href="{{ route('admin.transaksi.show', $o) }}" class="btn btn-gray">Detail</a></td>
            </tr>
        @endforeach
    </table>
    <div class="mt-4">{{ $orders->links() }}</div>
</x-toko-layout>