@extends('warga.layouts.app')
@section('title','Konten Edukasi')
@section('content')<div class="page-header"><div><p class="eyebrow">BELAJAR BERSAMA</p><h1>Konten Edukasi</h1><p></p></div></div><div class="card"><small>{{ $edukasi->kategori }}</small><h2>{{ $edukasi->judul }}</h2><p style="white-space:pre-line">{{ $edukasi->ringkasan }}</p><a class="outline" href="{{ route('warga.edukasi') }}">Kembali</a></div>
@endsection
