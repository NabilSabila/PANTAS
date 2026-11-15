<?php

namespace App\Http\Requests\Warga;

use App\Http\Requests\PantasRequest;

class FotoRequest extends PantasRequest
{
    public function rules(): array
    {
        return ['foto' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120']];
    }
}