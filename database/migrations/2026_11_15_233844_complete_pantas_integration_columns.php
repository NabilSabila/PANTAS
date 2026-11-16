<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::table('users', function (Blueprint $table): void {
            if (! Schema::hasColumn('users', 'alamat_lat')) {
                $table->decimal('alamat_lat', 10, 7)->nullable();
            }
            if (! Schema::hasColumn('users', 'alamat_lng')) {
                $table->decimal('alamat_lng', 10, 7)->nullable();
            }
            if (! Schema::hasColumn('users', 'password_setup_required')) {
                $table->boolean('password_setup_required')->default(false);
            }
        });
        if (! Schema::hasTable('petugas_wilayah')) {
            Schema::create('petugas_wilayah', function (Blueprint $table): void {
                $table->id();
                // belongsToMany pada User memakai user_id, bukan petugas_id.
                $table->foreignId('user_id')->constrained('users');
                $table->foreignId('wilayah_id')->constrained('wilayah');
                $table->timestamps();
                $table->unique(['user_id', 'wilayah_id']);
            });
        }
        if (! Schema::hasColumn('drop_point', 'wilayah_id')) {
            Schema::table('drop_point', function (Blueprint $table): void {
                $table->foreignId('wilayah_id')->nullable()->constrained('wilayah');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Migration integrasi sengaja tidak menghapus struktur/data ketika rollback.
    }
};
