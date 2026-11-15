<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanRiwayat extends Model
{
    use HasFactory;

    protected $table = 'laporan_riwayat';

    protected $guarded = [];

    protected function casts(): array
    {
        return [];
    }
}