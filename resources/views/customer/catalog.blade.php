<x-toko-layout title="Katalog">
<<<<<<< HEAD
    @php
        $hasActiveFilter = request()->filled('category') || request()->filled('min') || request()->filled('max') || request()->filled('sort');
    @endphp

    <div x-data="{ openFilter: {{ $hasActiveFilter ? 'true' : 'false' }} }" class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#382112] mb-4">Semua Produk</h1>

        <form method="GET" action="{{ route('catalog') }}" class="space-y-3">
            <!-- BARIS UTAMA: Search Bar Kapsul + Tombol Filter Sejajar Mendatar -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                <!-- Search Bar Panjang -->
                <div class="flex-1 flex items-center bg-white rounded-full border border-orange-200 p-1.5 pl-5 shadow-xs focus-within:border-orange-500 focus-within:ring-2 focus-within:ring-orange-500/20 transition">
                    <svg class="w-4 h-4 text-gray-400 mr-2.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M17 11a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z"/>
                    </svg>
                    <input type="text" name="q" value="{{ request('q') }}"
                           placeholder="Cari beras, minyak, gula, mie..."
                           class="w-full border-0 bg-transparent text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-0">
                    <button type="submit" class="btn py-2 px-6 text-sm shrink-0">Cari</button>
                </div>

                <!-- Tombol Trigger Filter (Ramping, Sejajar Mendatar, Krem Bertepi Oranye) -->
                <button type="button" @click="openFilter = !openFilter"
                    style="display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;"
                    class="bg-[#FFF7ED] text-[#F97316] border-[1.5px] border-[#ff944a] hover:bg-[#ff944a] hover:text-white active:scale-95 py-3 px-6 rounded-full text-sm font-[650] shrink-0 cursor-pointer transition-all duration-200">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75"/>
                </svg>
                <span>Filter</span>
                @if($hasActiveFilter)
                    <span class="w-2 h-2 rounded-full bg-orange-500 group-hover:bg-white"></span>
                @endif
            </button>
            </div>

            <!-- PANEL FILTER LIPAT (Muncul saat tombol Filter diklik) -->
            <div x-show="openFilter" x-transition
                 class="bg-white rounded-2xl border border-orange-100 p-4 shadow-xs grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3 items-end">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Kategori</label>
                    <select name="category" class="w-full rounded-xl border border-orange-200 px-3 py-2 text-sm bg-white focus:outline-none focus:border-orange-500">
                        <option value="">Semua kategori</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}" @selected(request('category') == $c->id)>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Harga min</label>
                    <input type="number" name="min" value="{{ request('min') }}" placeholder="Rp 0"
                           class="w-full rounded-xl border border-orange-200 px-3 py-2 text-sm focus:outline-none focus:border-orange-500">
                           
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Harga max</label>
                    <input type="number" name="max" value="{{ request('max') }}" placeholder="Rp 100.000"
                           class="w-full rounded-xl border border-orange-200 px-3 py-2 text-sm focus:outline-none focus:border-orange-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Urutkan</label>
                    <select name="sort" class="w-full rounded-xl border border-orange-200 px-3 py-2 text-sm bg-white focus:outline-none focus:border-orange-500">
                        <option value="">Terbaru</option>
                        <option value="murah" @selected(request('sort') == 'murah')>Termurah</option>
                        <option value="mahal" @selected(request('sort') == 'mahal')>Termahal</option>
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="btn flex-1 py-2 text-xs">Terapkan</button>
                    <a href="{{ route('catalog') }}"
                    style="display: inline-flex; align-items: center; justify-content: center;"
                    class="bg-[#FFF7ED] text-[#F97316] border-[1.5px] border-[#ff944a] hover:bg-[#ff944a] hover:text-white active:scale-95 py-2 px-3 rounded-full text-xs font-[650] text-center transition-all duration-200">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- DAFTAR PRODUK -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @forelse($products as $p)
            <x-product-card :product="$p" />
        @empty
            <p class="col-span-full text-center text-gray-500 py-8">Produk tidak ditemukan.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $products->links() }}</div>
</x-toko-layout>
=======
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
>>>>>>> 1e9ba5ee7ee1179199205be0935c4bbf8eb58656
