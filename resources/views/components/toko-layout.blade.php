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
        .btn{background:#f97316;color:#fff;padding:0.55rem 1.5rem;border-radius:9999px;font-weight:620;display:inline-block;border:0;cursor:pointer;text-decoration:none}
        .btn:hover{background:#e06d06}
        .btn-red{background:#b91c1c}.btn-gray{background:#6b7280}
        .btn-white {background: #ffffff;color: #F97316;border: 1.5px solid #F97316;padding: 0.4rem 1.25rem;font-size: 0.85rem;transition: all 0.2s ease;}
        .btn-white:hover {background: #F97316;color: #fff;}
        .input{border:1px solid #fed7aa;border-radius:0.75rem;padding:0.65rem 1rem;width:100%;background:#fff;transition: border-color 0.2s, box-shadow 0.2s}
        .input:focus {outline:none;border-color:#f97316;box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.15);}
        .card{background:#fff;border-radius:0.75rem;box-shadow:0 1px 3px rgba(0,0,0,.1);padding:1rem}
        .tbl{width:100%;background:#fff;border-radius:.5rem;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.1)}
        .tbl th,.tbl td{padding:.5rem .75rem;text-align:left;border-bottom:1px solid #e5e7eb}
        .tbl th{background:#f9fafb}
        .badge{background:#e5e7eb;border-radius:9999px;padding:.1rem .6rem;font-size:.8rem}
        nav a:not(.btn):not(.text-orange-400) {font-weight: 600;color: #4b5563;padding: 0.45rem 0.85rem;border-radius: 9999px;transition: all 0.2s ease;}
        nav a:not(.btn):not(.text-orange-400):hover {color: #f97316;background-color: #fff7ed;}
        nav a:not(.btn):not(.text-orange-400):active {transform: scale(0.96);}
        input:focus, select:focus, textarea:focus {outline: none !important;border-color: #f97316 !important;box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.18) !important;--tw-ring-color: transparent !important;}
        input[name="q"]:focus {
            border-color: transparent !important;
            box-shadow: none !important;
        }
    </style>
</head>
<<<<<<< HEAD
<body class="bg-[#FFFBF5] text-gray-800">
<nav class="bg-white shadow">
    <div class="max-w-6xl mx-auto px-6 py-8 flex flex-wrap items-center gap-4">
        <a href="{{ route('home') }}" class="font-bold text-lg text-orange-400">Toko Makmur Jaya</a>
=======
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
>>>>>>> 1e9ba5ee7ee1179199205be0935c4bbf8eb58656

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

<<<<<<< HEAD
<main class="max-w-6xl mx-auto px-6 py-6">
    @if(session('success'))<div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="mb-4 p-3 rounded bg-red-100 text-red-800">{{ session('error') }}</div>@endif
=======
<main class="mx-auto min-h-[65vh] max-w-7xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
    @if(session('success'))<div class="mb-4 rounded-2xl border border-green-200 bg-green-50 p-3 text-sm text-green-800">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="mb-4 rounded-2xl border border-red-200 bg-red-50 p-3 text-sm text-red-800">{{ session('error') }}</div>@endif
>>>>>>> 1e9ba5ee7ee1179199205be0935c4bbf8eb58656
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