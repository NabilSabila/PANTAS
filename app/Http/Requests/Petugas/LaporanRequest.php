<?php

namespace App\Http\Requests\Petugas;

use App\Http\Requests\PantasRequest;

class LaporanRequest extends PantasRequest
{
    public function rules(): array
    {
        return ['judul' => ['required', 'string', 'max:150'], 'kategori' => ['required', 'in:rumah_tangga,elektronik,minyak_jelantah,b3,daur_ulang'], 'kondisi' => ['required', 'in:Terkumpul rapi,Menumpuk,Menumpuk dan berbau'], 'jumlah' => ['required', 'in:1-2 kantong,3-5 kantong,6-10 kantong,Lebih dari 10 kantong'], 'lokasi_teks' => ['required', 'string', 'max:1000'], 'lat' => ['required', 'numeric', 'between:-90,90'], 'lng' => ['required', 'numeric', 'between:-180,180'], 'deskripsi' => ['required', 'string', 'max:5000']];
    }
}
