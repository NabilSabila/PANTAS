@extends('admin.layouts.app')
@section('title', 'Kelola Laporan')
@section('content')<div class="page-header">
        <div>
            <p class="eyebrow">PANTAU PROGRES</p>
            <h1>Kelola Laporan</h1>
            <p>Lacak setiap perkembangan dan penanganan laporan.</p>
        </div>
    </div>
    <div class="stats four">
        @foreach ($metrics as $label => $value)
            <div class="card"><small>{{ $label }}</small><strong
                    class="stat-value">{{ number_format($value, 0, ',', '.') }}</strong></div>
        @endforeach
    </div>
    <form class="filters" method="get"><input name="q" value="{{ request('q') }}"
            placeholder="Cari ID, pelapor, atau lokasi"><select name="wilayah" aria-label="Filter kecamatan"
            style="max-width:200px">
            <option value="">Semua kecamatan</option>
            @foreach ($wilayah as $area)
                <option value="{{ $area->id }}" @selected((string) request('wilayah') === (string) $area->id)>{{ $area->nama }}</option>
            @endforeach
        </select>
        <button class="outline">Cari</button>
        @foreach (['' => 'Semua', 'baru' => 'Baru', 'diterima' => 'Diterima', 'diproses' => 'Diproses', 'selesai' => 'Selesai', 'prioritas' => 'Prioritas'] as $key => $label)
            <a class="outline small {{ request('filter', '') === $key ? 'selected' : '' }}"
                href="{{ request()->fullUrlWithQuery(['filter' => $key, 'page' => 1]) }}">{{ $label }}</a>
        @endforeach
    </form>
    <div class="card table-wrap">
        <table>
            <thead>
                <tr>
                    @foreach (['ID Laporan', 'Pelapor', 'Jenis Sampah', 'Lokasi', 'Tanggal', 'Petugas', 'Status'] as $heading)
                        <th>{{ $heading }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($laporan as $item)
                    <tr>
                        <td><a href="{{ route('admin.laporan.show', $item) }}"><strong>{{ $item->nomor }}</strong></a></td>
                        <td>{{ $item->user->nama }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $item->kategori)) }}</td>
                        <td>{{ $item->wilayah?->nama ?? 'Belum diatur' }}</td>
                        <td>{{ $item->created_at->translatedFormat('d M Y') }}</td>
                        <td>{{ $item->petugas?->nama ?? 'Belum ditugaskan' }}</td>
                        <td><x-badge :status="$item->status" /></td>
                </tr>@empty<tr>
                        <td colspan="7"><x-empty-state title="Belum ada laporan." /></td>
                    </tr>
                @endforelse
            </tbody>
        </table>{{ $laporan->links() }}
    </div>
@endsection
