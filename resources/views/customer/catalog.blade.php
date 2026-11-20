<x-toko-layout title="Katalog">
    <div class="space-y-6">
        <div>
            <p class="text-xs font-bold uppercase tracking-[.16em] text-[#d96908]">Toko Makmur Jaya</p>
            <h1 class="mt-1 text-3xl font-extrabold tracking-tight text-[#3b2415]">Temukan kebutuhanmu</h1>
            <p class="mt-2 text-sm text-[#806b58]">Pilih produk harian dengan harga yang bersahabat.</p>
        </div>

        <div class="grid gap-5 md:grid-cols-[230px_minmax(0,1fr)] lg:gap-7">
            <aside class="h-fit rounded-2xl border border-[#f0e2d3] bg-white p-4 shadow-[0_6px_20px_rgba(69,45,21,.05)]">
                <h2 class="text-sm font-extrabold text-[#3b2415]">Kategori</h2>
                <nav aria-label="Filter kategori" class="mt-3 space-y-1">
                    <a href="{{ route('catalog', request()->except('category')) }}" @class([
                        'flex items-center justify-between rounded-xl px-3 py-2.5 text-sm font-semibold transition',
                        'bg-[#fff0dc] text-[#c95f08]' => !request('category'),
                        'text-[#725b49] hover:bg-[#fff8ef] hover:text-[#c95f08]' => request('category'),
                    ])>
                        Semua produk <span class="text-xs">&rarr;</span>
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('catalog', array_merge(request()->query(), ['category' => $category->id])) }}" @class([
                            'flex items-center justify-between rounded-xl px-3 py-2.5 text-sm font-semibold transition',
                            'bg-[#fff0dc] text-[#c95f08]' => request('category') == $category->id,
                            'text-[#725b49] hover:bg-[#fff8ef] hover:text-[#c95f08]' => request('category') != $category->id,
                        ])>
                            {{ $category->name }} <span aria-hidden="true" class="text-xs">&rarr;</span>
                        </a>
                    @endforeach
                </nav>
            </aside>

            <section class="min-w-0 space-y-4">
                <form method="GET" class="grid grid-cols-2 gap-2 rounded-2xl border border-[#f0e2d3] bg-white p-3 shadow-[0_6px_20px_rgba(69,45,21,.05)] sm:grid-cols-6 sm:p-4">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <label class="col-span-2 sm:col-span-3">
                        <span class="sr-only">Cari produk</span>
                        <input name="q" value="{{ request('q') }}" placeholder="Cari produk..." class="w-full rounded-xl border border-[#eee2d5] bg-[#fffaf4] px-3 py-2.5 text-sm text-[#3b2415] placeholder:text-[#aa9989] focus:border-[#df9a59] focus:ring-[#df9a59]">
                    </label>
                    <label>
                        <span class="sr-only">Harga minimum</span>
                        <input type="number" name="min" value="{{ request('min') }}" placeholder="Harga min" class="w-full rounded-xl border border-[#eee2d5] bg-[#fffaf4] px-3 py-2.5 text-sm text-[#3b2415] placeholder:text-[#aa9989] focus:border-[#df9a59] focus:ring-[#df9a59]">
                    </label>
                    <label>
                        <span class="sr-only">Harga maksimum</span>
                        <input type="number" name="max" value="{{ request('max') }}" placeholder="Harga maks" class="w-full rounded-xl border border-[#eee2d5] bg-[#fffaf4] px-3 py-2.5 text-sm text-[#3b2415] placeholder:text-[#aa9989] focus:border-[#df9a59] focus:ring-[#df9a59]">
                    </label>
                    <label class="col-span-2 sm:col-span-2">
                        <span class="sr-only">Urutkan produk</span>
                        <select name="sort" class="w-full rounded-xl border border-[#eee2d5] bg-[#fffaf4] px-3 py-2.5 text-sm text-[#3b2415] focus:border-[#df9a59] focus:ring-[#df9a59]">
                            <option value="">Terbaru</option>
                            <option value="murah" @selected(request('sort') === 'murah')>Termurah</option>
                            <option value="mahal" @selected(request('sort') === 'mahal')>Termahal</option>
                        </select>
                    </label>
                    <button class="col-span-2 rounded-full bg-[#df6b08] px-5 py-2.5 text-sm font-bold text-white transition hover:bg-[#c95f08] sm:col-span-1">Cari</button>
                </form>

                <div class="flex items-center justify-between">
                    <h2 class="text-sm font-bold text-[#725b49]">Produk toko</h2>
                    <span class="text-xs text-[#9b8876]">{{ $products->total() }} produk</span>
                </div>
                <div class="grid grid-cols-2 gap-3 sm:gap-5 lg:grid-cols-3">
                    @forelse($products as $product)
                        <x-product-card :product="$product" />
                    @empty
                        <p class="col-span-full rounded-2xl border border-dashed border-[#e9c9a8] bg-white p-10 text-center text-sm text-[#806b58]">Produk tidak ditemukan. Coba ubah kata kunci atau filter pencarian.</p>
                    @endforelse
                </div>
                <div>{{ $products->links() }}</div>
            </section>
        </div>
    </div>
</x-toko-layout>
