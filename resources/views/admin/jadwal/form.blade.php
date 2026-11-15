@extends('admin.layouts.app')
@section('title', 'Kelola Jadwal')
@section('content')<div class="page-header">
        <div>
            <p class="eyebrow">ADMIN CONSOLE</p>
            <h1>Kelola Jadwal</h1>
            <p>Kelola informasi dan operasional layanan PANTAS.</p>
        </div>
    </div>@php($editing = (bool) $item)<div class="card">
        <h2>{{ $editing ? 'Edit' : 'Tambah' }} Jadwal</h2>
        <form method="post" action="{{ $editing ? route('admin.jadwal.update', $item->id) : route('admin.jadwal.store') }}">
            @csrf @if ($editing)
                @method('PUT')
            @endif
            <div class="form-grid">
                <x-field name="wilayah_id" label="Area" :value="$item?->wilayah_id" :options="$wilayah->pluck('nama', 'id')"
                    required />@php($hari = old('hari', $item?->hari ?? []))<div class="field"><label for="hari">Hari
                        pengangkutan</label><input id="hari" name="hari" type="text"
                        value="{{ is_array($hari) ? implode(', ', $hari) : $hari }}" placeholder="Senin, Rabu, Jumat"
                        required>
                    @error('hari')
                        <small class="error" role="alert">{{ $message }}</small>
                        @enderror @error('hari.*')
                        <small class="error" role="alert">{{ $message }}</small>
                    @enderror
                </div><x-field name="jam_mulai" label="Jam mulai" type="time" :value="$item ? substr($item->jam_mulai, 0, 5) : null" required /><x-field
                    name="jam_selesai" label="Jam selesai" type="time" :value="$item ? substr($item->jam_selesai, 0, 5) : null" required /><x-field
                    name="jenis_sampah" label="Jenis sampah" :value="$item?->jenis_sampah" :options="collect([
                        'Umum',
                        'Organik',
                        'Daur Ulang',
                        'Umum & Organik',
                        'Umum & Daur Ulang',
                        'Organik & Daur Ulang',
                    ])
                        ->mapWithKeys(fn($v) => [$v => $v])
                        ->all()" required /><x-field
                    name="status" label="Status" :value="$item?->status ?? 'aktif'" :options="['aktif' => 'Aktif', 'nonaktif' => 'Nonaktif']" required /><x-field name="tanggal"
                    label="Tanggal berlaku" type="date" :value="$item?->tanggal?->toDateString()" />
            </div>
            <div class="actions"><a class="outline" href="{{ route('admin.jadwal.index') }}">Batal</a><button
                    class="button"><i data-lucide="save"></i>Simpan Perubahan</button></div>
        </form>
    </div>
    @include('admin.jadwal.list')
@endsection
