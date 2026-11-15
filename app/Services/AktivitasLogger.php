<?php

namespace App\Services;

use App\Models\AktivitasLog;

class AktivitasLogger
{
    public function log(string $tipe, string $judul, ?string $keterangan = null): void
    {
        AktivitasLog::create(['tipe' => $tipe, 'judul' => $judul, 'keterangan' => $keterangan, 'user_id' => auth()->id()]);
    }
}