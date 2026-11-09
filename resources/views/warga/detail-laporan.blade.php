@extends('layouts.warga')

@section('title', 'PANTAS | Detail Laporan')
@section('breadcrumb', 'Laporan / Detail')

@section('content')
<div style="padding: 24px;">
    
    <div style="margin-bottom: 20px;">
        <span style="font-size: 12px; font-weight: 700; color: #6c757d; letter-spacing: 0.5px;">LAPORAN BARU</span>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 4px;">
            <h2 style="font-size: 24px; font-weight: 800; color: #212529; margin: 0;">Detail Laporan</h2>
            <a href="{{ route('warga.laporan.index') }}" style="background: white; border: 1px solid #ced4da; color: #212529; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 13px;">
                Kembali ke laporan
            </a>
        </div>
        <p style="font-size: 13px; color: #6c757d; margin: 4px 0 0 0;">{{ $selectedLaporan->kode_laporan }} • Lacak setiap perkembangan laporanmu.</p>
    </div>

    <!-- Layout Dua Kolom Sesuai Figma -->
    <div style="display: grid; grid-template-columns: 6fr 5fr; gap: 24px; align-items: start;">
        
        <!-- Kolom Kiri: Detail Data & Foto Laporan -->
        <div style="background: #ffffff; border: 1px solid #e9ecef; border-radius: 12px; padding: 24px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            
            <!-- Badge Status di dalam Detail (Opsional) -->
            <div style="margin-bottom: 16px;">
                <span style="background-color: #fff3cd; color: #856404; font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 20px;">
                    {{ $selectedLaporan->status }}
                </span>
            </div>

            <!-- Foto Laporan -->
            @if($selectedLaporan->foto)
            <div style="margin-bottom: 20px; border-radius: 8px; overflow: hidden; max-height: 280px; background: #f8f9fa;">
                <img src="{{ asset($selectedLaporan->foto) }}" alt="Foto Laporan" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            @endif

            <!-- Detail Informasi -->
            <div style="margin-bottom: 16px;">
                <span style="font-size: 11px; font-weight: 600; color: #6c757d; text-transform: uppercase;">Jenis sampah</span>
                <p style="font-size: 15px; font-weight: 700; color: #212529; margin: 2px 0 0 0;">{{ $selectedLaporan->kategori_sampah }}</p>
            </div>

            <div style="margin-bottom: 16px;">
                <span style="font-size: 11px; font-weight: 600; color: #6c757d; text-transform: uppercase;">Kondisi</span>
                <p style="font-size: 15px; font-weight: 700; color: #212529; margin: 2px 0 0 0;">{{ $selectedLaporan->kondisi }}</p>
            </div>

            <div style="margin-bottom: 16px;">
                <span style="font-size: 11px; font-weight: 600; color: #6c757d; text-transform: uppercase;">Jumlah</span>
                <p style="font-size: 15px; font-weight: 700; color: #212529; margin: 2px 0 0 0;">{{ $selectedLaporan->jumlah }}</p>
            </div>

            <div style="margin-bottom: 16px;">
                <span style="font-size: 11px; font-weight: 600; color: #6c757d; text-transform: uppercase;">Lokasi</span>
                <p style="font-size: 15px; font-weight: 700; color: #212529; margin: 2px 0 0 0;">📍 {{ $selectedLaporan->lokasi }}</p>
            </div>

            <div style="margin-bottom: 16px;">
                <span style="font-size: 11px; font-weight: 600; color: #6c757d; text-transform: uppercase;">Deskripsi</span>
                <p style="font-size: 14px; color: #212529; margin: 2px 0 0 0; line-height: 1.5;">{{ $selectedLaporan->deskripsi }}</p>
            </div>

            <div>
                <span style="font-size: 11px; font-weight: 600; color: #6c757d; text-transform: uppercase;">Tanggal pengajuan</span>
                <p style="font-size: 13px; font-weight: 600; color: #495057; margin: 2px 0 0 0;">{{ $selectedLaporan->created_at->format('d F Y, H:i') }} WIB</p>
            </div>

        </div>

        <!-- Kolom Kanan: Status Laporanmu (Timeline) -->
        <div style="background: #ffffff; border: 1px solid #e9ecef; border-radius: 12px; padding: 24px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <h3 style="font-size: 18px; font-weight: 800; color: #212529; margin-top: 0; margin-bottom: 8px;">Status laporanmu</h3>
            <p style="font-size: 12px; color: #6c757d; margin-bottom: 24px;">Petugas: {{ $selectedLaporan->petugas_nama ?? 'Belum ditugaskan' }} • Rute B-04</p>

            <!-- Timeline Steps -->
            <div style="display: flex; flex-direction: column; gap: 20px;">
                
                <div style="display: flex; gap: 14px; align-items: flex-start;">
                    <div style="background: #198754; color: white; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; flex-shrink: 0;">✓</div>
                    <div>
                        <h5 style="font-size: 13px; font-weight: 700; color: #212529; margin: 0;">
                            Laporan Dikirim <span style="font-weight: 400; color: #6c757d; font-size: 11px; margin-left: 4px;">{{ $selectedLaporan->created_at->format('d M, H:i') }}</span>
                        </h5>
                        <p style="font-size: 12px; color: #6c757d; margin: 2px 0 0 0;">Foto dan detail laporan berhasil dikirim.</p>
                    </div>
                </div>

                <div style="display: flex; gap: 14px; align-items: flex-start;">
                    <div style="background: #198754; color: white; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; flex-shrink: 0;">✓</div>
                    <div>
                        <h5 style="font-size: 13px; font-weight: 700; color: #212529; margin: 0;">Laporan Diterima</h5>
                        <p style="font-size: 12px; color: #6c757d; margin: 2px 0 0 0;">Laporan diverifikasi oleh sistem.</p>
                    </div>
                </div>

                <div style="display: flex; gap: 14px; align-items: flex-start;">
                    <div style="background: #198754; color: white; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; flex-shrink: 0;">⏳</div>
                    <div>
                        <h5 style="font-size: 13px; font-weight: 700; color: #212529; margin: 0;">Sedang Diproses</h5>
                        <p style="font-size: 12px; color: #6c757d; margin: 2px 0 0 0;">Petugas telah ditugaskan.</p>
                    </div>
                </div>

                <div style="display: flex; gap: 14px; align-items: flex-start;">
                    <div style="background: #e9ecef; color: #6c757d; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; flex-shrink: 0;">📍</div>
                    <div>
                        <h5 style="font-size: 13px; font-weight: 700; color: #adb5bd; margin: 0;">Petugas Menuju Lokasi</h5>
                        <p style="font-size: 12px; color: #adb5bd; margin: 2px 0 0 0;">Armada sedang menuju lokasi.</p>
                    </div>
                </div>

                <div style="display: flex; gap: 14px; align-items: flex-start;">
                    <div style="background: #e9ecef; color: #6c757d; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; flex-shrink: 0;">🏁</div>
                    <div>
                        <h5 style="font-size: 13px; font-weight: 700; color: #adb5bd; margin: 0;">Selesai</h5>
                        <p style="font-size: 12px; color: #adb5bd; margin: 2px 0 0 0;">Lokasi akan dibersihkan setelah ditangani.</p>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection