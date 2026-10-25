<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'PANTAS | Warga')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="pantas-warga">

    <aside class="pw-sidebar">

        <a href="{{ url('/warga/dashboard') }}" class="pw-brand">
            <span class="pw-logo">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 21V11"/>
                    <path d="M12 14C5 14 4 9 4 5c6 0 9 3 8 9"/>
                    <path d="M12 17c0-5 3-8 8-8 0 5-2 8-8 8"/>
                </svg>
            </span>

            <span class="pw-brand-text">
                <strong>PANTAS</strong>
                <small>PANTAU SAMPAH</small>
            </span>
        </a>

        <div class="pw-user-card">
            <div class="pw-avatar">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M4 21v-2a8 8 0 0 1 16 0v2"/>
                </svg>
            </div>

            <div class="pw-user-info">
                <strong>{{ auth()->user()?->name ?? 'Dimas Pratama' }}</strong>
                <small>Akun Warga</small>
            </div>
        </div>

        <nav class="pw-navigation" aria-label="Navigasi Warga">

            <a href="{{ url('/warga/dashboard') }}"
               class="pw-nav-link {{ request()->is('warga/dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m3 10 9-7 9 7"/>
                    <path d="M5 9v12h14V9"/>
                    <path d="M9 21v-7h6v7"/>
                </svg>
                <span>Beranda</span>
            </a>

            <a href="{{ url('/warga/jadwal') }}"
               class="pw-nav-link {{ request()->is('warga/jadwal') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="5" width="18" height="16" rx="2"/>
                    <path d="M16 3v4M8 3v4M3 10h18"/>
                </svg>
                <span>Jadwal</span>
            </a>

            <a href="{{ url('/warga/laporan') }}"
               class="pw-nav-link {{ request()->is('warga/laporan*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="5" y="4" width="14" height="17" rx="2"/>
                    <path d="M9 4V2h6v2M9 10h6M9 14h6M9 18h4"/>
                </svg>
                <span>Laporan Sampah</span>
            </a>

            <a href="{{ url('/warga/edukasi') }}"
               class="pw-nav-link {{ request()->is('warga/edukasi') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 7v14"/>
                    <path d="M3 5a2 2 0 0 1 2-2h5a2 2 0 0 1 2 2v16"/>
                    <path d="M21 5a2 2 0 0 0-2-2h-5a2 2 0 0 0-2 2"/>
                </svg>
                <span>Edukasi</span>
            </a>

            <a href="{{ url('/warga/profil') }}"
               class="pw-nav-link {{ request()->is('warga/profil') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="9"/>
                    <circle cx="12" cy="9" r="3"/>
                    <path d="M6.5 19a6 6 0 0 1 11 0"/>
                </svg>
                <span>Profil</span>
            </a>

        </nav>

        <div class="pw-help">
            <strong>PANTAS Care</strong>
            <p>Butuh bantuan? Hubungi pusat layanan kami.</p>
        </div>

    </aside>

    <div class="pw-main">

        <header class="pw-topbar">
            <div class="pw-breadcrumb">
                <span>PANTAS</span>
                <span>/</span>
                <span>@yield('breadcrumb', 'Beranda')</span>
            </div>

            <div class="pw-location">
                <strong>{{ auth()->user()?->name ?? 'Dimas Pratama' }}</strong>
                <span>•</span>
                <span>Depok, Jawa Barat</span>
            </div>
        </header>

        <main class="pw-content">
            @yield('content')
        </main>

    </div>

</body>
</html>
