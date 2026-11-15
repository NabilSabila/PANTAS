@extends('admin.layouts.app')
@section('title','Kelola Rute')
@section('content')<div class="page-header"><div><p class="eyebrow">ADMIN CONSOLE</p><h1>Kelola Rute</h1><p>Kelola informasi dan operasional layanan PANTAS.</p></div><a class="button" href="{{ route('admin.rute.create') }}"><i data-lucide="plus"></i>Buat Rute</a></div>@include('admin.rute.list')
@endsection
