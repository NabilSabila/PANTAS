@extends('admin.layouts.app')
@section('title','Kelola Edukasi')
@section('content')<div class="page-header"><div><p class="eyebrow">ADMIN CONSOLE</p><h1>Kelola Edukasi</h1><p>Kelola informasi dan operasional layanan PANTAS.</p></div><a class="button" href="{{ route('admin.edukasi.create') }}"><i data-lucide="plus"></i>Tambah Konten</a></div>@include('admin.edukasi.list')
@endsection
