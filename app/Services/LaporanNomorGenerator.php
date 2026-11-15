<?php

namespace App\Services;

use App\Models\Laporan;

class LaporanNomorGenerator
{
    public function generate(Laporan $laporan): string
    {
        return 'PTS-'.$laporan->created_at->format('ymd').'-'.str_pad((string) $laporan->id, 4, '0', STR_PAD_LEFT);
    }
}