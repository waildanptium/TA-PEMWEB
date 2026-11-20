<x-toko-layout title="Beranda">
    <div class="space-y-12 pb-8">
        <section class="relative isolate overflow-hidden rounded-[2rem] border border-orange-100 bg-gradient-to-br from-[#fff2df] via-[#ffead0] to-[#fbd9ad] px-6 py-10 sm:px-10 lg:flex lg:min-h-[390px] lg:items-center lg:justify-between lg:px-14">
            <div class="relative z-10 max-w-xl">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/80 px-4 py-2 text-xs font-bold uppercase tracking-[.16em] text-[#c95f08] shadow-sm">
                    Belanja mudah, harga bersahabat
                </span>
                <h1 class="mt-5 text-4xl font-extrabold leading-tight tracking-tight text-[#3b2415] sm:text-5xl">
                    Kebutuhan rumah, <span class="text-[#d96908]">lebih mudah</span> setiap hari.
                </h1>
                <p class="mt-4 max-w-lg text-sm leading-7 text-[#725b49] sm:text-base">
                    Temukan sembako dan kebutuhan harian pilihan dengan harga terbaik dari Toko Makmur Jaya.
                </p>
                <a href="{{ route('catalog') }}" class="mt-7 inline-flex items-center gap-3 rounded-full bg-[#df6b08] px-7 py-3.5 text-sm font-bold text-white shadow-[0_10px_24px_rgba(201,95,8,.25)] transition hover:-translate-y-0.5 hover:bg-[#c95f08]">
                    Masuk ke Toko
                    <span aria-hidden="true" class="text-lg">&rarr;</span>
                </a>
            </div>

            <div class="relative mt-8 h-56 w-full overflow-hidden rounded-3xl border-4 border-white/70 shadow-xl sm:h-72 lg:mt-0 lg:h-[300px] lg:w-[43%]">
                <img src="{{ asset('images/hero-sembako.jpeg') }}" alt="Pilihan kebutuhan sembako di Toko Makmur Jaya" class="h-full w-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-[#3b2415]/25 to-transparent"></div>
                <div class="absolute bottom-4 left-4 rounded-2xl bg-white/95 px-4 py-3 shadow-lg">
                    <p class="text-xs font-medium text-[#806b58]">Belanja kebutuhan harian</p>
                    <p class="mt-0.5 text-sm font-extrabold text-[#3b2415]">Cepat, praktis, hemat</p>
                </div>
            </div>
        </section>

        <section class="grid grid-cols-2 gap-3 sm:grid-cols-4 sm:gap-4">
            @foreach([
                ['icon' => '✓', 'title' => 'Produk lengkap', 'description' => 'Pilihan kebutuhan harian'],
                ['icon' => 'Rp', 'title' => 'Harga bersahabat', 'description' => 'Belanja tetap hemat'],
                ['icon' => '→', 'title' => 'Mudah dipesan', 'description' => 'Praktis dari rumah'],
                ['icon' => '★', 'title' => 'Belanja nyaman', 'description' => 'Layanan ramah untukmu'],
            ] as $benefit)
                <div class="flex items-center gap-3 rounded-2xl border border-orange-100 bg-white p-4 shadow-[0_4px_16px_rgba(69,45,21,.04)]">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#fff0dc] text-sm font-extrabold text-[#d96908]">{{ $benefit['icon'] }}</span>
                    <div>
                        <h2 class="text-xs font-bold text-[#3b2415] sm:text-sm">{{ $benefit['title'] }}</h2>
                        <p class="mt-1 text-[10px] leading-4 text-[#8b7968] sm:text-xs">{{ $benefit['description'] }}</p>
                    </div>
                </div>
            @endforeach
        </section>

        <section class="space-y-5">
            <div class="flex items-end justify-between gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[.16em] text-[#d96908]">Belanja sesuai kebutuhan</p>
                    <h2 class="mt-1 text-2xl font-extrabold tracking-tight text-[#3b2415]">Kategori pilihan</h2>
                </div>
                <a href="{{ route('catalog') }}" class="shrink-0 text-xs font-bold text-[#d96908] transition hover:text-[#a94f05] sm:text-sm">Lihat semua <span aria-hidden="true">&rarr;</span></a>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:grid-cols-4 sm:gap-4">
                @foreach($categories as $category)
                    <a href="{{ route('catalog', ['category' => $category->id]) }}" class="group flex items-center gap-3 rounded-2xl border border-orange-100 bg-white p-3 shadow-[0_4px_16px_rgba(69,45,21,.04)] transition hover:-translate-y-1 hover:border-[#edb477] hover:shadow-lg sm:gap-4 sm:p-4">
                        <span class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-[#fff5e8] p-2 sm:h-16 sm:w-16">
                            <img src="{{ asset('images/' . $category->slug . '.png') }}" alt="" class="h-full w-full object-contain transition group-hover:scale-105">
                        </span>
                        <span class="text-xs font-bold leading-5 text-[#4a3525] group-hover:text-[#c95f08] sm:text-sm">{{ $category->name }}</span>
                    </a>
                @endforeach
            </div>
        </section>

        <section class="space-y-5">
            <div class="flex items-end justify-between gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[.16em] text-[#d96908]">Baru tersedia di toko</p>
                    <h2 class="mt-1 text-2xl font-extrabold tracking-tight text-[#3b2415]">Produk terbaru</h2>
                </div>
                <a href="{{ route('catalog') }}" class="shrink-0 text-xs font-bold text-[#d96908] transition hover:text-[#a94f05] sm:text-sm">Lihat semua <span aria-hidden="true">&rarr;</span></a>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:gap-5 md:grid-cols-4">
                @forelse($latest as $product)
                    <x-product-card :product="$product" />
                @empty
                    <p class="col-span-full rounded-2xl border border-orange-100 bg-white p-8 text-center text-sm text-[#806b58]">Produk akan segera tersedia.</p>
                @endforelse
            </div>
        </section>

        <section id="paket-hemat" class="scroll-mt-24 space-y-6 rounded-[2rem] border border-[#f2d5b3] bg-[#fff7ed] p-5 sm:p-8 lg:p-10">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[.16em] text-[#d96908]">Pilihan lebih hemat</p>
                    <h2 class="mt-1 text-2xl font-extrabold tracking-tight text-[#3b2415] sm:text-3xl">Paket hemat</h2>
                    <p class="mt-2 max-w-xl text-sm leading-6 text-[#806b58]">Gabungkan kebutuhan pilihan dalam satu paket dan nikmati harga yang lebih bersahabat.</p>
                </div>
                <span class="inline-flex w-fit items-center gap-2 rounded-full bg-white px-4 py-2 text-xs font-bold text-[#c95f08] shadow-sm">
                    <span aria-hidden="true">✦</span> Pilihan spesial untukmu
                </span>
            </div>

            @if($bundles->isNotEmpty())
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
                    @foreach($bundles as $bundle)
                        @php
                            $discountPercent = $bundle->normal_price > 0
                                ? max(0, (int) floor((($bundle->normal_price - $bundle->price) / $bundle->normal_price) * 100))
                                : 0;
                            $expiringSoon = $bundle->items->contains(fn ($item) => $item->product->expiry_date?->betweenIncluded(now()->startOfDay(), now()->addDays(7)->endOfDay()));
                        @endphp
                        <article class="group overflow-hidden rounded-[1.5rem] border border-[#f1d8bd] bg-white shadow-[0_8px_24px_rgba(69,45,21,.06)] transition hover:-translate-y-1 hover:border-[#e99a4e] hover:shadow-[0_16px_34px_rgba(69,45,21,.12)]">
                            <div class="flex items-center justify-center gap-2 bg-[#fff6e9] px-4 py-4">
                                @foreach($bundle->items->take(3) as $item)
                                    @if(!$loop->first)
                                        <span aria-hidden="true" class="text-sm font-bold text-[#c6a889]">+</span>
                                    @endif
                                    <div class="flex h-[4.5rem] w-[4.5rem] items-center justify-center overflow-hidden rounded-2xl bg-[#f9ead8] p-2">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="" class="h-full w-full object-contain">
                                        @else
                                            <img src="{{ asset('images/' . $item->product->category->slug . '.png') }}" alt="" class="h-full w-full object-contain">
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <div class="p-5">
                                <div class="flex flex-wrap gap-2">
                                    @if($discountPercent > 0)
                                        <span class="rounded-full bg-[#df6b08] px-2.5 py-1 text-[10px] font-bold text-white">Hemat {{ $discountPercent }}%</span>
                                    @else
                                        <span class="rounded-full bg-[#fff0dc] px-2.5 py-1 text-[10px] font-bold text-[#c95f08]">Paket pilihan</span>
                                    @endif
                                    @if($expiringSoon)
                                        <span class="rounded-full bg-[#fff0ed] px-2.5 py-1 text-[10px] font-bold text-[#b74e42]">Exp ≤ 7 hari</span>
                                    @endif
                                </div>
                                <h3 class="mt-3 text-base font-extrabold text-[#3b2415] transition group-hover:text-[#c95f08]">{{ $bundle->name }}</h3>
                                <ul class="mt-2 space-y-1.5 text-xs leading-5 text-[#806b58]">
                                    @foreach($bundle->items as $item)
                                        <li class="flex gap-2"><span class="text-[#d96908]">•</span><span>{{ $item->product->name }} ×{{ $item->qty }}</span></li>
                                    @endforeach
                                </ul>

                                <div class="mt-4 flex items-end justify-between border-t border-[#f2e8de] pt-4">
                                    <div>
                                        @if($discountPercent > 0)
                                            <p class="text-xs text-[#a99a8c] line-through">Rp {{ number_format($bundle->normal_price, 0, ',', '.') }}</p>
                                        @endif
                                        <p class="mt-0.5 text-lg font-extrabold text-[#d96908]">Rp {{ number_format($bundle->price, 0, ',', '.') }}</p>
                                    </div>
                                    @if(!auth()->check() || auth()->user()->role === 'pelanggan')
                                        <form method="POST" action="{{ route('cart.bundle', $bundle) }}">
                                            @csrf
                                            <button type="submit" class="rounded-full bg-[#df6b08] px-4 py-2.5 text-xs font-bold text-white transition hover:bg-[#c95f08]">+ Keranjang</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="rounded-2xl border border-dashed border-[#e9c9a8] bg-white/70 px-6 py-8 text-center">
                    <p class="font-bold text-[#4a3525]">Paket hemat baru akan segera hadir.</p>
                    <a href="{{ route('catalog') }}" class="mt-3 inline-flex items-center gap-2 text-sm font-bold text-[#d96908] hover:text-[#a94f05]">Jelajahi produk <span aria-hidden="true">&rarr;</span></a>
                </div>
            @endif
        </section>
    </div>
</x-toko-layout>
