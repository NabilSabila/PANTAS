<header class="navbar">
    <div class="container nav-inner">
        <x-logo />
        <nav><a href="#beranda">Beranda</a><a href="#jadwal">Jadwal</a><a href="#edukasi">Edukasi</a><a
                href="#tentang">Tentang Kami</a></nav>
        <details class="portal-menu">
            <summary class="button dark"><i data-lucide="user"></i>Login / Profil <i data-lucide="chevron-down"></i>
            </summary>
            <div class="portal-dropdown">
                @foreach (['warga' => ['Warga', 'Pantau jadwal dan buat laporan', 'user'], 'petugas' => ['Petugas Kebersihan', 'Kelola rute dan laporan', 'truck'], 'admin' => ['Admin', 'Kelola operasional PANTAS', 'shield-check']] as $role => [$label, $desc, $icon])
                    <a href="{{ route($role . '.login') }}">
                        <span class="portal-icon {{ $role }}"><i data-lucide="{{ $icon }}"></i></span>
                        <span><strong>{{ $label }}</strong><small>{{ $desc }}</small></span>
                        <i data-lucide="chevron-right"></i>
                    </a>
                @endforeach
            </div>
        </details>
    </div>
</header>
