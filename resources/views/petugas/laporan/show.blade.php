@extends('petugas.layouts.app')
@section('title', 'Detail Laporan')
@section('content')<div class="page-header">
        <div>
            <p class="eyebrow">LAPORAN SAMPAH</p>
            <h1>Detail Laporan</h1>
            <p>{{ $laporan->nomor }}</p>
        </div><a class="outline" href="{{ route('petugas.laporan.index') }}">Kembali ke laporan</a>
    </div>
    <div class="grid wide">
        <div class="card"><x-badge :status="$laporan->status" /> <span class="badge {{ $laporan->prioritas }}">Prioritas
                {{ $laporan->prioritas }}</span><img class="report-photo" src="{{ asset('storage/' . $laporan->foto_path) }}"
                alt="Kondisi sampah yang dilaporkan">
            <h2>{{ $laporan->judul }}</h2>
            <div class="info-grid">
                @foreach (['Jenis sampah' => ucfirst(str_replace('_', ' ', $laporan->kategori)), 'Kondisi' => $laporan->kondisi, 'Jumlah' => $laporan->jumlah, 'Lokasi' => $laporan->lokasi_teks, 'Deskripsi' => $laporan->deskripsi, 'Tanggal pengajuan' => $laporan->created_at->translatedFormat('d F Y, H.i') . ' WIB'] as $label => $text)
                    <div><small>{{ $label }}</small><strong>{{ $text }}</strong></div>
                @endforeach
            </div>
            <x-peta-viewer :markers="[['lat' => $laporan->lat, 'lng' => $laporan->lng, 'label' => $laporan->lokasi_teks]]" /><a class="outline"
                href="https://www.google.com/maps/dir/?api=1&destination={{ $laporan->lat }},{{ $laporan->lng }}"
                target="_blank" rel="noopener"><i data-lucide="navigation"></i>Buka navigasi</a>
            <hr>
            <p>Pelapor: {{ $laporan->user->nama }}<br>Kontak:
                {{ $laporan->user->telepon ?? 'Belum diisi' }}<br>{{ $laporan->user->email }}</p>
        </div>
        <div>
            @if ($laporan->status !== 'selesai')
                <div class="card">
                    <h2>Kelola status laporan</h2>
                    <form method="post" action="{{ route('petugas.laporan.update', $laporan) }}">@csrf
                        @method('PATCH')@php($statusOptions = collect(\App\Services\LaporanStatusService::STATUSES)->filter(fn($label, $key) => auth()->user()->role === 'admin' || array_search($key, array_keys(\App\Services\LaporanStatusService::STATUSES)) >= array_search($laporan->status, array_keys(\App\Services\LaporanStatusService::STATUSES)))->all())<x-field name="status" label="Status laporan"
                            :value="$laporan->status" :options="$statusOptions" required /><x-field name="catatan" label="Catatan petugas"
                            type="textarea" :value="$laporan->catatan_petugas" /><x-field name="estimasi_tiba" label="Estimasi tiba"
                            type="time" :value="$laporan->estimasi_tiba ? substr($laporan->estimasi_tiba, 0, 5) : null" /><button class="button full" type="submit">Perbarui
                            Status</button><small>Perubahan status akan langsung terlihat oleh warga dan admin.</small>
                    </form>
            </div>@else<div class="notice">Laporan ini sudah selesai ditangani.</div>
            @endif
            <div class="card">
                <h2>Status laporanmu</h2>
                <p>Petugas: {{ $laporan->petugas?->nama ?? 'Menunggu penugasan' }}</p><x-timeline :laporan="$laporan" />
            </div>
        </div>
    </div>
@endsection
