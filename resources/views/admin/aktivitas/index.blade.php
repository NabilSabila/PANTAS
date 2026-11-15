@extends('admin.layouts.app')
@section('title','Aktivitas Sistem')
@section('content')<div class="page-header"><div><p class="eyebrow">ADMIN CONSOLE</p><h1>Aktivitas Sistem</h1><p>Kelola informasi dan operasional layanan PANTAS.</p></div></div><div class="card">@forelse($items as $item)<div class="list-link"><span><strong>{{ $item->judul }}</strong><p>{{ $item->keterangan }}</p><small>{{ $item->created_at->translatedFormat('d F Y, H.i') }} WIB</small></span></div>@empty<x-empty-state title="Belum ada aktivitas."/>@endforelse{{ $items->links() }}</div>
@endsection