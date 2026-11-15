@extends('warga.layouts.app')
@section('title','Panduan Memilah Sampah')
@section('content')<div class="page-header"><div><p class="eyebrow">BELAJAR BERSAMA</p><h1>Panduan Memilah Sampah</h1><p>{{ $materi['sub'] }}</p></div></div><div class="card"><h2>Tiga kebiasaan sederhana</h2><div class="card-grid">@foreach($materi['kartu'] as $card)<div><span class="icon-box"><i data-lucide="recycle"></i></span><h3>{{ $card['judul'] }}</h3><p>{{ $card['teks'] }}</p></div>@endforeach</div></div><div class="card-grid">@foreach(['organik'=>'Organik','plastik'=>'Plastik','elektronik'=>'Elektronik','b3'=>'B3','daur-ulang'=>'Daur Ulang'] as $slug=>$label)<a class="card" href="{{ route('warga.edukasi.show',$slug) }}"><h3>{{ $label }}</h3>Panduan {{ strtolower($label) }} ?</a>@endforeach</div>
@endsection
