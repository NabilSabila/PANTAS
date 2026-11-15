<?php

namespace App\Http\Requests;

class ActivationRequest extends PantasRequest
{
    public function rules(): array
    {
        return ['email' => 'required|email', 'token' => 'required|string', 'password' => 'required|string|min:8', 'password_confirmation' => 'required|same:password'];
    }
}
