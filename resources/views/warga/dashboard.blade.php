@extends('layouts.warga')

@section('title', 'Beranda Warga | PANTAS')
@section('breadcrumb', 'Beranda')

@section('content')

    @php
        $jam = now()->hour;

        $sapaan = $jam < 11
            ? 'Selamat pagi'
            : ($jam < 15
                ? 'Selamat siang'
                : ($jam < 18 ? 'Selamat sore' : 'Selamat malam'));

        $nama = auth()->user()?->name ?? 'Dimas Pratama';
        $namaDepan = explode(' ', $nama)[0];
    @endphp

    {{-- SAPAAN --}}
    <section class="pw-welcome">
        <div>
            <p class="pw-date">
                {{ strtoupper(now()->locale('id')->translatedFormat('l, d F Y')) }}
            </p>

            <h1>{{ $sapaan }}, {{ $namaDepan }}!</h1>

            <p class="pw-subtitle">
                Yuk, lihat kabar lingkunganmu hari ini.
            </p>
        </div>

        <a href="{{ url('/warga/laporan') }}" class="pw-primary-btn">
            <span>▣</span>
            Laporkan Sampah
        </a>
    </section>

    {{-- RINGKASAN INFORMASI --}}
    <section class="pw-stats-grid">

        <article class="pw-stat-card">
            <div class="pw-stat-heading">
                <span class="pw-stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round">
                        <rect x="3" y="5" width="18" height="16" rx="2"/>
                        <path d="M16 3v4M8 3v4M3 10h18"/>
                    </svg>
                </span>
                <span>JADWAL BERIKUTNYA</span>
            </div>

            <h2>Besok</h2>
            <p>Selasa, pukul 07.00 WIB</p>
        </article>

        <article class="pw-stat-card">
            <div class="pw-stat-heading">
                <span class="pw-stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round">
                        <rect x="5" y="4" width="14" height="17" rx="2"/>
                        <path d="M9 4V2h6v2M9 10h6M9 14h6"/>
                    </svg>
                </span>
                <span>LAPORAN AKTIF</span>
            </div>

            <h2>2</h2>
            <p>1 laporan sedang diproses</p>
        </article>

        <article class="pw-stat-card">
            <div class="pw-stat-heading">
                <span class="pw-stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="m8 12 3 3 5-6"/>
                    </svg>
                </span>
                <span>LAPORAN SELESAI</span>
            </div>

            <h2>12</h2>
            <p>+3 selesai bulan ini</p>
        </article>

    </section>

    {{-- INFORMASI KETERLAMBATAN --}}
    <section class="pw-alert">
        <span class="pw-alert-label">Info keterlambatan</span>

        <h2>Pengangkutan sedikit terlambat</h2>

        <p>
            Armada untuk wilayah Sukamaju mengalami kendala.
            Estimasi tiba hari ini pukul 10.30 WIB.
            Terima kasih sudah menunggu.
        </p>
    </section>

    {{-- AKSES CEPAT --}}
    <section class="pw-quick-section">

        <div class="pw-section-heading">
            <h2>Akses cepat</h2>
            <span>Semua kebutuhanmu</span>
        </div>

        <div class="pw-quick-grid">

            <a href="{{ url('/warga/jadwal') }}" class="pw-quick-card">
                <span class="pw-quick-icon">▦</span>
                <strong>Jadwal</strong>
                <p>Lihat jadwal angkut</p>
                <span class="pw-arrow">→</span>
            </a>

            <a href="{{ url('/warga/laporan') }}" class="pw-quick-card">
                <span class="pw-quick-icon">▤</span>
                <strong>Status Laporan</strong>
                <p>Pantau laporanmu</p>
                <span class="pw-arrow">→</span>
            </a>

            <a href="{{ url('/warga/edukasi') }}" class="pw-quick-card">
                <span class="pw-quick-icon">▣</span>
                <strong>Edukasi</strong>
                <p>Belajar pilah sampah</p>
                <span class="pw-arrow">→</span>
            </a>

            <a href="#" class="pw-quick-card">
                <span class="pw-quick-icon">⌖</span>
                <strong>Drop Point</strong>
                <p>Temukan lokasi terdekat</p>
                <span class="pw-arrow">→</span>
            </a>

        </div>
    </section>

    {{-- DAMPAK LINGKUNGAN --}}
    <section class="pw-impact">
        <span>DAMPAKMU BULAN INI</span>

        <h2>Kamu membantu mengelola 18 kg sampah</h2>

        <p>Setara dengan mengurangi 7,2 kg emisi karbon.</p>
    </section>

@endsection
