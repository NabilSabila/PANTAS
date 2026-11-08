@extends('layouts.warga')

@section('title', 'PANTAS | Laporkan Sampah')
@section('breadcrumb', 'Laporan / Buat')

@section('content')
<div style="padding: 24px; max-width: 950px; margin: 0 auto;">
    
    <span style="font-size: 12px; font-weight: 700; color: #6c757d; letter-spacing: 0.5px;">LAPORAN BARU</span>
    <h2 style="font-size: 24px; font-weight: 800; color: #212529; margin: 4px 0 4px 0;">Laporkan Sampah</h2>
    <p style="font-size: 14px; color: #6c757d; margin-bottom: 24px;">Bantu petugas menemukan dan menangani sampah di lingkunganmu.</p>

    <!-- Indikator Step Figma (1, 2, 3) -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px; padding: 0 40px;">
        <div style="text-align: center;">
            <div style="width: 36px; height: 36px; background: {{ $step >= 1 ? '#198754' : '#e9ecef' }}; color: {{ $step >= 1 ? 'white' : '#6c757d' }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; margin: 0 auto 6px auto;">{{ $step > 1 ? '✓' : '1' }}</div>
            <span style="font-size: 12px; color: #6c757d;">Foto</span>
        </div>
        <div style="flex-grow: 1; height: 3px; background: {{ $step >= 2 ? '#198754' : '#e9ecef' }}; margin: 0 10px;"></div>
        <div style="text-align: center;">
            <div style="width: 36px; height: 36px; background: {{ $step >= 2 ? '#198754' : '#e9ecef' }}; color: {{ $step >= 2 ? 'white' : '#6c757d' }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; margin: 0 auto 6px auto;">{{ $step > 2 ? '✓' : '2' }}</div>
            <span style="font-size: 12px; color: #6c757d;">Detail</span>
        </div>
        <div style="flex-grow: 1; height: 3px; background: {{ $step >= 3 ? '#198754' : '#e9ecef' }}; margin: 0 10px;"></div>
        <div style="text-align: center;">
            <div style="width: 36px; height: 36px; background: {{ $step >= 3 ? '#198754' : '#e9ecef' }}; color: {{ $step >= 3 ? 'white' : '#6c757d' }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; margin: 0 auto 6px auto;">3</div>
            <span style="font-size: 12px; color: #6c757d;">Konfirmasi</span>
        </div>
    </div>

    @if ($errors->any())
        <div style="background: #f8d7da; color: #842029; padding: 12px 16px; border-radius: 8px; font-size: 13px; margin-bottom: 20px; border: 1px solid #f5c2c7;">
            <ul style="margin: 0; padding-left: 16px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="background: #ffffff; border: 1px solid #e9ecef; border-radius: 12px; padding: 32px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">

        <!-- ================= STEP 1: TAMBAHKAN FOTO ================= -->
        @if($step == 1)
        <form action="{{ route('warga.laporan.create.process') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="step" value="1">
            
            <h3 style="font-size: 18px; font-weight: 700; color: #212529; margin-bottom: 6px;">Tambahkan foto</h3>
            <p style="font-size: 13px; color: #6c757d; margin-bottom: 20px;">Foto yang jelas membantu petugas menilai kondisi lokasi.</p>

            <!-- Kotak Upload dengan Preview di Tengah -->
            <div style="border: 2px dashed #198754; border-radius: 12px; padding: 30px; text-align: center; background: #f8f9fa; margin-bottom: 24px; position: relative; cursor: pointer;">
                
                <input type="file" name="foto" id="inputFoto" accept="image/*" {{ isset($data['foto']) ? '' : 'required' }} style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; opacity: 0; cursor: pointer; z-index: 2;" onchange="previewImage(event)">

                <!-- Area Preview Foto (Dibuat centang & flex agar posisinya mutlak di tengah) -->
                <div id="previewContainer" style="{{ isset($data['foto']) ? 'display: block;' : 'display: none;' }}">
                    <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 12px;">
                        <img id="imgPreview" src="{{ isset($data['foto']) ? asset($data['foto']) : '#' }}" alt="Preview" style="max-height: 180px; max-width: 100%; border-radius: 8px; object-fit: contain;">
                    </div>
                    <p style="font-size: 13px; color: #198754; font-weight: 600; margin: 0;">✓ Foto terpilih • Ketuk untuk ganti foto</p>
                </div>

                <!-- Area Placeholder awal -->
                <div id="placeholderContainer" style="{{ isset($data['foto']) ? 'display: none;' : 'display: block;' }}">
                    <div style="font-size: 32px; margin-bottom: 8px;">📷</div>
                    <p style="font-size: 14px; font-weight: 600; color: #212529; margin: 0 0 4px 0;">Seret foto ke sini atau jelajahi file</p>
                    <p style="font-size: 12px; color: #6c757d; margin: 0;">Mendukung format JPG, PNG (Maks. 5MB)</p>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center;">
                <a href="{{ route('warga.laporan.index') }}" style="background: white; border: 1px solid #ced4da; color: #495057; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 13px;">Kembali</a>
                <button type="submit" style="background-color: #198754; color: white; padding: 10px 24px; border-radius: 8px; border: none; font-weight: 600; font-size: 14px; cursor: pointer;">Lanjut &rarr;</button>
            </div>
        </form>

        <script>
            function previewImage(event) {
                const reader = new FileReader();
                reader.onload = function(){
                    const output = document.getElementById('imgPreview');
                    output.src = reader.result;
                    document.getElementById('previewContainer').style.display = 'block';
                    document.getElementById('placeholderContainer').style.display = 'none';
                };
                if(event.target.files[0]) {
                    reader.readAsDataURL(event.target.files[0]);
                }
            }
        </script>
        @endif

        <!-- ================= STEP 2: DETAIL LAPORAN ================= -->
        @if($step == 2)
        <form action="{{ route('warga.laporan.create.process') }}" method="POST">
            @csrf
            <input type="hidden" name="step" value="2">
            
            <h3 style="font-size: 18px; font-weight: 700; color: #212529; margin-bottom: 6px;">Detail laporan</h3>
            <p style="font-size: 13px; color: #6c757d; margin-bottom: 20px;">Lengkapi informasi kondisi sampah.</p>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 16px;">
                <div>
                    <label style="font-size: 12px; font-weight: 700; color: #212529; display: block; margin-bottom: 6px;">Kategori sampah</label>
                    <select name="kategori_sampah" required style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 8px; font-size: 14px; background: white;">
                        <option value="" disabled {{ empty($data['kategori_sampah']) ? 'selected' : '' }}>Pilih kategori sampah</option>
                        <option value="Sampah Rumah Tangga" {{ (isset($data['kategori_sampah']) && $data['kategori_sampah'] == 'Sampah Rumah Tangga') ? 'selected' : '' }}>Sampah Rumah Tangga</option>
                        <option value="Sampah Elektronik" {{ (isset($data['kategori_sampah']) && $data['kategori_sampah'] == 'Sampah Elektronik') ? 'selected' : '' }}>Sampah Elektronik</option>
                        <option value="Minyak Jelantah" {{ (isset($data['kategori_sampah']) && $data['kategori_sampah'] == 'Minyak Jelantah') ? 'selected' : '' }}>Minyak Jelantah</option>
                        <option value="Sampah Daur Ulang" {{ (isset($data['kategori_sampah']) && $data['kategori_sampah'] == 'Sampah Daur Ulang') ? 'selected' : '' }}>Sampah Daur Ulang</option>
                    </select>
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 700; color: #212529; display: block; margin-bottom: 6px;">Kondisi</label>
                    <select name="kondisi" required style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 8px; font-size: 14px; background: white;">
                        <option value="" disabled {{ empty($data['kondisi']) ? 'selected' : '' }}>Pilih kondisi sampah</option>
                        <option value="Menumpuk dan berbau" {{ (isset($data['kondisi']) && $data['kondisi'] == 'Menumpuk dan berbau') ? 'selected' : '' }}>Menumpuk dan berbau</option>
                        <option value="Berserakan" {{ (isset($data['kondisi']) && $data['kondisi'] == 'Berserakan') ? 'selected' : '' }}>Berserakan</option>
                        <option value="Menyumbat saluran air" {{ (isset($data['kondisi']) && $data['kondisi'] == 'Menyumbat saluran air') ? 'selected' : '' }}>Menyumbat saluran air</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 16px;">
                <div>
                    <label style="font-size: 12px; font-weight: 700; color: #212529; display: block; margin-bottom: 6px;">Perkiraan jumlah</label>
                    <select name="jumlah" required style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 8px; font-size: 14px; background: white;">
                        <option value="" disabled {{ empty($data['jumlah']) ? 'selected' : '' }}>Pilih perkiraan jumlah</option>
                        <option value="1–2 kantong" {{ (isset($data['jumlah']) && $data['jumlah'] == '1–2 kantong') ? 'selected' : '' }}>1–2 kantong</option>
                        <option value="3–5 kantong" {{ (isset($data['jumlah']) && $data['jumlah'] == '3–5 kantong') ? 'selected' : '' }}>3–5 kantong</option>
                        <option value="Lebih dari 5 kantong" {{ (isset($data['jumlah']) && $data['jumlah'] == 'Lebih dari 5 kantong') ? 'selected' : '' }}>Lebih dari 5 kantong</option>
                    </select>
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 700; color: #212529; display: block; margin-bottom: 6px;">Lokasi</label>
                    <input type="text" name="lokasi" value="{{ $data['lokasi'] ?? '' }}" placeholder=" " required style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 8px; font-size: 14px;">
                </div>
            </div>

            <div style="margin-bottom: 24px;">
                <label style="font-size: 12px; font-weight: 700; color: #212529; display: block; margin-bottom: 6px;">Deskripsi</label>
                <textarea name="deskripsi" rows="3" placeholder=" " required style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 8px; font-size: 14px;">{{ $data['deskripsi'] ?? '' }}</textarea>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center;">
                <a href="{{ route('warga.laporan.create', ['step' => 1, 'back' => 1]) }}" style="background: white; border: 1px solid #ced4da; color: #495057; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 13px;">Kembali</a>
                <button type="submit" style="background-color: #198754; color: white; padding: 10px 24px; border-radius: 8px; border: none; font-weight: 600; font-size: 14px; cursor: pointer;">Lanjut &rarr;</button>
            </div>
        </form>
        @endif

        <!-- ================= STEP 3: KONFIRMASI LAPORAN (Sesuai Figma) ================= -->
        @if($step == 3)
        <form action="{{ route('warga.laporan.store') }}" method="POST">
            @csrf
            <h3 style="font-size: 18px; font-weight: 700; color: #212529; margin-bottom: 6px;">Konfirmasi laporan</h3>
            <p style="font-size: 13px; color: #6c757d; margin-bottom: 24px;">Pastikan informasi berikut sudah benar.</p>

            <!-- Layout 2 Kolom: Kiri (Foto), Kanan (Detail Informasi) sesuai Figma -->
            <div style="display: grid; grid-template-columns: 380px 1fr; gap: 24px; align-items: start; margin-bottom: 24px;">
                
                <!-- Kolom Kiri: Foto Laporan -->
                <div>
                    @if(isset($data['foto']))
                    <div style="border-radius: 8px; overflow: hidden; border: 1px solid #e9ecef; background: #f8f9fa; display: flex; align-items: center; justify-content: center; max-height: 260px;">
                        <img src="{{ asset($data['foto']) }}" alt="Foto Laporan" style="width: 100%; max-height: 260px; object-fit: contain; display: block;">
                    </div>
                    @endif
                </div>

                <!-- Kolom Kanan: Rincian Data Laporan -->
                <div style="display: flex; flex-direction: column; gap: 14px; font-size: 14px;">
                    <div>
                        <span style="font-size: 12px; color: #6c757d; display: block; margin-bottom: 2px;">Jenis sampah</span>
                        <strong style="color: #212529; font-weight: 600;">{{ $data['kategori_sampah'] ?? '-' }}</strong>
                    </div>
                    <div>
                        <span style="font-size: 12px; color: #6c757d; display: block; margin-bottom: 2px;">Kondisi</span>
                        <strong style="color: #212529; font-weight: 600;">{{ $data['kondisi'] ?? '-' }}</strong>
                    </div>
                    <div>
                        <span style="font-size: 12px; color: #6c757d; display: block; margin-bottom: 2px;">Jumlah</span>
                        <strong style="color: #212529; font-weight: 600;">{{ $data['jumlah'] ?? '-' }}</strong>
                    </div>
                    <div>
                        <span style="font-size: 12px; color: #6c757d; display: block; margin-bottom: 2px;">Lokasi</span>
                        <div style="display: flex; align-items: center; gap: 4px; color: #212529; font-weight: 600;">
                            <span style="font-size: 14px;">📍</span> {{ $data['lokasi'] ?? '-' }}
                        </div>
                    </div>
                    <div>
                        <span style="font-size: 12px; color: #6c757d; display: block; margin-bottom: 2px;">Deskripsi</span>
                        <span style="color: #212529; line-height: 1.4; display: block;">{{ $data['deskripsi'] ?? '-' }}</span>
                    </div>
                    <div>
                        <span style="font-size: 12px; color: #6c757d; display: block; margin-bottom: 2px;">Tanggal pengajuan</span>
                        <strong style="color: #212529; font-weight: 600;">{{ now()->translatedFormat('d F Y, H.i') }} WIB</strong>
                    </div>
                </div>

            </div>

            <!-- Kotak Informasi / Catatan Hijau Muda sesuai Figma -->
            <div style="background: #e8f5e9; color: #2e7d32; padding: 14px 16px; border-radius: 8px; font-size: 12px; line-height: 1.4; margin-bottom: 24px; border: 1px solid #c8e6c9;">
                Laporan akan dikirim ke petugas wilayah Sukamaju. Identitasmu hanya dapat dilihat oleh petugas berwenang. Pengiriman pada rancangan ini adalah simulasi.
            </div>

            <!-- Tombol Navigasi Bawah -->
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <a href="{{ route('warga.laporan.create', ['step' => 2]) }}" style="background: white; border: 1px solid #ced4da; color: #495057; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 13px;">Kembali</a>
                <button type="submit" style="background-color: #198754; color: white; padding: 10px 24px; border-radius: 8px; border: none; font-weight: 600; font-size: 14px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                    Kirim Laporan
                </button>
            </div>
        </form>
        @endif

    </div>
</div>
@endsection