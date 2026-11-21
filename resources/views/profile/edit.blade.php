<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Profile') }} - Toko Makmur Jaya</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #FFF8EE;
        }

        /* Ukuran & garis kotak input lebih jelas dan lega */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        select,
        textarea {
            width: 100% !important;
            padding: 0.75rem 1rem !important;
            font-size: 0.95rem !important;
            line-height: 1.5 !important;
            border: 1.5px solid #E7D5BE !important;
            background-color: #FFFDF9 !important;
            border-radius: 0.65rem !important;
            transition: all 0.2s ease !important;
        }

        input:focus, select:focus, textarea:focus {
            outline: none !important;
            border-color: #F97316 !important;
            background-color: #ffffff !important;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.18) !important;
        }

        /* Tombol kotak (bukan bulat/kapsul) */
        button[type="submit"]:not(.bg-red-600) {
            background-color: #F97316 !important;
            color: #ffffff !important;
            border-radius: 0.65rem !important;
            padding: 0.65rem 1.5rem !important;
            font-weight: 700 !important;
            transition: all 0.2s ease !important;
        }

        button[type="submit"]:not(.bg-red-600):hover {
            background-color: #EA580C !important;
        }
    </style>
</head>
<body class="min-h-screen bg-[#FFF8EE] relative overflow-x-hidden text-[#2B2118] antialiased">

    <!-- Dekorasi Lingkaran Lembut di Latar Belakang -->
    <div class="fixed -top-28 -right-28 w-80 h-80 rounded-full bg-[#FDE2B8]/50 blur-2xl pointer-events-none"></div>
    <div class="fixed -bottom-28 -left-28 w-80 h-80 rounded-full bg-[#FED7AA]/40 blur-2xl pointer-events-none"></div>

    <div class="relative z-10 max-w-4xl mx-auto px-6 py-10">

        <!-- Header Brand & Kembali -->
        <div class="flex items-center justify-between gap-4 mb-8">
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#F97316] to-[#EA580C] text-white flex items-center justify-center shadow-md shadow-orange-500/25 group-hover:scale-105 group-hover:shadow-lg group-hover:shadow-orange-500/30 transition duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z"/>
                    </svg>
                </div>
                <div>
                    <span class="block text-lg font-extrabold tracking-tight text-[#382112] group-hover:text-[#EA580C] transition">Toko Makmur Jaya</span>
                    <span class="block text-xs font-semibold text-[#7A6A5C]">{{ __('Profile') }}</span>
                </div>
            </a>

            <a href="{{ url('/dashboard') }}" class="rounded-full bg-white border border-[#F0E2CF] hover:border-[#F5C696] px-4 py-2 text-xs sm:text-sm font-semibold text-[#7A6A5C] hover:text-[#EA580C] shadow-xs transition">
                &larr; Kembali
            </a>
        </div>

        <!-- Daftar Kartu Profil -->
        <div class="space-y-6">
            <div class="w-full bg-white rounded-3xl border border-[#F0E2CF] shadow-[0_12px_36px_rgba(92,51,18,0.07)] hover:border-[#F5C696] hover:shadow-[0_18px_44px_rgba(92,51,18,0.11)] transition duration-200 p-6 sm:p-9">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="w-full bg-white rounded-3xl border border-[#F0E2CF] shadow-[0_12px_36px_rgba(92,51,18,0.07)] hover:border-[#F5C696] hover:shadow-[0_18px_44px_rgba(92,51,18,0.11)] transition duration-200 p-6 sm:p-9">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="w-full bg-white rounded-3xl border border-[#F0E2CF] shadow-[0_12px_36px_rgba(92,51,18,0.07)] hover:border-[#F5C696] hover:shadow-[0_18px_44px_rgba(92,51,18,0.11)] transition duration-200 p-6 sm:p-9">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>

        <!-- Footer Tipis -->
        <p class="text-center text-xs text-[#9C8B7A] mt-8">
            &copy; {{ date('Y') }} Toko Makmur Jaya
        </p>
    </div>

</body>
</html>