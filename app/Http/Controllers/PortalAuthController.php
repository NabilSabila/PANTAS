<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AktivitasLogger;
use App\Services\NotifikasiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

abstract class PortalAuthController extends Controller
{
    protected string $role;

    public function form(Request $request): View|RedirectResponse
    {
        if ($request->user()?->role === $this->role && $request->user()->status === 'aktif' && ! $request->user()->password_setup_required) {
            return redirect()->route($this->homeRoute());
        }

        return view($this->role.'.auth.'.($request->routeIs('*.daftar') ? 'register' : 'login'));
    }

    protected function authenticate(Request $request): RedirectResponse
    {
        $key = strtolower($request->string('email')).'|'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages(['email' => 'Terlalu banyak percobaan. Coba lagi dalam satu menit.']);
        }
        RateLimiter::hit($key, 60);
        $user = User::where('email', $request->email)->first();
        $error = null;
        if (! $user || ! Hash::check($request->password, $user->password)) {
            $error = 'Email atau password tidak cocok.';
        } elseif ($user->role !== $this->role) {
            $label = match ($this->role) {
                'warga' => 'Warga','petugas' => 'Petugas Kebersihan',default => 'Admin'
            };
            $error = 'Akun ini bukan akun '.$label.'. Gunakan portal yang sesuai.';
        } elseif ($user->status !== 'aktif' || $user->password_setup_required) {
            $error = 'Akun belum aktif atau dinonaktifkan. Hubungi admin PANTAS.';
        }
        if ($error) {
            throw ValidationException::withMessages(['email' => $error]);
        }
        RateLimiter::clear($key);
        $intended = $request->session()->pull('url.intended');
        if ($request->user() && ! $request->user()->is($user)) {
            $request->session()->invalidate();
        }
        Auth::login($user);
        $request->session()->regenerate();
        $user->update(['last_login_at' => now()]);
        $destination = route($this->homeRoute());
        if (is_string($intended) && str_starts_with($intended, url('/'.$this->role.'/'))) {
            return redirect()->to($intended);
        }

        return redirect()->to($destination);
    }

    private function homeRoute(): string
    {
        return $this->role.($this->role === 'admin' ? '.dashboard' : '.beranda');
    }

    protected function registerUser(Request $request): RedirectResponse
    {
        $user = DB::transaction(function () use ($request) {
            $user = User::create(['nama' => $request->nama ?? strstr($request->email, '@', true), 'email' => $request->email, 'password' => $request->password, 'role' => $this->role, 'status' => $this->role === 'warga' ? 'aktif' : 'nonaktif', 'is_super' => false]);
            if ($this->role !== 'warga') {
                foreach (User::where('role', 'admin')->where('status', 'aktif')->get() as $admin) {
                    app(NotifikasiService::class)->send($admin, ucfirst($this->role).' baru menunggu verifikasi', $user->nama.' menunggu aktivasi akun.', 'sistem', route('admin.pengguna.index'));
                }
                app(AktivitasLogger::class)->log('pengguna', ucfirst($this->role).' baru menunggu verifikasi');
            }

            return $user;
        });
        $request->session()->flash('pendaftaran', ['nama' => $user->nama, 'email' => $user->email]);

        return redirect()->route($this->role.'.daftar.berhasil');
    }

    public function success(): View
    {
        return view($this->role.'.auth.register-berhasil');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route($this->role.'.login');
    }
}
