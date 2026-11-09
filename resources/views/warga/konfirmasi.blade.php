@extends('layouts.warga')

@section('title', 'PANTAS | Konfirmasi Terkirim')
@section('breadcrumb', 'Laporan / Konfirmasi')

@section('content')
<div style="padding: 24px; max-width: 900px; margin: 0 auto;">
    
    <span style="font-size: 12px; font-weight: 700; color: #6c757d; letter-spacing: 0.5px;">LAPORAN BARU</span>
    <h2 style="font-size: 24px; font-weight: 800; color: #212529; margin: 4px 0 24px 0;">Konfirmasi Terkirim</h2>

    <div style="background: #ffffff; border: 1px solid #e9ecef; border-radius: 12px; padding: 48px 32px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        
        <!-- Ikon Centang Hijau -->
        <div style="width: 64px; height: 64px; background: #d1e7dd; color: #198754; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 28px; margin: 0 auto 16px auto;">
            ✓
        </div>

        <div style="margin-bottom: 16px;">
            <span style="background: #d1e7dd; color: #0f5132; font-size: 12px; font-weight: 600; padding: 6px 14px; border-radius: 20px; display: inline-block;">
                LAPORAN BERHASIL DIKIRIM
            </span>
        </div>

        <h3 style="font-size: 22px; font-weight: 800; color: #212529; margin: 0 0 8px 0;">
            Terima kasih sudah peduli !
        </h3>
        
        <p style="font-size: 14px; color: #6c757d; max-width: 480px; margin: 0 auto 24px auto; line-height: 1.5;">
            Petugas wilayahmu telah menerima notifikasi dan akan segera meninjau laporan dengan kode: <strong style="color: #212529;">{{ $laporan->kode_laporan ?? '-' }}</strong>
        </p>

        <!-- Ringkasan Singkat Laporan yang Rapi & Terstruktur -->
        <div style="background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 8px; padding: 16px 20px; max-width: 550px; margin: 0 auto 32px auto; font-size: 13px; color: #495057; text-align: left;">
            <div style="margin-bottom: 8px;">
                <span style="color: #6c757d; font-weight: 500;">Deskripsi:</span> 
                <span style="color: #212529; font-weight: 600;">{{ Str::limit($laporan->deskripsi ?? '-', 60) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                <div><span style="color: #6c757d;">Kategori:</span> <strong style="color: #212529;">{{ $laporan->kategori_sampah ?? '-' }}</strong></div>
                <div><span style="color: #6c757d;">Jumlah:</span> <strong style="color: #212529;">{{ $laporan->jumlah ?? '-' }}</strong></div>
            </div>
            <div style="margin-bottom: 6px;">
                <span style="color: #6c757d;">Lokasi:</span> <strong style="color: #212529;">{{ $laporan->lokasi ?? '-' }}</strong>
            </div>
            <div>
                <span style="color: #6c757d;">Waktu:</span> <strong style="color: #212529;">{{ optional($laporan->created_at)->format('d F Y, H:i') ?? '-' }} WIB</strong>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <!-- Tombol Aksi yang Aman dari Error Route -->
        <div style="display: flex; flex-direction: column; gap: 12px; align-items: center;">
            <a href="{{ route('warga.laporan.index') }}" style="background-color: #198754; color: white; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 6px rgba(25, 135, 84, 0.2);">
                👁 Lihat Daftar Laporan &rarr;
            </a>
            
            <a href="{{ route('warga.dashboard') }}" style="background: white; border: 1px solid #ced4da; color: #495057; padding: 10px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 13px;">
                Kembali ke Beranda
            </a>
        </div>

    </div>
</div>
@endsection