<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = ['name', 'nama', 'email', 'password', 'telepon', 'alamat', 'role', 'status', 'wilayah_id', 'is_super', 'avatar_path', 'tampilkan_nama', 'last_login_at', 'alamat_lat', 'alamat_lng', 'password_setup_required'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return ['alamat_lat' => 'float', 'alamat_lng' => 'float', 'password_setup_required' => 'boolean', 'password' => 'hashed', 'is_super' => 'boolean', 'tampilkan_nama' => 'boolean', 'last_login_at' => 'datetime', 'email_verified_at' => 'datetime'];
    }

    protected static function booted(): void
    {
        static::creating(function (User $user) {
            $user->nama ??= $user->name;
            $user->name ??= $user->nama;
            if (in_array($user->role, ['petugas', 'admin'], true)) {
                $user->kode = DB::transaction(function () use ($user) {
                    $counter = DB::table('user_code_sequences')->where('role', $user->role)->lockForUpdate()->first();
                    DB::table('user_code_sequences')->where('role', $user->role)->increment('next');

                    return ($user->role === 'petugas' ? 'PTG-' : 'ADM-').str_pad((string) $counter->next, $user->role === 'petugas' ? 4 : 3, '0', STR_PAD_LEFT);
                });
            }
        });
        static::created(function (User $user) {
            if ($user->role === 'warga') {
                $user->forceFill(['kode' => 'USR-'.(10000 + $user->id)])->saveQuietly();
            }
        });
    }

    public function areaTugas(): BelongsToMany
    {
        return $this->belongsToMany(Wilayah::class, 'petugas_wilayah')->withTimestamps();
    }

    public function serves(?int $wilayahId): bool
    {
        return $wilayahId !== null && $this->areaTugas()->where('wilayah.id', $wilayahId)->where('aktif', true)->exists();
    }

    public function getLokasiProfilAttribute(): string
    {
        $wilayah = $this->wilayah;

        return $wilayah && $wilayah->aktif ? $wilayah->nama.', Surabaya, Jawa Timur' : 'Wilayah belum diatur';
    }

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class);
    }

    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class);
    }

    public function notifikasiAkun(): HasMany
    {
        return $this->hasMany(Notifikasi::class);
    }
}
