<?php

namespace App\Policies;

use App\Models\Laporan;
use App\Models\User;

class LaporanPolicy
{
    public function view(User $user, Laporan $laporan): bool
    {
        return $user->role === 'admin' || ($user->role === 'warga' && $laporan->user_id === $user->id) || ($user->role === 'petugas' && $user->serves($laporan->wilayah_id));
    }

    public function update(User $user, Laporan $laporan): bool
    {
        return $user->role !== 'warga' && $this->view($user, $laporan);
    }
}
