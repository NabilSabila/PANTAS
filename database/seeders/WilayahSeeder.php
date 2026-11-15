<?php

namespace Database\Seeders;

use App\Models\Wilayah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WilayahSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $master = config('wilayah.kecamatan');
            Wilayah::whereNotIn('nama', array_keys($master))->update(['aktif' => false]);
            foreach ($master as $nama => $coordinate) {
                Wilayah::updateOrCreate(['nama' => $nama], $coordinate + ['nama' => $nama, 'aktif' => true]);
            }
        });
    }
}