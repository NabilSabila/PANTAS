<?php

namespace App\Http\Requests\Warga;

use App\Http\Requests\PantasRequest;

class PasswordRequest extends PantasRequest
{
    public function rules(): array
    {
        return ['current_password' => ['required', 'current_password'], 'password' => ['required', 'min:8'], 'password_confirmation' => ['required', 'same:password']];
    }
}
