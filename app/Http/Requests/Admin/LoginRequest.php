<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\PantasRequest;

class LoginRequest extends PantasRequest
{
    public function rules(): array
    {
        return ['email' => ['required', 'email'], 'password' => ['required', 'string']];
    }
}
