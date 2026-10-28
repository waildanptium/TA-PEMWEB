<x-toko-layout title="Beranda">
    <div class="rounded-lg bg-green-700 text-white p-8 mb-6">
        <h1 class="text-3xl font-bold">Selamat datang di Toko Makmur Jaya</h1>
        <p class="mt-2">Belanja kebutuhan sehari-hari dengan harga terbaik.</p>
        <a href="{{ route('catalog') }}" class="btn mt-4" style="background:#fff;color:#15803d">Belanja Sekarang</a>
    </div>

    <h2 class="font-bold text-lg mb-2">Kategori</h2>
    <div class="flex flex-wrap gap-2 mb-6">
        @foreach($categories as $c)
            <a href="{{ route('catalog', ['category' => $c->id]) }}" class="badge">{{ $c->name }}</a>
        @endforeach
    </div>

    <h2 class="font-bold text-lg mb-2">Produk Terbaru</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($latest as $p)<x-product-card :product="$p" />@endforeach
    </div>
</x-toko-layout>