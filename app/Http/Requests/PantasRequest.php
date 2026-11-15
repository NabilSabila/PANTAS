<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PantasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return ['required' => ':attribute wajib diisi.', 'email' => 'Format email tidak valid.', 'unique' => ':attribute sudah digunakan.', 'min.string' => ':attribute minimal :min karakter.', 'max.file' => 'Ukuran berkas maksimal 5 MB.', 'image' => 'Berkas harus berupa gambar.', 'in' => 'Pilihan :attribute tidak valid.', 'exists' => ':attribute tidak tersedia.', 'numeric' => ':attribute harus berupa angka.', 'between.numeric' => ':attribute di luar rentang yang diizinkan.', 'password.confirmed' => 'Konfirmasi password tidak cocok.', 'password_confirmation.same' => 'Konfirmasi password tidak cocok.'];
    }

    public function attributes(): array
    {
        return ['nama' => 'Nama', 'email' => 'Email', 'password' => 'Password', 'password_confirmation' => 'Konfirmasi password', 'lat' => 'Lintang', 'lng' => 'Bujur', 'foto' => 'Foto', 'wilayah_id' => 'Wilayah', 'petugas_id' => 'Petugas', 'lokasi_teks' => 'Lokasi', 'titik' => 'Titik pengangkutan'];
    }
}
