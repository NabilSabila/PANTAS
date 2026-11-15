<?php

namespace App\Services;

use App\Models\Notifikasi;
use App\Models\User;

class NotifikasiService
{
    public function send(User $user, string $judul, string $isi, string $tipe = 'sistem', ?string $tautan = null): void
    {
        Notifikasi::create(['user_id' => $user->id, 'judul' => $judul, 'isi' => $isi, 'tipe' => $tipe, 'tautan' => $tautan]);
    }
}
