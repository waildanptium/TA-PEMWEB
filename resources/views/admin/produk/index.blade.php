<x-toko-layout title="Produk">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Produk</h1>
        <a href="{{ route('admin.produk.create') }}" class="btn">+ Tambah Produk</a>
    </div>

    <form method="GET" class="mb-4"><input name="q" value="{{ request('q') }}" placeholder="Cari nama / kode..." class="input"></form>

    <table class="tbl">
        <tr><th>Kode</th><th>Nama</th><th>Kategori</th><th>Modal</th><th>Harga</th><th>Stok</th><th>Status</th><th></th></tr>
        @foreach($products as $p)
            <tr>
                <td>{{ $p->code }}</td>
                <td>{{ $p->name }}</td>
                <td>{{ $p->category->name ?? '-' }}</td>
                <td>{{ number_format($p->cost_price,0,',','.') }}</td>
                <td>{{ number_format($p->price,0,',','.') }}</td>
                <td>{{ $p->stock }}</td>
                <td><span class="badge">{{ $p->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                <td class="flex gap-1">
                    <a href="{{ route('admin.produk.edit', $p) }}" class="btn btn-gray">Edit</a>
                    <form method="POST" action="{{ route('admin.produk.destroy', $p) }}" onsubmit="return confirm('Hapus produk?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-red">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    <div class="mt-4">{{ $products->links() }}</div>
</x-toko-layout>