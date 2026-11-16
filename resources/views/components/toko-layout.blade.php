@props(['title' => 'Beranda'])
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} - Toko Makmur Jaya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .btn{background:#15803d;color:#fff;padding:.5rem 1rem;border-radius:.375rem;display:inline-block;border:0;cursor:pointer;text-decoration:none}
        .btn-red{background:#b91c1c}.btn-gray{background:#6b7280}
        .input{border:1px solid #d1d5db;border-radius:.375rem;padding:.5rem .75rem;width:100%;background:#fff}
        .card{background:#fff;border-radius:.5rem;box-shadow:0 1px 3px rgba(0,0,0,.1);padding:1rem}
        .tbl{width:100%;background:#fff;border-radius:.5rem;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.1)}
        .tbl th,.tbl td{padding:.5rem .75rem;text-align:left;border-bottom:1px solid #e5e7eb}
        .tbl th{background:#f9fafb}
        .badge{background:#e5e7eb;border-radius:9999px;padding:.1rem .6rem;font-size:.8rem}
    </style>
</head>
<body class="min-h-screen bg-[#fffaf4] text-[#3b2415] antialiased">
<nav class="sticky top-0 z-30 border-b border-[#f2e7db] bg-white/95 backdrop-blur">
    <div class="mx-auto flex max-w-7xl flex-wrap items-center gap-x-6 gap-y-3 px-4 py-3 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-3" aria-label="Toko Makmur Jaya, beranda">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#df6b08] text-lg font-extrabold text-white shadow-sm">M</span>
            <span class="leading-tight">
                <span class="block text-sm font-extrabold tracking-tight text-[#3b2415] sm:text-base">Makmur Jaya</span>
                <span class="hidden text-[10px] font-medium tracking-wide text-[#9b8876] sm:block">TOKO KEBUTUHAN HARIAN</span>
            </span>
        </a>

        @auth
            @if(auth()->user()->role === 'admin')
                <div class="order-3 flex w-full flex-wrap gap-x-5 gap-y-2 text-xs font-semibold text-[#725b49] sm:order-none sm:w-auto sm:text-sm">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-[#d96908]">Dashboard</a>
                    <a href="{{ route('admin.produk.index') }}" class="hover:text-[#d96908]">Produk</a>
                    <a href="{{ route('admin.kategori.index') }}" class="hover:text-[#d96908]">Kategori</a>
                    <a href="{{ route('admin.pegawai.index') }}" class="hover:text-[#d96908]">Pegawai</a>
                    <a href="{{ route('admin.transaksi.index') }}" class="hover:text-[#d96908]">Transaksi</a>
                    <a href="{{ route('kasir.pos') }}" class="hover:text-[#d96908]">POS</a>
                </div>
            @elseif(auth()->user()->role === 'kasir')
                <div class="order-3 flex w-full flex-wrap gap-x-5 gap-y-2 text-xs font-semibold text-[#725b49] sm:order-none sm:w-auto sm:text-sm">
                    <a href="{{ route('kasir.dashboard') }}" class="hover:text-[#d96908]">Dashboard</a>
                    <a href="{{ route('kasir.pos') }}" class="hover:text-[#d96908]">POS</a>
                    <a href="{{ route('kasir.history') }}" class="hover:text-[#d96908]">Riwayat</a>
                </div>
            @else
                <div class="order-3 flex w-full items-center gap-5 text-sm font-semibold text-[#725b49] sm:order-none sm:w-auto">
                    <a href="{{ route('home') }}" class="hover:text-[#d96908]">Beranda</a>
                    <a href="{{ route('catalog') }}" class="hover:text-[#d96908]">Produk</a>
                    <a href="{{ route('home') }}#paket-hemat" class="hover:text-[#d96908]">Paket Hemat</a>
                </div>
            @endif
        @else
            <div class="order-3 flex w-full items-center gap-5 text-sm font-semibold text-[#725b49] sm:order-none sm:w-auto">
                <a href="{{ route('home') }}" class="hover:text-[#d96908]">Beranda</a>
                <a href="{{ route('catalog') }}" class="hover:text-[#d96908]">Produk</a>
                <a href="{{ route('home') }}#paket-hemat" class="hover:text-[#d96908]">Paket Hemat</a>
            </div>
        @endauth

        @if(!auth()->check() || auth()->user()->role === 'pelanggan')
            <form method="GET" action="{{ route('catalog') }}" class="order-2 ml-auto hidden min-w-48 flex-1 sm:order-none sm:flex sm:max-w-xs">
                <label for="shop-search" class="sr-only">Cari produk</label>
                <div class="flex w-full items-center rounded-full border border-[#eee2d5] bg-[#fffaf4] px-4 focus-within:border-[#df9a59]">
                    <svg aria-hidden="true" class="h-4 w-4 shrink-0 text-[#9b8876]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <circle cx="11" cy="11" r="7" stroke-width="1.8"></circle>
                        <path d="m16 16 4 4" stroke-linecap="round" stroke-width="1.8"></path>
                    </svg>
                    <input id="shop-search" type="search" name="q" value="{{ request('q') }}" placeholder="Cari kebutuhanmu..." class="w-full border-0 bg-transparent px-3 py-2.5 text-xs text-[#3b2415] outline-none ring-0 placeholder:text-[#aa9989] focus:ring-0">
                </div>
            </form>
        @endif

        <div class="ml-auto flex shrink-0 items-center gap-2 sm:gap-3">
            @auth
                @if(auth()->user()->role === 'pelanggan')
                    <a href="{{ route('cart') }}" class="rounded-full border border-[#f0dfcd] px-3 py-2 text-xs font-bold text-[#725b49] transition hover:border-[#df9a59] hover:text-[#c95f08] sm:text-sm">Keranjang</a>
                    <a href="{{ route('orders') }}" class="hidden text-sm font-semibold text-[#725b49] hover:text-[#d96908] md:inline">Pesanan</a>
                @endif
                <a href="{{ route('profile.edit') }}" class="hidden max-w-32 truncate text-sm font-semibold text-[#725b49] hover:text-[#d96908] lg:block">{{ auth()->user()->name }}</a>
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <button class="rounded-full bg-[#df6b08] px-4 py-2.5 text-xs font-bold text-white transition hover:bg-[#c95f08] sm:text-sm">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="rounded-full px-3 py-2 text-xs font-bold text-[#725b49] transition hover:text-[#d96908] sm:px-4 sm:text-sm">Masuk</a>
                <a href="{{ route('register') }}" class="rounded-full bg-[#df6b08] px-4 py-2.5 text-xs font-bold text-white shadow-sm transition hover:bg-[#c95f08] sm:px-5 sm:text-sm">Daftar</a>
            @endauth
        </div>
    </div>
</nav>

<main class="mx-auto min-h-[65vh] max-w-7xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
    @if(session('success'))<div class="mb-4 rounded-2xl border border-green-200 bg-green-50 p-3 text-sm text-green-800">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="mb-4 rounded-2xl border border-red-200 bg-red-50 p-3 text-sm text-red-800">{{ session('error') }}</div>@endif
    @if($errors->any())
        <div class="mb-4 rounded-2xl border border-red-200 bg-red-50 p-3 text-sm text-red-800">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
    @endif

    {{ $slot }}
</main>

<footer class="mt-10 border-t border-[#f2e7db] bg-white">
    <div class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-7 text-center sm:px-6 sm:text-left lg:px-8">
        <span class="text-sm font-extrabold text-[#3b2415]">Toko Makmur Jaya</span>
        <span class="text-xs text-[#9b8876]">&copy; {{ date('Y') }} — Kebutuhan harian untuk keluarga Indonesia.</span>
    </div>
</footer>
</body>
</html>