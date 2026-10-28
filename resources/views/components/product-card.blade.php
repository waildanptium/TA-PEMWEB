@props(['product'])
<div class="card flex flex-col">
    <a href="{{ route('catalog.show', $product) }}">
        @if($product->image)
            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-40 object-cover rounded mb-2">
        @else
            <div class="w-full h-40 bg-gray-200 rounded mb-2 flex items-center justify-center text-gray-500">Tanpa Foto</div>
        @endif
    </a>
    <div class="text-xs text-gray-500">{{ $product->category->name ?? '-' }}</div>
    <a href="{{ route('catalog.show', $product) }}" class="font-semibold">{{ $product->name }}</a>
    <div class="text-green-700 font-bold mb-2">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
    <div class="text-xs text-gray-500 mb-2">Stok: {{ $product->stock }}</div>

    @if(!auth()->check() || auth()->user()->role === 'pelanggan')
        @if($product->stock > 0)
            <form method="POST" action="{{ route('cart.store') }}" class="mt-auto">@csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="qty" value="1">
                <button class="btn w-full">+ Keranjang</button>
            </form>
        @else
            <span class="badge mt-auto">Stok habis</span>
        @endif
    @endif
</div>