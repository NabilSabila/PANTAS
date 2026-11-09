<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporans';

    protected $fillable = [
        'kode_laporan',
        'user_id',
        'foto',
        'kategori_sampah',
        'kondisi',
        'jumlah',
        'lokasi',
        'deskripsi',
        'status',
        'petugas_nama',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
