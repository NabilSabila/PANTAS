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
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_laporan')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('foto');
            $table->string('kategori_sampah');
            $table->string('kondisi');
            $table->string('jumlah');
            $table->string('lokasi');
            $table->text('deskripsi');
            $table->enum('status', [
                'Laporan Dikirim', 
                'Laporan Diterima', 
                'Sedang Diproses', 
                'Petugas Menuju Lokasi', 
                'Selesai'
            ])->default('Laporan Dikirim');
            $table->string('petugas_nama')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
