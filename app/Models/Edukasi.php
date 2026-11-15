<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Edukasi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'edukasi';

    protected $guarded = [];

    public function scopePublishedFor(Builder $query, string $role): void
    {
        $query->where('status', 'terbit')->whereIn('audiens', [$role, 'semua']);
    }

    protected function casts(): array
    {
        return ['published_at' => 'datetime'];
    }
}
