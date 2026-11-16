<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Toko Makmur Jaya</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #FFF8EE;
        }
        /* Fokus input oranye lembut tanpa garis biru bawaan browser */
        input:focus {
            outline: none !important;
            border-color: #F97316 !important;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.18) !important;
        }
    </style>
</head>
<body class="min-h-screen bg-[#FFF8EE] relative overflow-x-hidden flex flex-col justify-center items-center p-6 text-[#2B2118] antialiased">

    <!-- Dekorasi Lingkaran Lembut di Latar Belakang -->
    <div class="fixed -top-28 -right-28 w-80 h-80 rounded-full bg-[#FDE2B8]/50 blur-2xl pointer-events-none"></div>
    <div class="fixed -bottom-28 -left-28 w-80 h-80 rounded-full bg-[#FED7AA]/40 blur-2xl pointer-events-none"></div>

    <!-- Header Brand (Menggantikan Logo Laravel) -->
    <a href="{{ url('/') }}" class="relative z-10 flex flex-col items-center gap-2.5 mb-6 group">
        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#F97316] to-[#EA580C] text-white flex items-center justify-center shadow-md shadow-orange-500/25 group-hover:scale-105 transition">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z"/>
            </svg>
        </div>
        <span class="text-xl font-extrabold tracking-tight text-[#382112]">Toko Makmur Jaya</span>
    </a>

    <!-- Kartu Form Utama -->
    <div class="relative z-10 w-full max-w-md bg-white rounded-3xl border border-[#F0E2CF] shadow-[0_12px_36px_rgba(92,51,18,0.07)] p-8 sm:p-9">

        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-[#2B2118]">Selamat datang kembali</h1>
            <p class="text-sm text-[#7A6A5C] mt-1">Masuk untuk mulai belanja sembako dengan mudah</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 text-sm font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-xl px-4 py-2.5">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-[#2B2118] mb-1.5">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       placeholder="nama@email.com"
                       required autofocus autocomplete="username"
                       class="w-full rounded-xl border border-[#E7D5BE] bg-[#FFFDF9] px-4 py-3 text-sm text-[#2B2118] placeholder-[#9C8B7A] transition">
                @error('email')
                    <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-[#2B2118] mb-1.5">Kata sandi</label>
                <input id="password" type="password" name="password"
                       placeholder="Masukkan kata sandi"
                       required autocomplete="current-password"
                       class="w-full rounded-xl border border-[#E7D5BE] bg-[#FFFDF9] px-4 py-3 text-sm text-[#2B2118] placeholder-[#9C8B7A] transition">
                @error('password')
                    <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ingat Saya & Lupa Kata Sandi -->
            <div class="flex items-center justify-between pt-1">
                <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                    <input id="remember_me" type="checkbox" name="remember"
                           class="w-4 h-4 rounded border-[#E7D5BE] accent-[#F97316] cursor-pointer">
                    <span class="text-sm text-[#7A6A5C]">Ingat saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-sm font-semibold text-[#F97316] hover:text-[#EA580C] hover:underline transition">
                        Lupa kata sandi?
                    </a>
                @endif
            </div>

            <!-- Tombol Masuk Kapsul -->
            <button type="submit"
                    class="w-full mt-2 py-3.5 px-6 rounded-full bg-[#F97316] hover:bg-[#EA580C] active:scale-[0.99] text-white font-bold text-sm shadow-md shadow-orange-500/25 cursor-pointer transition">
                Masuk
            </button>
        </form>

        <!-- Tautan Daftar -->
        @if (Route::has('register'))
            <p class="text-center text-sm text-[#7A6A5C] mt-6 pt-5 border-t border-[#F5ECE0]">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-bold text-[#F97316] hover:text-[#EA580C] hover:underline">
                    Daftar sekarang
                </a>
            </p>
        @endif
    </div>

    <!-- Footer Tipis -->
    <p class="relative z-10 text-xs text-[#9C8B7A] mt-6">
        &copy; {{ date('Y') }} Toko Makmur Jaya
    </p>

</body>
</html>