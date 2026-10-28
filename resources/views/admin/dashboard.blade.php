<x-toko-layout title="Dashboard Admin">
    <h1 class="text-2xl font-bold mb-4">Dashboard Admin</h1>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        @foreach([
            ['Penjualan Hari Ini', 'Rp '.number_format($salesToday,0,',','.')],
            ['Transaksi Hari Ini', $trxToday],
            ['Keuntungan Hari Ini', 'Rp '.number_format($profitToday,0,',','.')],
            ['Produk Stok Menipis', $lowStock->count()],
        ] as [$label, $value])
            <div class="card">
                <div class="text-sm text-gray-500">{{ $label }}</div>
                <div class="text-xl font-bold">{{ $value }}</div>
            </div>
        @endforeach
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <h2 class="font-bold mb-2">Stok Menipis</h2>
            <table class="tbl">
                <tr><th>Produk</th><th>Stok</th><th>Minimum</th></tr>
                @forelse($lowStock as $p)
                    <tr><td>{{ $p->name }}</td><td>{{ $p->stock }}</td><td>{{ $p->min_stock }}</td></tr>
                @empty
                    <tr><td colspan="3">Semua stok aman.</td></tr>
                @endforelse
            </table>
        </div>
        <div>
            <h2 class="font-bold mb-2">Produk Terlaris</h2>
            <table class="tbl">
                <tr><th>Produk</th><th>Terjual</th></tr>
                @forelse($topProducts as $t)
                    <tr><td>{{ $t->product->name ?? '-' }}</td><td>{{ $t->total_qty }}</td></tr>
                @empty
                    <tr><td colspan="2">Belum ada penjualan.</td></tr>
                @endforelse
            </table>
        </div>
    </div>
</x-toko-layout>