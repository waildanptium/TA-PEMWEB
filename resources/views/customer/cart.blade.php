<x-toko-layout title="Keranjang">
    <h1 class="text-2xl font-bold mb-4">Keranjang</h1>

    @if($items->isEmpty())
        <div class="card">Keranjang kosong. <a href="{{ route('catalog') }}" class="underline text-green-700">Mulai belanja</a></div>
    @else
        <table class="tbl mb-4">
            <tr><th>Produk</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th><th></th></tr>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>Rp {{ number_format($item->product->price,0,',','.') }}</td>
                    <td>
                        <form method="POST" action="{{ route('cart.update', $item) }}" class="flex gap-1">
                            @csrf @method('PATCH')
                            <input type="number" name="qty" value="{{ $item->qty }}" min="1" max="{{ $item->product->stock }}" class="input" style="width:5rem">
                            <button class="btn btn-gray">Ubah</button>
                        </form>
                    </td>
                    <td>Rp {{ number_format($item->qty * $item->product->price,0,',','.') }}</td>
                    <td>
                        <form method="POST" action="{{ route('cart.destroy', $item) }}">@csrf @method('DELETE')
                            <button class="btn btn-red">Hapus</button></form>
                    </td>
                </tr>
            @endforeach
        </table>
        <div class="card flex items-center justify-between">
            <div class="text-xl font-bold">Total: Rp {{ number_format($total,0,',','.') }}</div>
            <a href="{{ route('checkout') }}" class="btn">Checkout</a>
        </div>
    @endif
</x-toko-layout>