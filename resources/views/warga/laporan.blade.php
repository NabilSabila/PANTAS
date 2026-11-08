@extends('layouts.warga')

@section('title', 'PANTAS | Status Laporan')
@section('breadcrumb', 'Laporan')

@section('content')
<div style="padding: 24px;">
    
    <!-- Header Bagian Atas -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px;">
        <div>
            <span style="font-size: 12px; font-weight: 700; color: #6c757d; letter-spacing: 0.5px;">PANTAU PROGRES</span>
            <h2 style="font-size: 24px; font-weight: 800; color: #212529; margin: 4px 0;">Status Laporan</h2>
            <p style="font-size: 14px; color: #6c757d; margin: 0;">Lacak setiap perkembangan laporanmu.</p>
        </div>
        <a href="{{ route('warga.laporan.create') }}" style="background-color: #198754; color: white; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; display: inline-flex; align-items: center; gap: 8px;">
            + Buat Laporan
        </a>
    </div>

    <!-- Layout Dua Kolom -->
    <div style="display: grid; grid-template-columns: 4fr 6fr; gap: 24px; align-items: start;">
        
        <!-- Kolom Kiri: Daftar Laporan -->
        <div style="display: flex; flex-direction: column; gap: 16px;">
            @forelse($laporans as $item)
            <div style="background: #ffffff; border: {{ isset($selectedLaporan) && $selectedLaporan->id == $item->id ? '2px solid #198754' : '1px solid #e9ecef' }}; border-radius: 12px; padding: 18px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <span style="background-color: #fff3cd; color: #856404; font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 20px;">{{ $item->status }}</span>
                    <span style="font-size: 12px; color: #adb5bd; font-weight: 500;">#{{ $item->kode_laporan }}</span>
                </div>
                
                <h4 style="font-size: 16px; font-weight: 700; color: #212529; margin-bottom: 6px;">{{ Str::limit($item->deskripsi, 35) }}</h4>
                
                <p style="font-size: 13px; color: #6c757d; margin-bottom: 8px;">
                    📍 {{ $item->lokasi }}
                </p>
                
                <p style="font-size: 12px; color: #adb5bd; margin-bottom: 12px;">Dibuat {{ $item->created_at->format('d F Y') }}</p>
                
                <a href="{{ route('warga.laporan.show', $item->id) }}" style="color: #198754; font-size: 13px; font-weight: 600; text-decoration: none;">
                    Lihat detail laporan &rarr;
                </a>
            </div>
            @empty
            <div style="background: #ffffff; border: 1px solid #e9ecef; border-radius: 12px; padding: 32px; text-align: center; color: #6c757d;">
                <p style="margin: 0; font-size: 14px;">Belum ada laporan yang dibuat.</p>
            </div>
            @endforelse
        </div>

        <!-- Kolom Kanan: Timeline Perjalanan Laporan -->
        @if(isset($selectedLaporan))
        <div style="background: #ffffff; border: 1px solid #e9ecef; border-radius: 12px; padding: 24px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <span style="font-size: 12px; color: #adb5bd; font-weight: 500;">{{ $selectedLaporan->kode_laporan }}</span>
            <h3 style="font-size: 18px; font-weight: 800; color: #212529; margin-top: 4px; margin-bottom: 24px;">Perjalanan laporanmu</h3>

            <!-- Timeline List -->
            <div style="display: flex; flex-direction: column; gap: 20px;">
                
                <!-- Step 1 -->
                <div style="display: flex; gap: 14px; align-items: flex-start;">
                    <div style="background: #198754; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0;">✓</div>
                    <div>
                        <h5 style="font-size: 14px; font-weight: 700; color: #212529; margin: 0;">
                            Laporan Dikirim <span style="font-weight: 400; color: #6c757d; font-size: 12px; margin-left: 6px;">{{ $selectedLaporan->created_at->format('d Jun, H:i') }}</span>
                        </h5>
                        <p style="font-size: 13px; color: #6c757d; margin: 2px 0 0 0;">Foto dan detail laporan berhasil dikirim.</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div style="display: flex; gap: 14px; align-items: flex-start;">
                    <div style="background: #198754; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0;">✓</div>
                    <div>
                        <h5 style="font-size: 14px; font-weight: 700; color: #212529; margin: 0;">Laporan Diterima</h5>
                        <p style="font-size: 13px; color: #6c757d; margin: 2px 0 0 0;">Laporan diverifikasi oleh sistem.</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div style="display: flex; gap: 14px; align-items: flex-start;">
                    <div style="background: #e9ecef; color: #6c757d; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0;">⏳</div>
                    <div>
                        <h5 style="font-size: 14px; font-weight: 700; color: #adb5bd; margin: 0;">Sedang Diproses</h5>
                        <p style="font-size: 13px; color: #adb5bd; margin: 2px 0 0 0;">Petugas telah ditugaskan.</p>
                    </div>
                </div>

            </div>
        </div>
        @endif

    </div>
</div>
@endsection