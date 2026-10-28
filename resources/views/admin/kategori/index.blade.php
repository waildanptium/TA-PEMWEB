<x-toko-layout title="Kategori">
    <h1 class="text-2xl font-bold mb-4">Kategori</h1>

    <form method="POST" action="{{ route('admin.kategori.store') }}" class="flex gap-2 mb-4">
        @csrf
        <input name="name" required placeholder="Nama kategori baru" class="input">
        <button class="btn">Tambah</button>
    </form>

    <table class="tbl">
        <tr><th>Nama</th><th>Jumlah Produk</th><th></th></tr>
        @foreach($categories as $c)
            <tr>
                <td>{{ $c->name }}</td>
                <td>{{ $c->products_count }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.kategori.destroy', $c) }}" onsubmit="return confirm('Hapus kategori ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-red">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
</x-toko-layout>