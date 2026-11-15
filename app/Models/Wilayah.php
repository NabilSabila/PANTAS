<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    use HasFactory;

    protected $table = 'wilayah';

    protected $guarded = [];

    protected function casts(): array
    {
        return ['aktif' => 'boolean', 'lat' => 'float', 'lng' => 'float'];
    }
}
