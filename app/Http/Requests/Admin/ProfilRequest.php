<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\PantasRequest;

class ProfilRequest extends PantasRequest
{
    public function rules(): array
    {
        return ['nama' => ['required', 'string', 'max:120'], 'telepon' => ['nullable', 'string', 'max:30'], 'alamat' => ['nullable', 'string', 'max:1000'], 'wilayah_id' => ['nullable', 'exists:wilayah,id'], 'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120']];
    }
}
