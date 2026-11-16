@props(['product'])
<<<<<<< HEAD
<div class="card flex flex-col justify-between border border-orange-100 transition-all duration-200 hover:-translate-y-1 hover:shadow-lg hover:border-orange-300 active:scale-[0.98] group">
    <a href="{{ route('catalog.show', $product) }}">
        @if($product->image)
            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-40 object-cover rounded mb-2" transition-transform duration-300 group-hover:scale-105>
        @else
            <div class="w-full h-40 bg-gray-200 rounded mb-2 flex items-center justify-center text-gray-500">Tanpa Foto</div>
        @endif
    </a>
    <div class="text-xs text-gray-500">{{ $product->category->name ?? '-' }}</div>
    <a href="{{ route('catalog.show', $product) }}" class="font-semibold">{{ $product->name }}</a>
    <div class="text-orange-500 font-bold mb-2">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
    <div class="text-xs text-gray-500 mb-2">Stok: {{ $product->stock }}</div>
=======
<article class="group flex h-full flex-col overflow-hidden rounded-2xl border border-[#f0e2d3] bg-white shadow-[0_6px_20px_rgba(69,45,21,.05)] transition hover:-translate-y-1 hover:border-[#edb477] hover:shadow-[0_14px_28px_rgba(69,45,21,.12)]">
    <a href="{{ route('catalog.show', $product) }}" class="relative block overflow-hidden bg-[#fff5e8]">
        <div class="flex h-36 items-center justify-center p-5 sm:h-44">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-contain transition duration-300 group-hover:scale-105">
            @else
                <img src="{{ asset('images/' . $product->category->slug . '.png') }}" alt="{{ $product->category->name }}" class="h-full w-full object-contain transition duration-300 group-hover:scale-105">
            @endif
        </div>
        @if($product->discount_percent > 0)
            <span class="absolute left-3 top-3 rounded-full bg-[#df6b08] px-2.5 py-1 text-[10px] font-bold text-white">Diskon {{ $product->discount_percent }}%</span>
        @endif
    </a>
>>>>>>> 1e9ba5ee7ee1179199205be0935c4bbf8eb58656

    <div class="flex flex-1 flex-col p-3.5 sm:p-4">
        <span class="text-[10px] font-bold uppercase tracking-[.12em] text-[#a48c76]">{{ $product->category->name ?? 'Produk' }}</span>
        <a href="{{ route('catalog.show', $product) }}" class="mt-1.5 line-clamp-2 min-h-10 text-sm font-bold leading-5 text-[#3b2415] transition hover:text-[#c95f08]">{{ $product->name }}</a>
        <div class="mt-2">
            @if($product->discount_percent > 0)
                <p class="text-[11px] text-[#a99a8c] line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            @endif
            <p class="text-sm font-extrabold text-[#d96908]">Rp {{ number_format($product->final_price, 0, ',', '.') }}</p>
        </div>
        <p class="mt-1 text-[11px] text-[#9b8876]">Stok: {{ $product->stock }}</p>

        @if(!auth()->check() || auth()->user()->role === 'pelanggan')
            @if($product->stock > 0)
                <form method="POST" action="{{ route('cart.store') }}" class="mt-auto pt-3">@csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="qty" value="1">
                    <button type="submit" class="w-full rounded-full bg-[#fff0dc] px-3 py-2.5 text-xs font-bold text-[#c95f08] transition hover:bg-[#df6b08] hover:text-white">+ Keranjang</button>
                </form>
            @else
                <span class="mt-auto block rounded-full bg-[#f7f2ec] px-3 py-2.5 text-center text-xs font-semibold text-[#9b8876]">Stok habis</span>
            @endif
        @endif
    </div>
</article>
