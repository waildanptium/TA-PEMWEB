<x-toko-layout title="Dashboard Kasir">
    <h1 class="text-2xl font-bold mb-4">Dashboard Kasir</h1>
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div class="card"><div class="text-sm text-gray-500">Transaksi Saya Hari Ini</div><div class="text-xl font-bold">{{ $count }}</div></div>
        <div class="card"><div class="text-sm text-gray-500">Total Penjualan Saya</div><div class="text-xl font-bold">Rp {{ number_format($total,0,',','.') }}</div></div>
    </div>
    <a href="{{ route('kasir.pos') }}" class="btn mb-6">Buka POS</a>

    <h2 class="font-bold mb-2">Info Stok Menipis</h2>
    <table class="tbl">
        <tr><th>Produk</th><th>Stok</th></tr>
        @forelse($lowStock as $p)<tr><td>{{ $p->name }}</td><td>{{ $p->stock }}</td></tr>
        @empty<tr><td colspan="2">Semua stok aman.</td></tr>@endforelse
    </table>
</x-toko-layout>