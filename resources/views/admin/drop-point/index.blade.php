@extends('admin.layouts.app')
@section('title','Kelola Drop Point')
@section('content')<div class="page-header"><div><p class="eyebrow">ADMIN CONSOLE</p><h1>Kelola Drop Point</h1><p>Kelola informasi dan operasional layanan PANTAS.</p></div><a class="button" href="{{ route('admin.drop-point.create') }}"><i data-lucide="plus"></i>Tambah Drop Point</a></div>@include('admin.drop-point.list')
@endsection
