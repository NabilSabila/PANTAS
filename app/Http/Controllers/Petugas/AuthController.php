<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\PortalAuthController;
use App\Http\Requests\Petugas\LoginRequest;
use App\Http\Requests\Petugas\RegisterRequest;
use Illuminate\Http\RedirectResponse;

class AuthController extends PortalAuthController
{
    protected string $role = 'petugas';

    public function login(LoginRequest $request): RedirectResponse
    {
        return $this->authenticate($request);
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        return $this->registerUser($request);
    }
}
