@extends('admin.layouts.app')
@section('title', 'Edit Profil Admin')
@section('content')
<div class="page-header">
    <div>
        <p class="eyebrow">AKUN & PENGATURAN</p>
        <h1>Edit Profil Admin</h1>
        <p>Perbarui informasi pribadi dan foto akun.</p>
    </div>
</div>

<div class="card">
    <form method="POST" action="{{ route('admin.profil.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-grid">
            <x-field name="nama" label="Nama lengkap" :value="$user->nama" required />
            <x-field name="telepon" label="Nomor telepon" :value="$user->telepon" />
            <x-field name="email" label="Email" type="email" :value="$user->email" readonly />
            <x-field name="wilayah_id" label="Kecamatan alamat" :value="$user->wilayah_id" :options="$wilayah->pluck('nama','id')" />
            <div class="span-2">
                <x-field name="alamat" label="Alamat lengkap" type="textarea" :value="$user->alamat" />
            </div>
            <div class="span-2">
                <x-field name="avatar" label="Ubah foto profil" type="file" accept="image/jpeg,image/png,image/webp" />
            </div>
        </div>
        <div class="actions">
            <a class="outline" href="{{ route('admin.profil') }}">Batal</a>
            <button class="button" type="submit">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
