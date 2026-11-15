<section class="section tinted">
    <div class="container narrow">
        <div class="section-heading">
            <p class="eyebrow">FITUR UTAMA</p>
            <h2>Semua yang dibutuhkan untuk lingkungan yang lebih tertata</h2>
            <p>Mulai dari melihat jadwal hingga memantau penanganan laporan, semuanya hadir dalam pengalaman yang mudah
                dipahami.</p>
        </div>
        <div class="feature-grid">
            @foreach ([['calendar-days', 'Pantau jadwal', 'Lihat jadwal pengangkutan sesuai wilayah'], ['file-text', 'Lapor dengan mudah', 'Tambahkan foto, lokasi, dan detail kondisi'], ['clock', 'Status transparan', 'Ikuti proses laporan dari dikirim hingga selesai'], ['book-open', 'Edukasi lingkungan', 'Pelajari pemilahan sampah, daur ulang, dan pengelolaan']] as [$icon, $title, $description])
                <div class="feature-card"><span class="icon-box"><i data-lucide="{{ $icon }}"></i></span>
                    <h3>{{ $title }}</h3>
                    <p>{{ $description }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
