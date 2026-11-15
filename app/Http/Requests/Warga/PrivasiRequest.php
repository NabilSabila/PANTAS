<?php

namespace App\Http\Requests\Warga;

use App\Http\Requests\PantasRequest;

class PrivasiRequest extends PantasRequest
{
    public function rules(): array
    {
        return ['tampilkan_nama' => ['sometimes', 'boolean']];
    }
}
