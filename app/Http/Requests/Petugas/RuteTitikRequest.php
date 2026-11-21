<?php

namespace App\Http\Requests\Petugas;

use App\Http\Requests\PantasRequest;

class RuteTitikRequest extends PantasRequest
{
    public function rules(): array
    {
        return ['catatan' => 'nullable|string|max:3000', 'selesai' => 'sometimes|boolean'];
    }
}
