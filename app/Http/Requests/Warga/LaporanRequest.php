<?php

namespace App\Http\Requests\Warga;

use App\Http\Requests\PantasRequest;
use App\Rules\WithinSurabaya;
use Illuminate\Validation\Rule;

class LaporanRequest extends PantasRequest
{
    public function rules(): array
    {
        return ['judul' => ['required', 'string', 'max:150'], 'kategori' => ['required', 'in:rumah_tangga,elektronik,minyak_jelantah,b3,daur_ulang'], 'kondisi' => ['required', Rule::in(config('laporan.kondisi'))], 'jumlah' => ['required', Rule::in(config('laporan.jumlah'))], 'lokasi_teks' => ['required', 'string', 'max:1000'], 'wilayah_id' => ['required', Rule::exists('wilayah', 'id')->where('aktif', true)], 'lat' => ['required', 'numeric', 'between:-90,90', new WithinSurabaya($this->input('lng'))], 'lng' => ['required', 'numeric', 'between:-180,180'], 'deskripsi' => ['required', 'string', 'min:10', 'max:5000']];
    }
}