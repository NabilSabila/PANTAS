<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Password;

class ActivationService
{
    public function send(User $user): bool
    {
        if (! $user->password_setup_required || in_array(config('mail.default'), ['log', 'array'], true)) {
            return false;
        }try {
            return Password::broker()->sendResetLink(['email' => $user->email]) === Password::RESET_LINK_SENT;
        } catch (\Throwable $exception) {
            report($exception);

            return false;
        }
    }
}
