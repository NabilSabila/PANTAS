<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    protected $guarded = [];

    protected function casts(): array
    {
        return ['lat' => 'float', 'lng' => 'float', 'selesai_at' => 'datetime'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id')->withTrashed();
    }

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class);
    }

    public function riwayat(): HasMany
    {
        return $this->hasMany(LaporanRiwayat::class)->orderBy('id');
    }

    public function scopeVisibleTo(Builder $query, User $user): void
    {
        if ($user->role === 'warga') {
            $query->where('user_id', $user->id);
        } elseif ($user->role === 'petugas') {
            $query->whereIn('wilayah_id', $user->areaTugas()->where('aktif', true)->select('wilayah.id'));
        }
    }
}