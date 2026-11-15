<section class="hero" id="beranda">
    <div class="container hero-grid">
        <div><span class="pill"><i data-lucide="sprout"></i>Bersama untuk lingkungan lebih bersih</span>
            <h1>Pantau sampah, jaga lingkungan <em>lebih mudah.</em></h1>
            <p>Pantau jadwal, laporkan sampah, dan ikut menjaga lingkungan tetap bersih bersama PANTAS.</p>
            <div class="actions"><a class="button" href="{{ route('warga.login') }}">Mulai sekarang <i
                        data-lucide="arrow-right"></i></a><a class="button outline" href="#tentang">Pelajari PANTAS</a>
            </div>
            <div class="hero-checks"><span><i data-lucide="check-circle"></i>Mudah digunakan</span><span><i
                        data-lucide="check-circle"></i>Laporan transparan</span><span><i
                        data-lucide="check-circle"></i>Terhubung dengan petugas</span></div>
        </div>
        <div class="mascot-panel">
            @if (file_exists(public_path('assets/img/maskot-pantas.png')))
            <img src="{{ asset('assets/img/maskot-pantas.png') }}" alt="Maskot PANTAS membawa kalender">@else<svg
                    viewBox="0 0 480 420" role="img" aria-label="Maskot PANTAS membawa kalender">
                    <defs>
                        <linearGradient id="mascot" x2="0" y2="1">
                            <stop stop-color="#19b877" />
                            <stop offset="1" stop-color="#039855" />
                        </linearGradient>
                    </defs>
                    <ellipse cx="250" cy="380" rx="145" ry="17" fill="#10182812" />
                    <circle cx="80" cy="90" r="9" fill="#a6f4c5" />
                    <circle cx="415" cy="310" r="7" fill="#a6f4c5" />
                    <path d="M130 240 Q70 250 70 190 M360 240 Q415 250 415 150" fill="none" stroke="#039855"
                        stroke-width="19" stroke-linecap="round" />
                    <path d="M180 340 Q178 374 162 383 M300 340 Q307 372 328 383" fill="none" stroke="#194a39"
                        stroke-width="13" stroke-linecap="round" />
                    <rect x="120" y="74" width="245" height="285" rx="120" fill="url(#mascot)" />
                    <path d="M145 103 Q170 22 244 57 Q230 102 145 103" fill="#c7fbdc" />
                    <path d="M238 66 Q260 15 326 45 Q300 100 238 66" fill="#83e4b1" />
                    <circle cx="202" cy="185" r="10" fill="#153c30" />
                    <circle cx="292" cy="185" r="10" fill="#153c30" />
                    <circle cx="199" cy="182" r="3" fill="white" />
                    <circle cx="289" cy="182" r="3" fill="white" />
                    <circle cx="178" cy="213" r="13" fill="#9ae7b5" opacity=".65" />
                    <circle cx="317" cy="213" r="13" fill="#9ae7b5" opacity=".65" />
                    <path d="M228 215 Q248 236 269 215" fill="none" stroke="#154b37" stroke-width="6"
                        stroke-linecap="round" />
                    <path d="M130 250 Q245 280 365 250 V265 Q365 360 245 360 Q130 360 130 265" fill="#039855" />
                    <g transform="translate(305 250)">
                        <rect width="117" height="100" rx="18" fill="white" stroke="#2c5e8f"
                            stroke-width="5" />
                        <path d="M0 28 H117 M26 -7 V13 M90 -7 V13" fill="none" stroke="#2c5e8f" stroke-width="5"
                            stroke-linecap="round" />
                        <path d="M35 63 L51 78 L84 44" stroke="#039855" stroke-width="8" fill="none"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </g>
                    <path
                        d="M67 365 Q66 300 101 276 M70 337 Q40 338 32 321 Q63 298 75 329 M81 304 Q66 278 83 260 Q108 277 89 299"
                        fill="#c7fbdc" stroke="#039855" stroke-width="4" />
                </svg>
            @endif
        </div>
    </div>
</section>
