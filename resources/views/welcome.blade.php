<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PANTAS - Pantau Sampah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-[#F4FAF6] text-gray-800 font-sans antialiased">

    <header class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

            <a href="/" class="flex items-center gap-3">
                <div
                    class="w-11 h-11 bg-[#009951] rounded-2xl flex items-center justify-center text-white shadow-sm shrink-0">
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
                    <span class="text-[10px] text-[#009951] font-bold tracking-wider uppercase mt-0.5">PANTAU
                        SAMPAH</span>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
                <a href="#beranda" class="text-emerald-600 font-semibold hover:text-emerald-700 transition">Beranda</a>
                <a href="#jadwal" class="hover:text-emerald-600 transition">Jadwal</a>
                <a href="#edukasi" class="hover:text-emerald-600 transition">Edukasi</a>
                <a href="#tentang" class="hover:text-emerald-600 transition">Tentang Kami</a>
            </nav>

            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" @click.outside="open = false"
                    class="bg-[#111827] text-white px-5 py-2.5 rounded-xl font-medium text-sm flex items-center gap-2 hover:bg-gray-800 transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Login / Profil</span>
                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 scale-95 transform -translate-y-2"
                    x-transition:enter-end="opacity-100 scale-100 transform translate-y-0"
                    class="absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-xl border border-gray-100 p-2 z-50">

                    <a href="/login/warga"
                        class="flex items-center gap-3 p-3 rounded-xl hover:bg-emerald-50/60 transition group">
                        <div
                            class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="text-sm font-bold text-gray-900 group-hover:text-emerald-700">Warga</div>
                            <div class="text-xs text-gray-500">Pantau jadwal dan buat laporan</div>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-emerald-600 group-hover:translate-x-0.5 transition"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                    <a href="/login/petugas"
                        class="flex items-center gap-3 p-3 rounded-xl hover:bg-blue-50/60 transition group">
                        <div
                            class="w-10 h-10 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="text-sm font-bold text-gray-900 group-hover:text-blue-700">Petugas Kebersihan
                            </div>
                            <div class="text-xs text-gray-500">Petugas Kebersihan • Kelola rute dan laporan</div>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600 group-hover:translate-x-0.5 transition"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                    <a href="/login/admin"
                        class="flex items-center gap-3 p-3 rounded-xl hover:bg-purple-50/60 transition group">
                        <div
                            class="w-10 h-10 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="text-sm font-bold text-gray-900 group-hover:text-purple-700">Admin</div>
                            <div class="text-xs text-gray-500">Kelola operasional PANTAS</div>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-purple-600 group-hover:translate-x-0.5 transition"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                </div>
            </div>

        </div>
    </header>

    <section id="beranda"
        class="max-w-7xl mx-auto px-6 pt-12 pb-20 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <div>
            <div
                class="inline-flex items-center gap-2 bg-emerald-100/70 border border-emerald-200/50 text-emerald-800 px-3.5 py-1.5 rounded-full text-xs font-semibold mb-6">
                <span>🍀</span> Bersama untuk lingkungan lebih bersih
            </div>

            <h1 class="text-5xl md:text-6xl font-extrabold text-gray-900 tracking-tight leading-[1.15] mb-6">
                Pantau sampah, jaga lingkungan <span class="text-emerald-600">lebih mudah.</span>
            </h1>

            <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                Pantau jadwal, laporkan sampah, dan ikut menjaga lingkungan tetap bersih bersama PANTAS.
            </p>

            <div class="flex flex-wrap items-center gap-4 mb-10">
                <a href="#login"
                    class="bg-emerald-600 text-white font-bold px-6 py-3.5 rounded-xl hover:bg-emerald-700 transition flex items-center gap-2 shadow-lg shadow-emerald-600/20">
                    <span>Mulai sekarang</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
                <a href="#tentang"
                    class="bg-white border border-gray-200 text-gray-700 font-semibold px-6 py-3.5 rounded-xl hover:bg-gray-50 transition">
                    Pelajari PANTAS
                </a>
            </div>

            <div class="flex flex-wrap gap-6 text-sm text-gray-600 font-medium">
                <div class="flex items-center gap-2">
                    <span
                        class="w-5 h-5 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-xs">✓</span>
                    Mudah digunakan
                </div>
                <div class="flex items-center gap-2">
                    <span
                        class="w-5 h-5 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-xs">✓</span>
                    Laporan transparan
                </div>
                <div class="flex items-center gap-2">
                    <span
                        class="w-5 h-5 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-xs">✓</span>
                    Terhubung dengan petugas
                </div>
            </div>
        </div>

        <div class="flex justify-center relative">
            <div
                class="w-full max-w-md bg-emerald-100/40 rounded-3xl p-8 border border-emerald-100 flex items-center justify-center min-h-[380px]">
                <div class="relative flex flex-col items-center">
                    <div
                        class="w-52 h-52 bg-emerald-600 rounded-full flex flex-col items-center justify-center shadow-xl relative">
                        <div class="flex gap-8 mb-2">
                            <div class="w-4 h-4 bg-gray-900 rounded-full"></div>
                            <div class="w-4 h-4 bg-gray-900 rounded-full"></div>
                        </div>
                        <div class="w-8 h-4 border-b-4 border-gray-900 rounded-full"></div>

                        <div class="absolute left-8 top-28 w-5 h-3 bg-pink-300/60 rounded-full"></div>
                        <div class="absolute right-8 top-28 w-5 h-3 bg-pink-300/60 rounded-full"></div>

                        <div
                            class="absolute -top-6 w-8 h-8 bg-emerald-400 rounded-tl-full rounded-br-full transform -rotate-45 border-2 border-emerald-600">
                        </div>
                    </div>

                    <div
                        class="absolute -bottom-4 -right-4 bg-white p-3 rounded-2xl shadow-lg border border-gray-100 flex items-center gap-3">
                        <div
                            class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center font-bold">
                            ✓
                        </div>
                        <div>
                            <div class="text-xs text-gray-400">Jadwal Angkut</div>
                            <div class="text-sm font-bold text-gray-800">Tepat Waktu</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="tentang" class="py-16 bg-white border-y border-gray-100">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

            <div class="space-y-4">
                <div class="bg-emerald-700 text-white p-6 rounded-2xl shadow-md">
                    <div class="text-3xl font-extrabold">12.480</div>
                    <div class="text-emerald-100 text-sm">Warga bergabung</div>
                </div>
                <div class="bg-gray-50 border border-gray-100 p-6 rounded-2xl">
                    <div class="text-3xl font-extrabold text-gray-900">8.920</div>
                    <div class="text-gray-500 text-sm">Laporan selesai</div>
                </div>
                <div class="bg-amber-50 border border-amber-100 p-4 rounded-xl text-amber-800 text-xs font-medium">
                    Proses secara transparan & terukur
                </div>
            </div>

            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 block mb-2">TENTANG
                    PANTAS</span>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">
                    Satu ruang untuk warga dan petugas bergerak bersama
                </h2>
                <p class="text-gray-600 leading-relaxed">
                    PANTAS atau pantau sampah menghubungkan warga dengan petugas kebersihan dalam sistem yang sederhana,
                    terstruktur, dan transparan.
                </p>
            </div>

        </div>
    </section>

    <section class="py-20 max-w-7xl mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 block mb-2">FITUR UTAMA</span>
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Semua yang dibutuhkan untuk lingkungan yang lebih tertata
            </h2>
            <p class="text-gray-600">Mulai dari melihat jadwal hingga memantau penanganan laporan, semuanya hadir dalam
                pengalaman yang mudah dipahami.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
                <div
                    class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center font-bold mb-4">
                    📅</div>
                <h3 class="font-bold text-lg mb-1">Jadwal Pengangkutan</h3>
                <p class="text-sm text-gray-500">Lihat jadwal pengangkutan di wilayah Anda</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
                <div
                    class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center font-bold mb-4">
                    📝</div>
                <h3 class="font-bold text-lg mb-1">Laporan Penanganan Sampah</h3>
                <p class="text-sm text-gray-500">Tambahkan foto, lokasi, dan detail laporan</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
                <div
                    class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center font-bold mb-4">
                    📊</div>
                <h3 class="font-bold text-lg mb-1">Status Penanganan</h3>
                <p class="text-sm text-gray-500">Bisa memantau laporan dari proses hingga selesai</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
                <div
                    class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center font-bold mb-4">
                    📖</div>
                <h3 class="font-bold text-lg mb-1">Edukasi Lingkungan</h3>
                <p class="text-sm text-gray-500">Pahami pemilahan sampah, daur ulang, dan pengelolaan khusus</p>
            </div>
        </div>
    </section>

    <section id="jadwal" class="py-20 bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-6">
            <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 block mb-2">JADWAL
                PENGANGKUTAN</span>
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Tidak perlu lagi menebak waktu angkut sampah</h2>
            <p class="text-gray-600 mb-8">Jadwal yang jelas membantu warga menyiapkan sampah yang akan diangkut dan
                membantu petugas menjaga rute tetap efisien.</p>

            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 max-w-2xl">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-sm font-bold text-gray-800">4–10 Oktober 2026</span>
                    <span class="bg-emerald-100 text-emerald-700 text-xs px-3 py-1 rounded-full font-semibold">Minggu
                        ini</span>
                </div>

                <div class="grid grid-cols-7 gap-2 text-center mb-6">
                    <div class="bg-emerald-100 p-3 rounded-xl font-bold text-emerald-800">
                        <div class="text-[10px] uppercase text-emerald-600">Minggu</div>4
                    </div>
                    <div class="bg-emerald-100 p-3 rounded-xl font-bold text-emerald-800">
                        <div class="text-[10px] uppercase text-emerald-600">Senin</div>5
                    </div>
                    <div class="bg-emerald-100 p-3 rounded-xl font-bold text-emerald-800">
                        <div class="text-[10px] uppercase text-emerald-600">Selasa</div>6
                    </div>
                    <div class="bg-emerald-100 p-3 rounded-xl font-bold text-emerald-800">
                        <div class="text-[10px] uppercase text-emerald-600">Rabu</div>7
                    </div>
                    <div class="bg-emerald-100 p-3 rounded-xl font-bold text-emerald-800">
                        <div class="text-[10px] uppercase text-emerald-600">Kamis</div>8
                    </div>
                    <div class="bg-emerald-100 p-3 rounded-xl font-bold text-emerald-800">
                        <div class="text-[10px] uppercase text-emerald-600">Jumat</div>9
                    </div>
                    <div class="bg-emerald-100 p-3 rounded-xl font-bold text-emerald-800">
                        <div class="text-[10px] uppercase text-emerald-600">Sabtu</div>10
                    </div>
                </div>

                <div class="bg-emerald-100/60 p-4 rounded-xl">
                    <div class="text-xs text-emerald-800 font-bold mb-1">Pengangkutan Berikutnya:</div>
                    <div class="text-sm font-extrabold text-emerald-950">Senin, 07:00–09:00 WIB (Sampah Organik)</div>
                </div>
            </div>
        </div>
    </section>

    <section id="edukasi" class="py-20 max-w-7xl mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 block mb-2">EDUKASI
                LINGKUNGAN</span>
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Kebiasaan kecil, dampak yang berarti</h2>
            <p class="text-gray-600">Temukan panduan praktis untuk mengelola sampah dengan lebih baik dari rumah.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
            <div class="bg-white p-6 rounded-2xl border border-gray-100">
                <h3 class="font-bold text-gray-900 mb-1">Sampah Organik</h3>
                <p class="text-xs text-gray-500 mb-3">Olah sisa makanan menjadi pupuk kompos.</p>
                <a href="#" class="text-xs font-bold text-emerald-600 hover:underline">Baca selengkapnya →</a>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100">
                <h3 class="font-bold text-gray-900 mb-1">Pilah & Daur Ulang Sampah Anorganik</h3>
                <p class="text-xs text-gray-500 mb-3">Pisahkan plastik, kaca, dan kertas sebelum dibuang.</p>
                <a href="#" class="text-xs font-bold text-emerald-600 hover:underline">Baca selengkapnya →</a>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100">
                <h3 class="font-bold text-gray-900 mb-1">Limbah B3</h3>
                <p class="text-xs text-gray-500 mb-3">Kelola obat kadaluarsa, baterai, bekas elektronik dengan aman.
                </p>
                <a href="#" class="text-xs font-bold text-emerald-600 hover:underline">Baca selengkapnya →</a>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100">
                <h3 class="font-bold text-gray-900 mb-1">Drop Point Terdekat</h3>
                <p class="text-xs text-gray-500 mb-3">Setorkan sampah bernilai ke bank sampah terdekat.</p>
                <a href="#" class="text-xs font-bold text-emerald-600 hover:underline">Lihat lokasi →</a>
            </div>
        </div>
    </section>

    <footer class="bg-[#0F172A] text-white py-16">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-10">
            <div>
                <div class="text-xl font-extrabold tracking-tight mb-3">PANTAS</div>
                <p class="text-xs text-gray-400 leading-relaxed">
                    Platform kolaborasi warga dan petugas untuk lingkungan yang bersih, tertata, dan nyaman.
                </p>
            </div>

            <div>
                <div class="text-sm font-bold mb-3">Navigasi</div>
                <ul class="space-y-2 text-xs text-gray-400">
                    <li><a href="#beranda" class="hover:text-white transition">Beranda</a></li>
                    <li><a href="#jadwal" class="hover:text-white transition">Jadwal</a></li>
                    <li><a href="#edukasi" class="hover:text-white transition">Edukasi</a></li>
                    <li><a href="#tentang" class="hover:text-white transition">Tentang Kami</a></li>
                </ul>
            </div>

            <div>
                <div class="text-sm font-bold mb-3">Layanan</div>
                <ul class="space-y-2 text-xs text-gray-400">
                    <li>Laporan Sampah</li>
                    <li>Jadwal Pengangkutan</li>
                    <li>Edukasi</li>
                </ul>
            </div>

            <div>
                <div class="text-sm font-bold mb-3">Hubungi Kami</div>
                <p class="text-xs text-gray-400 mb-1">Pusat Layanan PANTAS Kota Surabaya, Jawa Timur</p>
                <p class="text-xs text-emerald-400 font-semibold">kontak@pantas.com</p>
            </div>
        </div>

        <div
            class="max-w-7xl mx-auto px-6 mt-12 pt-6 border-t border-gray-800 flex justify-between items-center text-[11px] text-gray-500">
            <div>© 2026 PANTAS — Pantau Sampah</div>
            <div>Lingkungan bersih mulai dari langkah kita.</div>
        </div>
    </footer>

</body>

</html>
