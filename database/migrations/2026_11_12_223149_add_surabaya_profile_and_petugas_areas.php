<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $t) {
            $t->decimal('alamat_lat', 10, 7)->nullable();
            $t->decimal('alamat_lng', 10, 7)->nullable();
            $t->boolean('password_setup_required')->default(false);
        });
        Schema::create('petugas_wilayah', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $t->foreignId('wilayah_id')->constrained('wilayah');
            $t->timestamps();
            $t->unique(['user_id', 'wilayah_id']);
        });
        Schema::table('drop_point', function (Blueprint $t) {
            $t->foreignId('wilayah_id')->nullable()->constrained('wilayah');
        });
        $valid = DB::table('wilayah')->whereIn('nama', array_keys(config('wilayah.kecamatan')))->pluck('id');
        foreach (DB::table('users')->where('role', 'petugas')->whereIn('wilayah_id', $valid)->get() as $user) {
            DB::table('petugas_wilayah')->insertOrIgnore(['user_id' => $user->id, 'wilayah_id' => $user->wilayah_id, 'created_at' => now(), 'updated_at' => now()]);
        }
    }

    public function down(): void
    {
        Schema::table('drop_point', function (Blueprint $t) {
            $t->dropConstrainedForeignId('wilayah_id');
        });
        Schema::dropIfExists('petugas_wilayah');
        Schema::table('users', function (Blueprint $t) {
            $t->dropColumn(['alamat_lat', 'alamat_lng', 'password_setup_required']);
        });
    }
};
