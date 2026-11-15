@extends('warga.layouts.app')
@section('title','Edit Profil')
@section('content')
<div class="page-header"><div><p class="eyebrow">AKUN & PENGATURAN</p><h1>Edit Profil</h1><p>Perbarui informasi pribadi dan foto akunmu.</p></div></div>
<form method="post" action="{{ route('warga.profil.update') }}" enctype="multipart/form-data">@csrf @method('PATCH')
<div class="banner"><h2>{{ $user->nama }}</h2><p>{{ ucfirst($user->role) }} • {{ $user->kode }}</p><x-field name="avatar" label="Ubah Foto" type="file" accept="image/jpeg,image/png,image/webp"/></div>
<div class="card"><h2>Informasi pribadi</h2><div class="form-grid"><x-field name="nama" label="Nama lengkap" :value="$user->nama" required/><x-field name="telepon" label="Nomor telepon" :value="$user->telepon"/><x-field name="email" label="Email" :value="$user->email" readonly/><x-field name="wilayah_id" label="Kecamatan alamat" :value="$user->wilayah_id" :options="$wilayah->pluck('nama','id')" required/>
<div class="span-2"><x-field name="alamat" label="Alamat lengkap" type="textarea" :value="$user->alamat"/><x-peta-picker address-target="alamat" lat-name="alamat_lat" lng-name="alamat_lng" :lat="$user->alamat_lat" :lng="$user->alamat_lng"/></div></div>
<div class="actions"><a class="outline" href="{{ route('warga.profil') }}">Batal</a><button class="button">Simpan Perubahan</button></div></div></form>
@endsection