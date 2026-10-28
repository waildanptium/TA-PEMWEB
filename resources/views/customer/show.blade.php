<x-toko-layout :title="$product->name">
    <div class="card grid md:grid-cols-2 gap-6">
        <div>
            @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" class="w-full rounded">
            @else
                <div class="w-full h-64 bg-gray-200 rounded flex items-center justify-center text-gray-500">Tanpa Foto</div>
            @endif
        </div>
        <div>
            <div class="text-sm text-gray-500">{{ $product->category->name }}</div>
            <h1 class="text-2xl font-bold">{{ $product->name }}</h1>
            <div class="text-2xl text-green-700 font-bold my-2">Rp {{ number_format($product->price,0,',','.') }}</div>
            <p class="mb-2">{{ $product->description }}</p>
            <p class="text-sm text-gray-500 mb-4">Stok: {{ $product->stock }}</p>

            @if(!auth()->check() || auth()->user()->role === 'pelanggan')
                @if($product->stock > 0)
                    <form method="POST" action="{{ route('cart.store') }}" class="flex gap-2">@csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="number" name="qty" value="1" min="1" max="{{ $product->stock }}" class="input" style="width:6rem">
                        <button class="btn">Tambah ke Keranjang</button>
                    </form>
                @else
                    <span class="badge">Stok habis</span>
                @endif
            @endif
        </div>
    </div>
</x-toko-layout>