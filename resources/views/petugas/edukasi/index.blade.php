@extends('petugas.layouts.app')
@section('title','Edukasi Petugas')
@section('content')<div class="page-header"><div><p class="eyebrow">BELAJAR BERSAMA</p><h1>Edukasi Petugas</h1><p>Konten edukasi yang diterbitkan PANTAS untukmu.</p></div></div>
@if($konten->isEmpty())<div class="card"><x-empty-state title="Belum ada konten edukasi."/></div>@else<div class="card-grid">@foreach($konten as $item)<a class="card report-card" href="{{ route('petugas.edukasi.konten',$item) }}"><span class="icon-box"><i data-lucide="book-open"></i></span><h3>{{ $item->judul }}</h3><small>{{ $item->kategori }} • {{ $item->published_at?->translatedFormat('d F Y') }}</small><p>{{ Str::limit($item->ringkasan,160) }}</p></a>@endforeach</div>@endif

@endsection