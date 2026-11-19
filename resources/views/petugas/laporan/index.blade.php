@extends('petugas.layouts.app')
@section('title', 'Laporan Masuk')
@section('content')<div class="page-header">
        <div>
            <p class="eyebrow">PANTAU PROGRES</p>
            <h1>Laporan Masuk</h1>
            <p>Lacak setiap perkembangan dan penanganan laporan.</p>
        </div>
    </div>
    <form class="filters" method="get"><input name="q" value="{{ request('q') }}"
            placeholder="Cari ID, pelapor, atau lokasi"><button class="outline">Cari</button>
        @foreach (['' => 'Semua', 'baru' => 'Baru', 'diterima' => 'Diterima', 'diproses' => 'Diproses', 'selesai' => 'Selesai', 'prioritas' => 'Prioritas'] as $key => $label)
            <a class="outline small {{ request('filter', '') === $key ? 'selected' : '' }}"
                href="{{ request()->fullUrlWithQuery(['filter' => $key, 'page' => 1]) }}">{{ $label }}</a>
        @endforeach
    </form>
    @forelse($laporan as $item)
        <a href="{{ route('petugas.laporan.show', $item) }}" class="card report-card">
            <div class="report-row"><img src="{{ asset('storage/' . $item->foto_path) }}" alt="Foto laporan">
                <div><x-badge :status="$item->status" /> <span class="badge {{ $item->prioritas }}">Prioritas
                        {{ $item->prioritas }}</span>
                    <h3>{{ $item->judul }}</h3>
                    <p>{{ $item->lokasi_teks }}</p><small>{{ $item->nomor }} &bull;
                        {{ $item->created_at->translatedFormat('d M Y') }}</small>
                </div><i data-lucide="chevron-right"></i>
            </div>
    </a>@empty<div class="card"><x-empty-state title="Belum ada laporan."
                description="Laporan akan muncul setelah dikirim oleh warga." /></div>
    @endforelse{{ $laporan->links() }}
@endsection
