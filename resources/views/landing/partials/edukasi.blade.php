<section class="section education" id="edukasi">
    <div class="container narrow">
        <div class="section-heading">
            <p class="eyebrow">EDUKASI LINGKUNGAN</p>
            <h2>Kebiasaan kecil, dampak yang berarti</h2>
            <p>Temukan panduan pengelolaan sampah yang diterbitkan PANTAS.</p>
        </div>
        @if ($edukasi->isEmpty())
            <div class="feature-card">
                <p>Belum ada konten edukasi.</p>
        </div>@else<div class="feature-grid">
                @foreach ($edukasi as $item)
                    <div class="feature-card">
                        <h3>{{ $item->judul }}</h3>
                        <p>{{ Str::limit($item->ringkasan, 160) }}</p><a
                            href="{{ route('warga.edukasi.konten', $item) }}">Baca Selengkapnya <i
                                data-lucide="arrow-right"></i></a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
