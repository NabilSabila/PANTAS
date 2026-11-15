<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\PortalAuthController;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Admin\RegisterRequest;
use Illuminate\Http\RedirectResponse;

class AuthController extends PortalAuthController
{
    protected string $role = 'admin';

    public function login(LoginRequest $request): RedirectResponse
    {
        return $this->authenticate($request);
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        return $this->registerUser($request);
    }
}
