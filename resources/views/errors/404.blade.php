{{-- Petugas yang belum memiliki route memakai halaman 404 standar Laravel. --}}
@if(request()->is('petugas/*'))
    @section('title', 'Not Found')
    @section('code', '404')
    @section('message', 'Not Found')
    @include('errors::minimal')
@else
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Halaman tidak ditemukan | PANTAS</title><link rel="stylesheet" href="{{ asset('assets/css/warga.css') }}"></head><body><main style="max-width:500px;margin:15vh auto;padding:20px"><div class="card"><p class="eyebrow">404</p><h1>Halaman tidak ditemukan</h1><p>Halaman yang kamu cari belum tersedia.</p><a class="button" href="{{ route('landing') }}">Kembali ke beranda</a></div></main></body></html>

@endif
