@extends('warga.layouts.app')
@section('title', 'Jadwal Pengangkutan')
@section('content')<div class="page-header">
        <div>
            <p class="eyebrow">JADWAL WILAYAHMU</p>
            <h1>Jadwal Pengangkutan</h1>
            <p>Jadwal pengangkutan sesuai wilayah layananmu.</p>
        </div>
    </div>
    @if (!auth()->user()->wilayah_id)
        <div class="card"><x-empty-state title="Wilayah belum diatur"><a class="button"
                href="{{ route('warga.profil.edit') }}">Atur wilayah</a></x-empty-state></div>@else<div class="card">
            <h2>{{ now()->startOfWeek()->translatedFormat('d') }}–{{ now()->endOfWeek()->translatedFormat('d F Y') }}</h2>
            <p>Minggu ini &bull; {{ auth()->user()->wilayah?->nama }}</p>
            <div class="week">
                @for ($i = 0; $i < 7; $i++)
                    @php($date = now()->startOfWeek()->addDays($i))@php($scheduled = $items->contains(fn($j) => in_array($date->locale('id')->dayName, $j->hari) && (!$j->tanggal || $date->gte($j->tanggal))))
                    <div class="day {{ $date->isToday() ? 'today' : '' }}">
                        <small>{{ $date->translatedFormat('D') }}</small><strong>{{ $date->day }}</strong>
                        @if ($date->isToday())
                            <span class="badge aktif">Hari ini</span>
                        @elseif($scheduled)
                            <span class="badge">{{ $date->isPast() ? 'Selesai' : 'Terjadwal' }}</span>
                        @endif
                    </div>
                @endfor
            </div>
        </div>
        <div class="grid">
            <div class="card">
                <p class="eyebrow">PENGANGKUTAN BERIKUTNYA</p>
                @if ($next)
                    <h2>{{ $next['date']->translatedFormat('l, d F') }}</h2><span class="badge aktif">Terjadwal</span>
                    <div class="summary info-grid">
                        <div><small>Waktu</small><strong>{{ str_replace(':', '.', substr($next['jadwal']->jam_mulai, 0, 5)) }}–{{ str_replace(':', '.', substr($next['jadwal']->jam_selesai, 0, 5)) }}
                                WIB</strong></div>
                        <div><small>Jenis sampah</small><strong>{{ $next['jadwal']->jenis_sampah }}</strong></div>
                </div>@else<x-empty-state title="Belum ada jadwal pengangkutan di wilayahmu." />
                @endif
            </div>
            <div class="card"><span class="icon-box"><i data-lucide="bell"></i></span>
                <h2>Pengingat jadwal</h2>
                <p>Periksa jadwal dan notifikasi akun untuk informasi pengangkutan terbaru.</p><a
                    href="{{ route('warga.notifikasi') }}">Lihat notifikasi</a>
            </div>
        </div>
    @endif
    <div class="notice">Tips: Letakkan sampah di depan rumah maksimal 30 menit sebelum jadwal pengangkutan.</div>
@endsection
