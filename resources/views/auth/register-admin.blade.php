<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Admin - PANTAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-white min-h-screen flex flex-col md:flex-row">

    <!-- SISI KIRI: Banner / Informasi Portal Admin (Nuansa Netral Elegan) -->
    <div class="hidden md:flex md:w-1/2 bg-[#F8FAFC] p-12 flex-col justify-between relative border-r border-gray-100">
        <div>
            <!-- Logo PANTAS Admin Console -->
            <a href="/" class="flex items-center gap-3">
                <div class="w-11 h-11 bg-[#0F172A] rounded-2xl flex items-center justify-center text-white shadow-sm shrink-0">
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
                    <span class="text-[10px] text-gray-500 font-bold tracking-wider uppercase mt-0.5">ADMIN CONSOLE</span>
                </div>
            </a>
        </div>

        <div class="my-auto max-w-md">
            <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center text-[#0F172A] mb-6">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>

            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Portal Admin</h1>
            <p class="text-gray-600 mb-8 leading-relaxed">
                Kelola pengguna, jadwal, rute, dan laporan PANTAS.
            </p>

            <div class="space-y-4">
                <div class="flex items-center gap-3 text-gray-700 font-medium">
                    <div class="w-5 h-5 rounded-full bg-gray-100 flex items-center justify-center text-[#0F172A]">✓</div>
                    <span>Pengelolaan terpusat</span>
                </div>
                <div class="flex items-center gap-3 text-gray-700 font-medium">
                    <div class="w-5 h-5 rounded-full bg-gray-100 flex items-center justify-center text-[#0F172A]">✓</div>
                    <span>Data layanan terstruktur</span>
                </div>
                <div class="flex items-center gap-3 text-gray-700 font-medium">
                    <div class="w-5 h-5 rounded-full bg-gray-100 flex items-center justify-center text-[#0F172A]">✓</div>
                    <span>Pemantauan operasional</span>
                </div>
            </div>
        </div>
        <div></div>
    </div>

    <!-- SISI KANAN: Form Sign Up Admin -->
    <div class="w-full md:w-1/2 flex flex-col justify-center px-8 md:px-20 py-12">
        <div class="max-w-md w-full mx-auto">

            <a href="/" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-800 mb-6 transition-colors">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke beranda
            </a>

            <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-[#0F172A] mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>

            <span class="text-xs font-semibold tracking-wider text-gray-400 uppercase">PORTAL ADMIN</span>
            <h2 class="text-3xl font-bold text-gray-900 mt-1 mb-1">Buat Akun Admin</h2>
            <p class="text-sm text-gray-500 mb-6">Lengkapi informasi untuk pendaftaran akun admin.</p>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.register') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="Masukkan email"
                        class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:border-[#0F172A] focus:ring-1 focus:ring-[#0F172A] text-sm text-gray-800 placeholder-gray-400 transition-all">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-1">Password</label>
                    <input type="password" name="password" required placeholder="Masukkan kata sandi"
                        class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:border-[#0F172A] focus:ring-1 focus:ring-[#0F172A] text-sm text-gray-800 placeholder-gray-400 transition-all">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required placeholder="Ulangi kata sandi"
                        class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:border-[#0F172A] focus:ring-1 focus:ring-[#0F172A] text-sm text-gray-800 placeholder-gray-400 transition-all">
                </div>

                <p class="text-[11px] text-gray-500 leading-relaxed">
                    Registrasi ini hanya untuk administrator yang berwenang. Pendaftaran tidak otomatis memberikan akses admin.
                </p>

                <button type="submit" class="w-full py-3.5 bg-[#0F172A] hover:bg-[#1E293B] text-white font-semibold rounded-xl transition-all shadow-sm mt-2">
                    Daftar
                </button>
            </form>

            <div class="mt-6 text-center space-y-2">
                <p class="text-xs text-gray-500">Sudah punya akun? <a href="{{ route('admin.login') }}" class="text-[#0F172A] font-semibold hover:underline">Masuk</a></p>
                <p class="text-[11px] text-gray-400">Contoh formulir statis • Tidak membuat akun.</p>
            </div>

        </div>
    </div>
</body>
</html>
