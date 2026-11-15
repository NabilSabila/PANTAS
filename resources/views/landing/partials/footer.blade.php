<footer>
    <div class="container">
        <div class="footer-grid">
            <div><x-logo />
                <p>Platform kolaborasi warga dan petugas untuk lingkungan yang bersih, tertata, dan nyaman.</p>
            </div>
            <div>
                <h3>Navigasi</h3><a href="#beranda">Beranda</a><a href="#jadwal">Jadwal</a><a href="#edukasi">Edukasi</a><a
                    href="#tentang">Tentang Kami</a>
            </div>
            <div>
                <h3>Layanan</h3><a href="{{ route('warga.laporan.index') }}">Laporan Sampah</a><a
                    href="{{ route('warga.jadwal') }}">Jadwal Pengangkutan</a><a
                    href="{{ route('warga.drop-point') }}">Drop Point</a>
            </div>
            <div>
                <h3>Hubungi Kami</h3>
                <p>Pusat Layanan PANTAS {{ config('pantas.kota') }}</p><a
                    href="mailto:{{ config('pantas.email_layanan') }}">{{ config('pantas.email_layanan') }}</a>
            </div>
        </div>
        <div class="footer-bottom"><span>© {{ now()->year }} PANTAS — Pantau Sampah.</span><span>Lingkungan bersih
                dimulai dari langkah kecil kita.</span></div>
    </div>
</footer>
