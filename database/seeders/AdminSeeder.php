<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        if (! env('ADMIN_EMAIL') || ! env('ADMIN_PASSWORD')) {
            throw new \RuntimeException('Isi ADMIN_EMAIL dan ADMIN_PASSWORD pada .env sebelum menjalankan seeder.');
        } User::firstOrCreate(['email' => env('ADMIN_EMAIL')], ['nama' => env('ADMIN_NAME', 'Admin PANTAS'), 'password' => env('ADMIN_PASSWORD'), 'role' => 'admin', 'status' => 'aktif', 'is_super' => true]);
    }
}
