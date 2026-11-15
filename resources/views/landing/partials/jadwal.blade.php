<section class="section" id="jadwal">
    <div class="container">
        <p class="eyebrow">JADWAL PENGANGKUTAN</p>
        <h2>Tidak perlu lagi menebak waktu angkut sampah</h2>
        <p>Jadwal yang jelas membantu warga menyiapkan sampah yang akan diangkut dan membantu petugas menjaga rute tetap
            efisien.</p>
        <div class="schedule"><small>Jadwal Wilayah
                {{ config('pantas.kota_singkat') }}</small>@php($start = now()->startOfWeek(\Carbon\Carbon::SUNDAY))<div class="schedule-heading">
                <h3>{{ $start->format('d') }}–{{ $start->copy()->addDays(6)->translatedFormat('d F Y') }}</h3><span
                    class="pill">Minggu ini</span>
            </div>
            <div class="week">
                @for ($i = 0; $i < 7; $i++)
                    @php($date = $start->copy()->addDays($i))
                    <div class="day">
                        <small>{{ $date->translatedFormat('l') }}</small><strong>{{ $date->day }}</strong>
                        @if ($jadwal->contains(fn($j) => in_array($date->locale('id')->dayName, $j->hari) && (!$j->tanggal || $date->gte($j->tanggal))))
                            <span class="schedule-dot"></span>
                        @endif
                    </div>
                @endfor
            </div>
            <div class="next-pickup"><strong>Pengangkutan berikutnya</strong>
                @if ($next)
                    <p>{{ $next['date']->translatedFormat('l, d F Y') }}
                        ({{ str_replace(':', '.', substr($next['jadwal']->jam_mulai, 0, 5)) }}–{{ str_replace(':', '.', substr($next['jadwal']->jam_selesai, 0, 5)) }})
                    &bull; {{ $next['jadwal']->wilayah->nama }}</p>@else<p>Belum ada jadwal pengangkutan.</p>
                @endif
            </div><small>Jadwal tersedia sesuai wilayah. Masuk untuk melihat jadwal wilayahmu.</small>
        </div>
    </div>
</section>
