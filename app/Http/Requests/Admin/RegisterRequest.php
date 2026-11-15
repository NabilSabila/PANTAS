<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\PantasRequest;

class RegisterRequest extends PantasRequest
{
    public function rules(): array
    {
        return ['email' => ['required', 'email', 'max:255', 'unique:users,email'], 'password' => ['required', 'string', 'min:8'], 'password_confirmation' => ['required', 'same:password']];
    }
}
