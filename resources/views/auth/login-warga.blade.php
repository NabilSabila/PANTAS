<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke PANTAS - Portal Warga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-white min-h-screen flex flex-col md:flex-row">

    <!-- SISI KIRI: Banner / Informasi Portal Warga -->
    <div class="hidden md:flex md:w-1/2 bg-[#F2FBF6] p-12 flex-col justify-between relative">
        <div>
            <!-- Logo PANTAS -->
            <a href="/" class="flex items-center gap-3">
                <div class="w-11 h-11 bg-[#009951] rounded-2xl flex items-center justify-center text-white shadow-sm shrink-0">
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
                    <span class="text-[10px] text-[#009951] font-bold tracking-wider uppercase mt-0.5">PANTAU SAMPAH</span>
                </div>
            </a>
        </div>

        <div class="my-auto max-w-md">
            <!-- Icon Profil Hijau Muda -->
            <div class="w-14 h-14 bg-[#D1FAE5] rounded-2xl flex items-center justify-center text-[#00A859] mb-6">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>

            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Portal Warga</h1>
            <p class="text-gray-600 mb-8 leading-relaxed">
                Pantau jadwal, laporkan sampah, dan ikuti perkembangan penanganannya.
            </p>

            <!-- List Keunggulan -->
            <div class="space-y-4">
                <div class="flex items-center gap-3 text-gray-700 font-medium">
                    <div class="w-5 h-5 rounded-full bg-[#E6F4EA] flex items-center justify-center text-[#00A859]">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span>Jadwal sesuai wilayahmu</span>
                </div>
                <div class="flex items-center gap-3 text-gray-700 font-medium">
                    <div class="w-5 h-5 rounded-full bg-[#E6F4EA] flex items-center justify-center text-[#00A859]">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span>Pelaporan mudah dengan foto</span>
                </div>
                <div class="flex items-center gap-3 text-gray-700 font-medium">
                    <div class="w-5 h-5 rounded-full bg-[#E6F4EA] flex items-center justify-center text-[#00A859]">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span>Proses penanganan transparan</span>
                </div>
            </div>
        </div>

        <div></div> <!-- Spacer footer kiri -->
    </div>

    <!-- SISI KANAN: Form Login -->
    <div class="w-full md:w-1/2 flex flex-col justify-center px-8 md:px-20 py-12">
        <div class="max-w-md w-full mx-auto">

            <!-- Tombol Kembali ke Beranda -->
            <a href="/" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-800 mb-8 transition-colors">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke beranda
            </a>

            <!-- Icon Profil Kecil di Atas Judul (Mobile/Desktop Header) -->
            <div class="w-10 h-10 bg-[#D1FAE5] rounded-xl flex items-center justify-center text-[#00A859] mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>

            <span class="text-xs font-semibold tracking-wider text-gray-400 uppercase">PORTAL WARGA</span>
            <h2 class="text-3xl font-bold text-gray-900 mt-1 mb-2">Masuk ke PANTAS</h2>
            <p class="text-sm text-gray-500 mb-8">Gunakan akun warga yang sudah terdaftar.</p>

            <!-- Menampilkan Error Validasi -->
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Form Input -->
            <form action="{{ url('/login/warga') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="dimas@example.com"
                        class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:border-[#00A859] focus:ring-1 focus:ring-[#00A859] text-sm text-gray-800 placeholder-gray-400 transition-all">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-1.5">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required placeholder="••••••••"
                            class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:border-[#00A859] focus:ring-1 focus:ring-[#00A859] text-sm text-gray-800 placeholder-gray-400 transition-all">
                        <button type="button" onclick="togglePassword()" class="absolute right-3 top-3.5 text-gray-400 hover:text-gray-600">
                            <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full py-3.5 bg-[#00A859] hover:bg-[#00924D] text-white font-semibold rounded-xl transition-all shadow-sm">
                    Masuk
                </button>
            </form>

            <div class="mt-6 text-center">
    <p class="text-xs text-gray-500">
        Belum punya akun?
        <a href="{{ route('warga.register') }}" class="text-[#00A859] font-semibold hover:underline">Daftar</a>
    </p>
</div>

            </div>

        </div>
    </div>

</div>
</div>

    <!-- Script sederhana untuk toggle show/hide password -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        }
    </script>
</body>
</html>
