<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Petugas Kebersihan - PANTAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-white min-h-screen flex flex-col md:flex-row">

    <!-- SISI KIRI: Banner / Informasi Portal Petugas (Nuansa Biru) -->
    <div class="hidden md:flex md:w-1/2 bg-[#F0F6FC] p-12 flex-col justify-between relative">
        <div>
            <!-- Logo PANTAS Resmi -->
            <a href="/" class="flex items-center gap-3">
                <div class="w-11 h-11 bg-[#2B6CB0] rounded-2xl flex items-center justify-center text-white shadow-sm shrink-0">
                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 20h16" />
                        <path d="M12 20v-8" />
                        <path d="M12 12c0-3.5 2.5-6 6-6 0 3.5-2.5 6-6 6z" />
                        <path d="M12 15c0-2.5-2-4.5-4.5-4.5 0 2.5 2 4.5 4.5 4.5z" />
                    </svg>
                </div>
                <div class="flex flex-col justify-center">
                    <span class="text-2xl font-black text-[#0F172A] tracking-tight leading-none">PANTAS</span>
                    <span class="text-[10px] text-[#2B6CB0] font-bold tracking-wider uppercase mt-0.5">PANTAU SAMPAH</span>
                </div>
            </a>
        </div>

        <div class="my-auto max-w-md">
            <div class="w-14 h-14 bg-[#EBF8FF] rounded-2xl flex items-center justify-center text-[#2B6CB0] mb-6">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                </svg>
            </div>

            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Portal Petugas Kebersihan</h1>
            <p class="text-gray-600 mb-8 leading-relaxed">
                Kelola rute dan tindak lanjuti laporan warga dengan mudah.
            </p>

            <div class="space-y-4">
                <div class="flex items-center gap-3 text-gray-700 font-medium">
                    <div class="w-5 h-5 rounded-full bg-[#EBF8FF] flex items-center justify-center text-[#2B6CB0]">✓</div>
                    <span>Rute pengangkutan yang jelas</span>
                </div>
                <div class="flex items-center gap-3 text-gray-700 font-medium">
                    <div class="w-5 h-5 rounded-full bg-[#EBF8FF] flex items-center justify-center text-[#2B6CB0]">✓</div>
                    <span>Tindak lanjut laporan warga</span>
                </div>
                <div class="flex items-center gap-3 text-gray-700 font-medium">
                    <div class="w-5 h-5 rounded-full bg-[#EBF8FF] flex items-center justify-center text-[#2B6CB0]">✓</div>
                    <span>Panduan keselamatan kerja</span>
                </div>
            </div>
        </div>
        <div></div>
    </div>

    <!-- SISI KANAN: Form Sign Up Petugas -->
    <div class="w-full md:w-1/2 flex flex-col justify-center px-8 md:px-20 py-12">
        <div class="max-w-md w-full mx-auto">

            <a href="/" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-800 mb-6 transition-colors">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke beranda
            </a>

            <div class="w-10 h-10 bg-[#EBF8FF] rounded-xl flex items-center justify-center text-[#2B6CB0] mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                </svg>
            </div>

            <span class="text-xs font-semibold tracking-wider text-gray-400 uppercase">PORTAL PETUGAS</span>
            <h2 class="text-3xl font-bold text-gray-900 mt-1 mb-1">Buat Akun Petugas</h2>
            <p class="text-sm text-gray-500 mb-6">Lengkapi informasi untuk pendaftaran akun petugas.</p>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('petugas.register') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama lengkap"
                        class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:border-[#2B6CB0] focus:ring-1 focus:ring-[#2B6CB0] text-sm text-gray-800 placeholder-gray-400 transition-all">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="Masukkan email"
                        class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:border-[#2B6CB0] focus:ring-1 focus:ring-[#2B6CB0] text-sm text-gray-800 placeholder-gray-400 transition-all">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-1">Password</label>
                    <input type="password" name="password" required placeholder="Masukkan kata sandi"
                        class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:border-[#2B6CB0] focus:ring-1 focus:ring-[#2B6CB0] text-sm text-gray-800 placeholder-gray-400 transition-all">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required placeholder="Ulangi kata sandi"
                        class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:border-[#2B6CB0] focus:ring-1 focus:ring-[#2B6CB0] text-sm text-gray-800 placeholder-gray-400 transition-all">
                </div>

                <button type="submit" class="w-full py-3.5 bg-[#2B6CB0] hover:bg-[#23528C] text-white font-semibold rounded-xl transition-all shadow-sm mt-2">
                    Daftar
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-xs text-gray-500">Sudah punya akun? <a href="{{ route('petugas.login') }}" class="text-[#2B6CB0] font-semibold hover:underline">Masuk</a></p>
            </div>

        </div>
    </div>
</body>
</html>
