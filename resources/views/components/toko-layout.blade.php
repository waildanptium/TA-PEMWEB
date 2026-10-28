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
<body class="bg-gray-100 text-gray-800">
<nav class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 py-3 flex flex-wrap items-center gap-4">
        <a href="{{ route('home') }}" class="font-bold text-lg text-green-700">Toko Makmur Jaya</a>

        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a href="{{ route('admin.produk.index') }}">Produk</a>
                <a href="{{ route('admin.kategori.index') }}">Kategori</a>
                <a href="{{ route('admin.pegawai.index') }}">Pegawai</a>
                <a href="{{ route('admin.transaksi.index') }}">Transaksi</a>
                <a href="{{ route('kasir.pos') }}">POS</a>
            @elseif(auth()->user()->role === 'kasir')
                <a href="{{ route('kasir.dashboard') }}">Dashboard</a>
                <a href="{{ route('kasir.pos') }}">POS</a>
                <a href="{{ route('kasir.history') }}">Riwayat</a>
            @else
                <a href="{{ route('catalog') }}">Produk</a>
                <a href="{{ route('cart') }}">Keranjang</a>
                <a href="{{ route('orders') }}">Pesanan</a>
            @endif
        @else
            <a href="{{ route('catalog') }}">Produk</a>
        @endauth

        <div class="ml-auto flex items-center gap-3">
            @auth
                <a href="{{ route('profile.edit') }}" class="text-sm text-gray-600">{{ auth()->user()->name }} ({{ auth()->user()->role }})</a>
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <button class="btn btn-gray">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}">Masuk</a>
                <a href="{{ route('register') }}" class="btn">Daftar</a>
            @endauth
        </div>
    </div>
</nav>

<main class="max-w-7xl mx-auto px-4 py-6">
    @if(session('success'))<div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="mb-4 p-3 rounded bg-red-100 text-red-800">{{ session('error') }}</div>@endif
    @if($errors->any())
        <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
    @endif

    {{ $slot }}
</main>

<footer class="text-center text-sm text-gray-500 py-6">&copy; {{ date('Y') }} Toko Makmur Jaya</footer>
</body>
</html>