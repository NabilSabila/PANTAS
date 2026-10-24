<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // FITUR WARGA (LOGIN & SIGN UP)

    // Menampilkan halaman login warga
    public function showLoginWarga()
    {
        return view('auth.login-warga');
    }

    // Memproses login warga
    public function loginWarga(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Redirect ke halaman dashboard warga setelah berhasil masuk
            return redirect()->intended('/warga/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Menampilkan halaman pendaftaran warga
    public function showRegisterWarga()
    {
        return view('auth.register-warga');
    }

    // Memproses pendaftaran warga baru ke database
    public function registerWarga(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Simpan data ke database db_pantas (tabel users)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Login-kan user yang baru mendaftar secara otomatis
        Auth::login($user);

        // Arahkan ke dashboard atau halaman sukses
        return redirect()->intended('/warga/dashboard')->with('success', 'Akun berhasil dibuat!');
    }

    // FITUR PETUGAS KEBERSIHAN (LOGIN & SIGN UP)

    // Menampilkan halaman login petugas kebersihan
    public function showLoginPetugas()
    {
        return view('auth.login-petugas');
    }

    // Memproses login petugas kebersihan
    public function loginPetugas(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Redirect ke dashboard petugas
            return redirect()->intended('/petugas/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password petugas yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Menampilkan halaman pendaftaran petugas kebersihan
    public function showRegisterPetugas()
    {
        return view('auth.register-petugas');
    }
    // Memproses pendaftaran petugas kebersihan baru ke database
    public function registerPetugas(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Simpan data petugas ke database db_pantas
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // 'role' => 'petugas', // Aktifkan jika tabel users memiliki kolom role khusus
        ]);

        // Login-kan otomatis setelah mendaftar
        Auth::login($user);

        // Arahkan ke dashboard petugas
        return redirect()->intended('/petugas/dashboard')->with('success', 'Akun petugas berhasil dibuat!');
    }

    // FITUR ADMIN (LOGIN & SIGN UP)
    // Menampilkan halaman login admin
    public function showLoginAdmin()
    {
        return view('auth.login-admin');
    }

    // Memproses login admin
    public function loginAdmin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Redirect ke dashboard admin
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi admin yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Menampilkan halaman pendaftaran admin
    public function showRegisterAdmin()
    {
        return view('auth.register-admin');
    }

    // Memproses pendaftaran admin baru ke database
    public function registerAdmin(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Simpan data admin ke database db_pantas
        $user = User::create([
            'name' => 'Admin PANTAS', // Nama default atau bisa disesuaikan
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // 'role' => 'admin', // Aktifkan jika tabel users memiliki kolom role khusus
        ]);

        // Login-kan otomatis setelah mendaftar
        Auth::login($user);

        // Arahkan ke dashboard admin
        return redirect()->intended('/admin/dashboard')->with('success', 'Akun admin berhasil dibuat!');
    }
}
