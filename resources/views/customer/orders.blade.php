<x-toko-layout title="Pesanan Saya">
    <h1 class="text-2xl font-bold mb-4">Pesanan Saya</h1>
    <table class="tbl">
        <tr><th>Invoice</th><th>Tanggal</th><th>Total</th><th>Bayar</th><th>Status</th><th></th></tr>
        @forelse($orders as $o)
            <tr>
                <td>{{ $o->invoice_no }}</td>
                <td>{{ $o->created_at->format('d/m/Y H:i') }}</td>
                <td>Rp {{ number_format($o->total,0,',','.') }}</td>
                <td>{{ $o->payment_status == 'paid' ? 'Lunas' : 'Belum dibayar' }}</td>
                <td><span class="badge">{{ $o->status }}</span></td>
                <td><a href="{{ route('orders.show', $o) }}" class="btn btn-gray">Detail</a></td>
            </tr>
        @empty
            <tr><td colspan="6">Belum ada pesanan.</td></tr>
        @endforelse
    </table>
    <div class="mt-4">{{ $orders->links() }}</div>
</x-toko-layout>