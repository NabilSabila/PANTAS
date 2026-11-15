<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivationRequest;
use App\Models\User;
use App\Services\ActivationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ActivationController extends Controller
{
    public function form(Request $request, string $token): View
    {
        return view('activation.form', ['token' => $token, 'email' => $request->query('email')]);
    }

    public function store(ActivationRequest $request): RedirectResponse
    {
        $user = User::where('email', $request->email)->first();
        if (! $user || ! $user->password_setup_required) {
            return back()->withErrors(['email' => 'Tautan aktivasi tidak valid atau sudah digunakan.'])->withInput($request->only('email'));
        }$status = Password::broker()->reset($request->only('email', 'password', 'password_confirmation', 'token'), function (User $user, string $password) {
            $user->forceFill(['password' => $password, 'password_setup_required' => false, 'remember_token' => Str::random(60)])->save();
        });
        if ($status !== Password::PASSWORD_RESET) {
            return back()->withErrors(['email' => 'Tautan aktivasi tidak valid atau kedaluwarsa. Minta admin mengirim ulang.'])->withInput($request->only('email'));
        }

        return redirect()->route($user->role.'.login')->with('sukses', 'Kata sandi tersimpan. Silakan masuk setelah akun diaktifkan.');
    }

    public function resend(Request $request, int $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        abort_unless($user->password_setup_required, 422);
        $sent = app(ActivationService::class)->send($user);

        return back()->with($sent ? 'sukses' : 'peringatan', $sent ? 'Email aktivasi dikirim.' : 'Email aktivasi belum terkirim. Periksa konfigurasi layanan email.');
    }
}
