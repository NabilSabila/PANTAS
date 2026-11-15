<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_code_sequences', function (Blueprint $table) {
            $table->string('role')->primary();
            $table->unsignedBigInteger('next')->default(1);
        });
        foreach (['petugas', 'admin'] as $role) {
            $max = DB::table('users')->where('role', $role)->get()->map(fn ($u) => (int) substr($u->kode, 4))->max() ?? 0;
            DB::table('user_code_sequences')->insert(['role' => $role, 'next' => $max + 1]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('user_code_sequences');
    }
};
