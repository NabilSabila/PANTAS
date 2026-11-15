<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';

    protected $guarded = [];

    protected function casts(): array
    {
        return ['dibaca_at' => 'datetime'];
    }
}
