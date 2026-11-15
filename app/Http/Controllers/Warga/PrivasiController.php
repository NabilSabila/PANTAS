<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Http\Requests\Warga\PasswordRequest;
use App\Http\Requests\Warga\PrivasiRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PrivasiController extends Controller
{
    public function index(): View
    {
        return view('warga.pengaturan.privasi');
    }

    public function password(PasswordRequest $request): RedirectResponse
    {
        $request->user()->update(['password' => $request->password]);
        $request->session()->regenerate();

        return back()->with('sukses', 'Kata sandi berhasil diperbarui.');
    }

    public function update(PrivasiRequest $request): RedirectResponse
    {
        $request->user()->update(['tampilkan_nama' => $request->boolean('tampilkan_nama')]);

        return back()->with('sukses', 'Preferensi privasi disimpan.');
    }
}
