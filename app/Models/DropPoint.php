<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DropPoint extends Model
{
    use HasFactory;

    protected $table = 'drop_point';

    protected $guarded = [];

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class);
    }

    protected function casts(): array
    {
        return ['aktif' => 'boolean', 'lat' => 'float', 'lng' => 'float'];
    }
}
