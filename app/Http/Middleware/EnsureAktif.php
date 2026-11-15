<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAktif
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->status !== 'aktif') {
            $role = $request->user()->role;
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route($role.'.login')->withErrors(['email' => 'Akun belum aktif atau dinonaktifkan. Hubungi admin PANTAS.']);
        }

        return $next($request);
    }
}
