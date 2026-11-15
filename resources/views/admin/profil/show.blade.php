@extends('admin.layouts.app')
@section('title', 'Profil Admin')
@section('content')
<div class="page-header">
    <div>
        <p class="eyebrow">AKUN & PENGATURAN</p>
        <h1>Profil Admin</h1>
        <p>Kelola informasi akun administrator.</p>
    </div>
    <a class="button" href="{{ route('admin.profil.edit') }}">
        <i data-lucide="pencil"></i> Edit Profil
    </a>
</div>

<div class="banner">
    <div class="report-row">
        <span class="avatar">
            @if($user->avatar_path)
                <img src="{{ asset('storage/'.$user->avatar_path) }}" alt="Foto profil">
            @else
                <i data-lucide="user"></i>
            @endif
        </span>
        <div>
            <h2>{{ $user->nama }}</h2>
            <p>{{ $user->is_super ? 'Super Administrator' : 'Administrator' }} &bull; {{ $user->kode }}</p>
            <span class="badge aktif">{{ ucfirst($user->status) }}</span>
        </div>
    </div>
</div>

<div class="card">
    <h2>Informasi Pribadi</h2>
    <div class="form-grid">
        <x-field name="nama" label="Nama lengkap" :value="$user->nama" readonly />
        <x-field name="telepon" label="Nomor telepon" :value="$user->telepon" readonly />
        <x-field name="email" label="Email" type="email" :value="$user->email" readonly />
        <x-field name="wilayah" label="Kecamatan alamat" :value="$user->wilayah?->nama ?? 'Belum diatur'" readonly />
        <div class="span-2">
            <x-field name="alamat" label="Alamat lengkap" type="textarea" :value="$user->alamat" readonly />
        </div>
    </div>
</div>
@endsection
