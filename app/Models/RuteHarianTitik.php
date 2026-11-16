<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuteHarianTitik extends Model
{
    use HasFactory;

    protected $table = 'rute_harian_titik';

    protected $guarded = [];

    protected function casts(): array
    {
        return ['lat' => 'float', 'lng' => 'float', 'selesai_at' => 'datetime'];
    }
}
