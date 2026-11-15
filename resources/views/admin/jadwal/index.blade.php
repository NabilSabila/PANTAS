@extends('admin.layouts.app')
@section('title', 'Kelola Jadwal')
@section('content')<div class="page-header">
        <div>
            <p class="eyebrow">ADMIN CONSOLE</p>
            <h1>Kelola Jadwal</h1>
            <p>Kelola informasi dan operasional layanan PANTAS.</p>
        </div><a class="button" href="{{ route('admin.jadwal.create') }}"><i data-lucide="plus"></i>Tambah Jadwal</a>
    </div>@include('admin.jadwal.list')
@endsection
