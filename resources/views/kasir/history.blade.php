<x-toko-layout title="Riwayat Transaksi">
    <h1 class="text-2xl font-bold mb-4">Riwayat Transaksi Saya</h1>
    <table class="tbl">
        <tr><th>Invoice</th><th>Waktu</th><th>Metode</th><th>Total</th><th></th></tr>
        @forelse($orders as $o)
            <tr>
                <td>{{ $o->invoice_no }}</td>
                <td>{{ $o->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $o->payment_method }}</td>
                <td>Rp {{ number_format($o->total,0,',','.') }}</td>
                <td><a href="{{ route('kasir.receipt', $o) }}" class="btn btn-gray">Struk</a></td>
            </tr>
        @empty
            <tr><td colspan="5">Belum ada transaksi.</td></tr>
        @endforelse
    </table>
    <div class="mt-4">{{ $orders->links() }}</div>
</x-toko-layout>