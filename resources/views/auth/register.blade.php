<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Toko Makmur Jaya</title>
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

    <!-- Header Brand -->
    <a href="{{ url('/') }}" class="relative z-10 flex flex-col items-center gap-2.5 mb-6 group">
        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#F97316] to-[#EA580C] text-white flex items-center justify-center shadow-md shadow-orange-500/25 group-hover:scale-105 group-hover:shadow-lg group-hover:shadow-orange-500/30 transition duration-200">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z"/>
            </svg>
        </div>
        <span class="text-xl font-extrabold tracking-tight text-[#382112] group-hover:text-[#EA580C] transition">Toko Makmur Jaya</span>
    </a>

    <!-- Kartu Form Utama dengan Hover -->
    <div class="relative z-10 w-full max-w-md bg-white rounded-3xl border border-[#F0E2CF] shadow-[0_12px_36px_rgba(92,51,18,0.07)] hover:border-[#F5C696] hover:shadow-[0_18px_44px_rgba(92,51,18,0.11)] transition duration-200 p-8 sm:p-9">

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-[#2B2118] mb-1.5">{{ __('Name') }}</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}"
                       required autofocus autocomplete="name"
                       class="w-full rounded-xl border border-[#E7D5BE] hover:border-[#F5C696] bg-[#FFFDF9] hover:bg-white px-4 py-3 text-sm text-[#2B2118] placeholder-[#9C8B7A] transition">
                <x-input-error :messages="$errors->get('name')" class="mt-1.5 text-xs text-red-600 font-medium" />
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-semibold text-[#2B2118] mb-1.5">{{ __('Email') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       required autocomplete="username"
                       class="w-full rounded-xl border border-[#E7D5BE] hover:border-[#F5C696] bg-[#FFFDF9] hover:bg-white px-4 py-3 text-sm text-[#2B2118] placeholder-[#9C8B7A] transition">
                <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-red-600 font-medium" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-[#2B2118] mb-1.5">{{ __('Password') }}</label>
                <input id="password" type="password" name="password"
                       required autocomplete="new-password"
                       class="w-full rounded-xl border border-[#E7D5BE] hover:border-[#F5C696] bg-[#FFFDF9] hover:bg-white px-4 py-3 text-sm text-[#2B2118] placeholder-[#9C8B7A] transition">
                <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-red-600 font-medium" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-[#2B2118] mb-1.5">{{ __('Confirm Password') }}</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       required autocomplete="new-password"
                       class="w-full rounded-xl border border-[#E7D5BE] hover:border-[#F5C696] bg-[#FFFDF9] hover:bg-white px-4 py-3 text-sm text-[#2B2118] placeholder-[#9C8B7A] transition">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-xs text-red-600 font-medium" />
            </div>

            <!-- Tombol Submit Kapsul -->
            <button type="submit"
                    class="w-full mt-2 py-3.5 px-6 rounded-full bg-[#F97316] hover:bg-[#EA580C] active:scale-[0.99] text-white font-bold text-sm shadow-md shadow-orange-500/25 hover:shadow-lg hover:shadow-orange-500/30 cursor-pointer transition">
                {{ __('Register') }}
            </button>
        </form>

        <!-- Tautan Sudah Terdaftar -->
        <p class="text-center text-sm text-[#7A6A5C] mt-6 pt-5 border-t border-[#F5ECE0]">
            <a href="{{ route('login') }}" class="font-semibold text-[#F97316] hover:text-[#EA580C] hover:underline transition">
                {{ __('Already registered?') }}
            </a>
        </p>
    </div>

    <!-- Footer Tipis -->
    <p class="relative z-10 text-xs text-[#9C8B7A] mt-6">
        &copy; {{ date('Y') }} Toko Makmur Jaya
    </p>

</body>
</html>