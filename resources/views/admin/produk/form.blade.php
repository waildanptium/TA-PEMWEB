<x-toko-layout title="Form Produk">
    <h1 class="text-2xl font-bold mb-4">{{ $product->exists ? 'Edit' : 'Tambah' }} Produk</h1>

    <form method="POST" enctype="multipart/form-data" class="card grid md:grid-cols-2 gap-4"
          action="{{ $product->exists ? route('admin.produk.update', $product) : route('admin.produk.store') }}">
        @csrf
        @if($product->exists) @method('PUT') @endif

        <div>
            <label>Kategori</label>
            <select name="category_id" class="input" required>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" @selected(old('category_id', $product->category_id) == $c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div><label>Kode Produk / Barcode</label><input name="code" class="input" required value="{{ old('code', $product->code) }}"></div>
        <div class="md:col-span-2"><label>Nama Produk</label><input name="name" class="input" required value="{{ old('name', $product->name) }}"></div>
        <div class="md:col-span-2"><label>Deskripsi</label><textarea name="description" rows="3" class="input">{{ old('description', $product->description) }}</textarea></div>
        <div><label>Harga Modal</label><input type="number" name="cost_price" min="0" class="input" required value="{{ old('cost_price', $product->cost_price) }}"></div>
        <div><label>Harga Jual</label><input type="number" name="price" min="0" class="input" required value="{{ old('price', $product->price) }}"></div>
        <div><label>Stok</label><input type="number" name="stock" min="0" class="input" required value="{{ old('stock', $product->stock ?? 0) }}"></div>
        <div><label>Stok Minimum</label><input type="number" name="min_stock" min="0" class="input" required value="{{ old('min_stock', $product->min_stock ?? 5) }}"></div>
        <div>
            <label>Foto Produk</label>
            <input type="file" name="image" accept="image/*" class="input">
            @if($product->image)<img src="{{ asset('storage/'.$product->image) }}" class="h-20 mt-2 rounded">@endif
        </div>
        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', $product->exists ? $product->is_active : true))>
            <label for="is_active">Produk aktif (tampil di toko)</label>
        </div>
        <div class="md:col-span-2 flex gap-2">
            <button class="btn">Simpan</button>
            <a href="{{ route('admin.produk.index') }}" class="btn btn-gray">Batal</a>
        </div>
    </form>
</x-toko-layout>