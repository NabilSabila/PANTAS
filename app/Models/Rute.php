<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rute extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'rute';

    protected $guarded = [];

    protected function casts(): array
    {
        return [];
    }

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class);
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id')->withTrashed();
    }

    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function titik(): HasMany
    {
        return $this->hasMany(RuteTitik::class)->orderBy('urutan');
    }

    public function harian(): HasMany
    {
        return $this->hasMany(RuteHarian::class);
    }
}
