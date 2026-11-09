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
        Schema::table('laporans', function (Blueprint $table) {
            // Tambahkan kolom-kolom yang diperlukan jika belum ada
            if (!Schema::hasColumn('laporans', 'kode_laporan')) {
                $table->string('kode_laporan')->nullable()->after('id');
            }
            if (!Schema::hasColumn('laporans', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            }
            if (!Schema::hasColumn('laporans', 'foto')) {
                $table->string('foto')->nullable();
            }
            if (!Schema::hasColumn('laporans', 'kategori_sampah')) {
                $table->string('kategori_sampah')->nullable();
            }
            if (!Schema::hasColumn('laporans', 'kondisi')) {
                $table->string('kondisi')->nullable();
            }
            if (!Schema::hasColumn('laporans', 'jumlah')) {
                $table->string('jumlah')->nullable();
            }
            if (!Schema::hasColumn('laporans', 'lokasi')) {
                $table->string('lokasi')->nullable();
            }
            if (!Schema::hasColumn('laporans', 'deskripsi')) {
                $table->text('deskripsi')->nullable();
            }
            if (!Schema::hasColumn('laporans', 'status')) {
                $table->string('status')->default('Laporan Dikirim');
            }
            if (!Schema::hasColumn('laporans', 'petugas_nama')) {
                $table->string('petugas_nama')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn([
                'kode_laporan', 'user_id', 'foto', 'kategori_sampah', 
                'kondisi', 'jumlah', 'lokasi', 'deskripsi', 'status', 'petugas_nama'
            ]);
        });
    }
};
