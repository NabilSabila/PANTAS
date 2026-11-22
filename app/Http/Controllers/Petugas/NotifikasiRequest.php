<?php

namespace App\Http\Requests\Petugas;

use App\Http\Requests\PantasRequest;

class NotifikasiRequest extends PantasRequest
{
    public function rules(): array
    {
        return ['laporan' => ['sometimes', 'boolean'], 'jadwal' => ['sometimes', 'boolean'], 'sistem' => ['sometimes', 'boolean']];
    }
}
