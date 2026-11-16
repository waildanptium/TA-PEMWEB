@props(['product'])
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
