<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\PantasRequest;
use App\Models\Jadwal;
use App\Models\User;
use App\Services\SurabayaBoundary;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

abstract class ResourceRequest extends PantasRequest
{
    public function rules(): array
    {
        $type = $this->route('resource_type') ?? explode('.', $this->route()->getName())[1];
        $id = $this->route('id');

        return match ($type) {
            'pengguna' => ['nama' => 'required|string|max:120', 'email' => ['required', 'email', Rule::unique('users')->ignore($id)], 'role' => 'required|in:warga,petugas,admin', 'status' => 'required|in:aktif,nonaktif', 'wilayah_id' => ['nullable', Rule::exists('wilayah', 'id')->where('aktif', true)], 'password' => 'prohibited', 'area_ids' => 'sometimes|array|max:7', 'area_ids.*' => ['integer', 'distinct', Rule::exists('wilayah', 'id')->where('aktif', true)], 'telepon' => 'nullable|string|max:30'],
            'jadwal' => ['wilayah_id' => ['required', Rule::exists('wilayah', 'id')->where('aktif', true)], 'hari' => 'required|array|min:1', 'hari.*' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu', 'jam_mulai' => 'required|date_format:H:i', 'jam_selesai' => 'required|date_format:H:i|after:jam_mulai', 'jenis_sampah' => 'required|in:Umum,Organik,Daur Ulang,Umum & Organik,Umum & Daur Ulang,Organik & Daur Ulang', 'tanggal' => 'nullable|date', 'status' => 'required|in:aktif,nonaktif'],
            'rute' => ['wilayah_id' => ['required', Rule::exists('wilayah', 'id')->where('aktif', true)], 'kode' => ['required', 'string', 'max:40', Rule::unique('rute')->ignore($id)], 'petugas_id' => 'required|exists:users,id', 'jadwal_id' => 'required|exists:jadwal,id', 'status' => 'required|in:aktif,nonaktif', 'titik' => 'required|array|min:2|max:200', 'titik.*.urutan' => 'sometimes|integer|min:1', 'titik.*.nama' => 'required|string|max:180', 'titik.*.keterangan' => 'nullable|string|max:500', 'titik.*.jam_rencana' => 'required|date_format:H:i', 'titik.*.lat' => 'required|numeric|between:-90,90', 'titik.*.lng' => 'required|numeric|between:-180,180'],
            'edukasi' => ['judul' => 'required|string|max:200', 'audiens' => 'required|in:warga,petugas,semua', 'kategori' => 'required|in:Pilah Sampah,Organik,Plastik,Elektronik,B3,Daur Ulang,Minyak Jelantah,Keselamatan,Rute & Operasional', 'status' => 'required|in:draf,terbit', 'ringkasan' => 'required|string|max:10000'],
            'drop-point' => ['wilayah_id' => ['required', Rule::exists('wilayah', 'id')->where('aktif', true)], 'nama' => 'required|string|max:150', 'alamat' => 'required|string|max:1000', 'lat' => 'required|numeric|between:-90,90', 'lng' => 'required|numeric|between:-180,180', 'jam_buka' => 'required|date_format:H:i', 'jam_tutup' => 'required|date_format:H:i|after:jam_buka', 'hari_buka' => 'required|string|max:100', 'jenis_diterima' => 'required|string|max:300', 'aktif' => 'required|boolean'],
            default => []
        };
    }

    protected function prepareForValidation(): void
    {
        $hari = $this->input('hari');
        if (is_string($hari)) {
            $hari = explode(',', $hari);
        }
        if (is_array($hari)) {
            $this->merge(['hari' => array_map(
                fn ($day) => is_string($day) ? ucfirst(strtolower(trim($day))) : $day,
                $hari
            )]);
        }
    }

    public function after(): array
    {
        return [function (Validator $v) {
            if ($v->errors()->isNotEmpty()) {
                return;
            } foreach ($this->input('titik', []) as $index => $point) {
                if (! app(SurabayaBoundary::class)->contains((float) $point['lat'], (float) $point['lng'])) {
                    $v->errors()->add('titik.'.$index.'.lat', 'Titik harus berada di Kota Surabaya.');
                } if (isset($point['urutan']) && (int) $point['urutan'] !== $index + 1) {
                    $v->errors()->add('titik.'.$index.'.urutan', 'Urutan titik tidak sesuai daftar.');
                }
            } if ($this->filled('lat') && ! app(SurabayaBoundary::class)->contains((float) $this->lat, (float) $this->lng)) {
                $v->errors()->add('lat', 'Titik harus berada di Kota Surabaya.');
            }
            if ($this->petugas_id) {
                $petugas = User::find($this->petugas_id);
                if (! $petugas || $petugas->role !== 'petugas' || $petugas->status !== 'aktif' || ! $petugas->serves((int) $this->wilayah_id)) {
                    $v->errors()->add('petugas_id', 'Petugas harus aktif dan berada di wilayah yang sama.');
                }
            } if ($this->jadwal_id) {
                $jadwal = Jadwal::find($this->jadwal_id);
                if (! $jadwal || $jadwal->status !== 'aktif' || $jadwal->wilayah_id !== (int) $this->wilayah_id) {
                    $v->errors()->add('jadwal_id', 'Jadwal harus aktif dan berada di wilayah yang sama.');
                }
            } if ($this->role === 'petugas' && $this->status === 'aktif' && count($this->input('area_ids', [])) < 1) {
                $v->errors()->add('area_ids', 'Petugas aktif wajib memiliki 1 sampai 7 area tugas.');
            }
        }];
    }
}
