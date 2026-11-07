<x-toko-layout title="Dashboard Admin">
    <h1 class="text-2xl font-bold mb-4">Dashboard Admin</h1>

    @if($discounts->isNotEmpty())
    <div class="mb-4 p-3 rounded bg-yellow-100 text-yellow-800">
        {{ $discounts->count() }} produk mendekati atau melewati kadaluwarsa.
    </div>
    @endif

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

    <h2 class="font-bold mt-6 mb-2">Mendekati Kadaluwarsa dan Saran Diskon</h2>
    <table class="tbl">
        <tr><th>Produk</th><th>Kadaluwarsa</th><th>Sisa hari</th><th>Stok</th><th>Harga</th><th>Saran diskon</th><th>Harga baru</th><th>Catatan</th><th>Aksi</th></tr>
        @forelse($discounts as $d)
            <tr>
                <td>{{ $d->product->name }}</td>
                <td>{{ $d->product->expiry_date->format('d/m/Y') }}</td>
                <td>{{ $d->days }}</td>
                <td>{{ $d->product->stock }}</td>
                <td>{{ number_format($d->product->price,0,',','.') }}</td>
                <td>{{ $d->percent }}%</td>
                <td>{{ number_format($d->new_price,0,',','.') }}</td>
                <td>{{ $d->note }}</td>
                <td>
                    @if($d->percent > 0 && $d->product->discount_percent != $d->percent)
                        <form method="POST" action="{{ route('admin.diskon.store', $d->product) }}">@csrf
                            <input type="hidden" name="percent" value="{{ $d->percent }}">
                            <button class="btn">Terapkan</button>
                        </form>
                    @endif
                    @if($d->product->discount_percent > 0)
                        <form method="POST" action="{{ route('admin.diskon.destroy', $d->product) }}">@csrf @method('DELETE')
                            <span class="badge">Aktif {{ $d->product->discount_percent }}%</span>
                            <button class="btn btn-gray">Cabut</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="9">Tidak ada produk mendekati kadaluwarsa.</td></tr>
        @endforelse
    </table>

    <h2 class="font-bold mt-6 mb-2">Rekomendasi Paket Hemat</h2>
    <table class="tbl">
        <tr><th>Paket</th><th>Dibeli bersama</th><th>Harga normal</th><th>Harga paket</th><th>Hemat</th><th></th></tr>
        @forelse($bundles as $b)
            <tr>
                <td>{{ $b->a->name }} + {{ $b->b->name }}</td>
                <td>{{ $b->freq }}x</td>
                <td>{{ number_format($b->normal,0,',','.') }}</td>
                <td>{{ number_format($b->bundle,0,',','.') }}</td>
                <td>{{ number_format($b->saving,0,',','.') }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.paket.store') }}">@csrf
                        <input type="hidden" name="p1" value="{{ $b->a->id }}">
                        <input type="hidden" name="p2" value="{{ $b->b->id }}">
                        <input type="hidden" name="price" value="{{ $b->bundle }}">
                        <button class="btn">Buat paket</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6">Belum cukup data. Butuh pasangan produk yang dibeli bersama minimal 2 kali.</td></tr>
        @endforelse
    </table>

    <h2 class="font-bold mt-6 mb-2">Paket Aktif</h2>
    <table class="tbl">
        <tr><th>Paket</th><th>Harga paket</th><th>Harga normal</th><th></th></tr>
        @forelse($activeBundles as $pk)
            <tr>
                <td>{{ $pk->name }}</td>
                <td>{{ number_format($pk->price,0,',','.') }}</td>
                <td>{{ number_format($pk->normal_price,0,',','.') }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.paket.destroy', $pk) }}" onsubmit="return confirm('Hapus paket?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-red">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4">Belum ada paket.</td></tr>
        @endforelse
    </table>
</x-toko-layout>