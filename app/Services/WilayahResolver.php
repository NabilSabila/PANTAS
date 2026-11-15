<?php

namespace App\Services;

use App\Models\Wilayah;
use Illuminate\Validation\ValidationException;

class WilayahResolver
{
    public function resolve(float $lat, float $lng, ?int $selected): int
    {
        if (! app(SurabayaBoundary::class)->contains($lat, $lng)) {
            throw ValidationException::withMessages(['lat' => 'Titik harus berada di Kota Surabaya.']);
        }$wilayah = Wilayah::where('aktif', true)->find($selected);
        if (! $wilayah) {
            throw ValidationException::withMessages(['wilayah_id' => 'Pilih kecamatan Surabaya dan pastikan sesuai titik laporan.']);
        }

        return $wilayah->id;
    }
}