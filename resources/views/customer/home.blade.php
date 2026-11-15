<x-toko-layout title="Beranda">
    <div class="space-y-12 pb-12">

        <!-- 1. HERO BANNER -->
        <section class="bg-gradient-to-r from-[#FDEBD0] to-[#FAD7A0]/60 rounded-3xl p-6 sm:p-10 md:p-12 flex flex-col md:flex-row items-center justify-between gap-8 border border-orange-100">
            <div class="max-w-lg space-y-4">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-[#382112] leading-tight">
                    Kebutuhan Sembako Harian Lebih Mudah!
                </h1>
                <p class="text-sm sm:text-base text-gray-600 leading-relaxed">
                    Belanja kebutuhan sehari-hari dengan harga terbaik. Cepat, segar, dan praktis langsung ke rumahmu.
                </p>
                <div class="pt-2">
                    <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold text-sm px-6 py-3 rounded-xl shadow-sm transition">
                        Belanja Sekarang
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>

            <!-- Kotak Ilustrasi Kanan (Simpan gambar keranjang dari Figma di public/images/hero-sembako.png) -->
        <div class="w-full md:w-[440px] h-64 rounded-2xl overflow-hidden shadow-sm border border-orange-100 shrink-0">
        <img src="{{ asset('images/hero-sembako.jpeg') }}" 
         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
         alt="Keranjang Sembako" 
         class="w-full h-full object-cover">
        <div style="display:none;" class="w-full h-full bg-white/85 flex-col items-center justify-center text-orange-400 text-center">
        <span class="text-5xl mb-2">🧺</span>
        <span class="text-xs font-medium">Toko Makmur Jaya</span>
             </div>
        </div>
        </section>

        <!-- 2. EMPAT BADGE KEUNGGULAN -->
        <section class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded-2xl border border-orange-100 flex items-center gap-3 shadow-xs">
                <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-500 flex items-center justify-center font-bold shrink-0">✓</div>
                <div>
                    <h4 class="font-bold text-xs sm:text-sm text-gray-800">Produk Lengkap</h4>
                    <p class="text-[11px] text-gray-400">Semua kebutuhan harian</p>
                </div>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-orange-100 flex items-center gap-3 shadow-xs">
                <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-500 flex items-center justify-center font-bold shrink-0">Rp</div>
                <div>
                    <h4 class="font-bold text-xs sm:text-sm text-gray-800">Harga Terjangkau</h4>
                    <p class="text-[11px] text-gray-400">Hemat setiap hari</p>
                </div>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-orange-100 flex items-center gap-3 shadow-xs">
                <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-500 flex items-center justify-center font-bold shrink-0">⚡</div>
                <div>
                    <h4 class="font-bold text-xs sm:text-sm text-gray-800">Pengiriman Cepat</h4>
                    <p class="text-[11px] text-gray-400">Langsung ke depan rumah</p>
                </div>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-orange-100 flex items-center gap-3 shadow-xs">
                <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-500 flex items-center justify-center font-bold shrink-0">★</div>
                <div>
                    <h4 class="font-bold text-xs sm:text-sm text-gray-800">Pembayaran Mudah</h4>
                    <p class="text-[11px] text-gray-400">COD, QRIS, & Transfer</p>
                </div>
            </div>
        </section>

            <!-- 3. KATEGORI PILIHAN -->
<section class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-lg sm:text-xl font-bold text-[#382112]">Kategori Pilihan</h2>
        <a href="{{ route('catalog') }}" class="text-xs sm:text-sm font-semibold text-orange-500 hover:underline">
            Lihat Semua &rarr;
        </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        @foreach($categories as $c)
            <a href="{{ route('catalog', ['category' => $c->id]) }}" class="bg-white hover:border-orange-400 border border-orange-100 rounded-2xl p-5 flex flex-col items-center justify-center gap-3 shadow-xs transition group">
                
                <!-- Kotak Gambar Kategori -->
                <div class="w-20 h-20 rounded-2xl bg-orange-50 group-hover:bg-orange-100 flex items-center justify-center p-2 overflow-hidden transition">
                    <img src="{{ asset('images/' . \Illuminate\Support\Str::slug($c->name) . '.png') }}" 
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                         alt="{{ $c->name }}" 
                         class="w-full h-full object-contain">
                    <!-- Ikon cadangan jika file gambar belum ada -->
                    <span style="display:none;" class="text-2xl">🛒</span>
                </div>

                <span class="font-semibold text-sm text-gray-700 group-hover:text-orange-600 text-center">
                    {{ $c->name }}
                </span>
            </a>
        @endforeach
    </div>
</section>

        <!-- 4. PRODUK TERLARIS / TERBARU -->
        <section class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-lg sm:text-xl font-bold text-[#382112]">Produk Terbaru</h2>
                <a href="{{ route('catalog') }}" class="text-xs sm:text-sm font-semibold text-orange-500 hover:underline">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                @foreach($latest as $p)
                    <x-product-card :product="$p" />
                @endforeach
            </div>
        </section>

        <!-- 5. PAKET HEMAT SETIAP HARI -->
        <section id="paket-hemat" class="bg-gradient-to-r from-[#FDEBD0] to-[#FAD7A0]/70 rounded-3xl p-6 sm:p-8 border border-orange-100 space-y-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="space-y-1.5 max-w-lg">
                    <h3 class="text-xl sm:text-2xl font-extrabold text-[#382112]">
                        Paket Hemat Setiap Hari!
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-600">
                        Beli kebutuhan pokok sekaligus dalam satu paket yang lebih hemat untuk keluarga.
                    </p>
                </div>

                <!-- 3 Ikon Bulat Dekorasi (Sesuai Figma) -->
                <div class="flex items-center gap-2.5 shrink-0">
                    <div class="w-11 h-11 rounded-full bg-green-100 border-2 border-white shadow-xs flex items-center justify-center text-lg">🥬</div>
                    <div class="w-11 h-11 rounded-full bg-red-100 border-2 border-white shadow-xs flex items-center justify-center text-lg">🍅</div>
                    <div class="w-11 h-11 rounded-full bg-orange-100 border-2 border-white shadow-xs flex items-center justify-center text-lg">🥕</div>
                </div>
            </div>

            <!-- Daftar Paket Hemat dari Database ($bundles) -->
            @if($bundles->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2">
                    @foreach($bundles as $b)
                        <div class="bg-white rounded-2xl p-5 border border-orange-100 shadow-xs flex flex-col justify-between">
                            <div>
                                <span class="inline-block bg-orange-100 text-orange-600 text-[11px] font-bold px-2.5 py-0.5 rounded-full mb-2">
                                    Paket Hemat
                                </span>
                                <h4 class="font-bold text-gray-800 text-base">{{ $b->name }}</h4>
                                <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                                    @foreach($b->items as $i)
                                        {{ $i->product->name }} x{{ $i->qty }}@if(!$loop->last), @endif
                                    @endforeach
                                </p>
                            </div>

                            <div class="mt-4 pt-3 border-t border-gray-100">
                                <div class="text-xs text-gray-400 line-through">
                                    Rp {{ number_format($b->normal_price, 0, ',', '.') }}
                                </div>
                                <div class="text-orange-500 font-extrabold text-lg">
                                    Rp {{ number_format($b->price, 0, ',', '.') }}
                                </div>

                                @if(!auth()->check() || auth()->user()->role === 'pelanggan')
                                    <form method="POST" action="{{ route('cart.bundle', $b) }}" class="mt-3">
                                        @csrf
                                        <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white text-xs font-semibold py-2.5 px-4 rounded-xl transition cursor-pointer">
                                            + Paket ke Keranjang
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

    </div>
</x-toko-layout>