<x-toko-layout title="Katalog">
    <h1 class="text-2xl font-bold mb-4">Katalog Produk</h1>

    <form method="GET" class="grid grid-cols-2 md:grid-cols-6 gap-2 mb-4">
        <input name="q" value="{{ request('q') }}" placeholder="Cari produk..." class="input md:col-span-2">
        <select name="category" class="input"><option value="">Semua kategori</option>
            @foreach($categories as $c)<option value="{{ $c->id }}" @selected(request('category')==$c->id)>{{ $c->name }}</option>@endforeach</select>
        <input type="number" name="min" value="{{ request('min') }}" placeholder="Harga min" class="input">
        <input type="number" name="max" value="{{ request('max') }}" placeholder="Harga max" class="input">
        <select name="sort" class="input">
            <option value="">Terbaru</option>
            <option value="murah" @selected(request('sort')=='murah')>Termurah</option>
            <option value="mahal" @selected(request('sort')=='mahal')>Termahal</option>
        </select>
        <button class="btn">Cari</button>
    </form>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @forelse($products as $p)<x-product-card :product="$p" />@empty<p>Produk tidak ditemukan.</p>@endforelse
    </div>
    <div class="mt-4">{{ $products->links() }}</div>
</x-toko-layout>