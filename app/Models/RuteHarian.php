<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RuteHarian extends Model
{
    use HasFactory;

    protected $table = 'rute_harian';

    protected $guarded = [];

    protected function casts(): array
    {
        return ['tanggal' => 'date', 'mulai_at' => 'datetime', 'selesai_at' => 'datetime'];
    }

    public function titik(): HasMany
    {
        return $this->hasMany(RuteHarianTitik::class)->orderBy('urutan');
    }

    public function rute(): BelongsTo
    {
        return $this->belongsTo(Rute::class)->withTrashed();
    }
}
