<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\PortalAuthController;
use App\Http\Requests\Warga\LoginRequest;
use App\Http\Requests\Warga\RegisterRequest;
use Illuminate\Http\RedirectResponse;

class AuthController extends PortalAuthController
{
    protected string $role = 'warga';

    public function login(LoginRequest $request): RedirectResponse
    {
        return $this->authenticate($request);
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        return $this->registerUser($request);
    }
}
