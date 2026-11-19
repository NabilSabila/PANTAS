<?php

namespace App\Http\Requests\Petugas;

use App\Http\Requests\PantasRequest;

class StatusRequest extends PantasRequest
{
    public function rules(): array
    {
        return ['status' => ['required', 'in:baru,diterima,diproses,menuju_lokasi,selesai'], 'catatan' => ['nullable', 'string', 'max:3000'], 'estimasi_tiba' => ['nullable', 'date_format:H:i'], 'petugas_id' => ['nullable', 'exists:users,id'], 'prioritas' => ['sometimes', 'in:normal,tinggi']];
    }
}
