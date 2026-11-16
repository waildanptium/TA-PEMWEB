<x-toko-layout title="Katalog">
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