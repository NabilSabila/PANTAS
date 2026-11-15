<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wilayah', function (Blueprint $t) {
            $t->id();
            $t->string('nama')->unique();
            $t->decimal('lat', 10, 7);
            $t->decimal('lng', 10, 7);
            $t->boolean('aktif')->default(true);
            $t->timestamps();
        });
        Schema::table('users', function (Blueprint $t) {
            $t->string('kode')->nullable()->unique();
            $t->string('nama')->nullable();
            $t->string('telepon')->nullable();
            $t->text('alamat')->nullable();
            $t->string('role')->default('warga');
            $t->string('status')->default('aktif');
            $t->foreignId('wilayah_id')->nullable()->constrained('wilayah');
            $t->boolean('is_super')->default(false);
            $t->string('avatar_path')->nullable();
            $t->boolean('tampilkan_nama')->default(false);
            $t->timestamp('last_login_at')->nullable();
            $t->softDeletes();
            $t->index(['role', 'status']);
        });
        Schema::create('laporan', function (Blueprint $t) {
            $t->id();
            $t->string('nomor')->nullable()->unique();
            $t->foreignId('user_id')->constrained('users');
            $t->foreignId('wilayah_id')->nullable()->constrained('wilayah');
            $t->foreignId('petugas_id')->nullable()->constrained('users');
            $t->string('judul');
            $t->string('kategori');
            $t->string('kondisi');
            $t->string('jumlah');
            $t->text('lokasi_teks');
            $t->decimal('lat', 10, 7);
            $t->decimal('lng', 10, 7);
            $t->text('deskripsi');
            $t->string('foto_path');
            $t->string('prioritas')->default('normal');
            $t->string('status')->default('baru');
            $t->time('estimasi_tiba')->nullable();
            $t->text('catatan_petugas')->nullable();
            $t->timestamp('selesai_at')->nullable();
            $t->timestamps();
            $t->index(['status', 'wilayah_id', 'petugas_id', 'created_at']);
        });
        Schema::create('laporan_riwayat', function (Blueprint $t) {
            $t->id();
            $t->foreignId('laporan_id')->constrained('laporan')->cascadeOnDelete();
            $t->string('status');
            $t->text('catatan')->nullable();
            $t->foreignId('oleh_user_id')->nullable()->constrained('users');
            $t->timestamps();
        });
        Schema::create('jadwal', function (Blueprint $t) {
            $t->id();
            $t->foreignId('wilayah_id')->constrained('wilayah');
            $t->json('hari');
            $t->time('jam_mulai');
            $t->time('jam_selesai');
            $t->string('jenis_sampah');
            $t->date('tanggal')->nullable();
            $t->string('status')->default('aktif');
            $t->timestamps();
            $t->softDeletes();
        });
        Schema::create('rute', function (Blueprint $t) {
            $t->id();
            $t->string('kode')->unique();
            $t->foreignId('wilayah_id')->constrained('wilayah');
            $t->foreignId('petugas_id')->nullable()->constrained('users');
            $t->foreignId('jadwal_id')->nullable()->constrained('jadwal');
            $t->string('status')->default('aktif');
            $t->timestamps();
            $t->softDeletes();
        });
        Schema::create('rute_titik', function (Blueprint $t) {
            $t->id();
            $t->foreignId('rute_id')->constrained('rute')->cascadeOnDelete();
            $t->unsignedInteger('urutan');
            $t->string('nama');
            $t->text('keterangan')->nullable();
            $t->time('jam_rencana');
            $t->decimal('lat', 10, 7);
            $t->decimal('lng', 10, 7);
            $t->timestamps();
            $t->unique(['rute_id', 'urutan']);
        });
        Schema::create('rute_harian', function (Blueprint $t) {
            $t->id();
            $t->foreignId('rute_id')->constrained('rute');
            $t->foreignId('petugas_id')->constrained('users');
            $t->date('tanggal');
            $t->timestamp('mulai_at');
            $t->timestamp('selesai_at')->nullable();
            $t->string('status')->default('berjalan');
            $t->timestamps();
            $t->unique(['rute_id', 'tanggal']);
        });
        Schema::create('rute_harian_titik', function (Blueprint $t) {
            $t->id();
            $t->foreignId('rute_harian_id')->constrained('rute_harian')->cascadeOnDelete();
            $t->foreignId('rute_titik_id')->nullable()->constrained('rute_titik')->nullOnDelete();
            $t->unsignedInteger('urutan');
            $t->string('nama');
            $t->text('keterangan')->nullable();
            $t->time('jam_rencana');
            $t->decimal('lat', 10, 7);
            $t->decimal('lng', 10, 7);
            $t->string('status')->default('menunggu');
            $t->text('catatan')->nullable();
            $t->timestamp('selesai_at')->nullable();
            $t->timestamps();
        });
        Schema::create('edukasi', function (Blueprint $t) {
            $t->id();
            $t->string('judul');
            $t->string('audiens');
            $t->string('kategori');
            $t->string('status')->default('draf');
            $t->text('ringkasan');
            $t->timestamp('published_at')->nullable();
            $t->timestamps();
            $t->softDeletes();
        });
        Schema::create('drop_point', function (Blueprint $t) {
            $t->id();
            $t->string('nama');
            $t->text('alamat');
            $t->decimal('lat', 10, 7);
            $t->decimal('lng', 10, 7);
            $t->time('jam_buka');
            $t->time('jam_tutup');
            $t->string('hari_buka');
            $t->string('jenis_diterima');
            $t->boolean('aktif')->default(true);
            $t->timestamps();
        });
        Schema::create('notifikasi', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained('users');
            $t->string('judul');
            $t->text('isi');
            $t->string('tipe');
            $t->string('tautan')->nullable();
            $t->timestamp('dibaca_at')->nullable();
            $t->timestamps();
        });
        Schema::create('aktivitas_log', function (Blueprint $t) {
            $t->id();
            $t->string('tipe');
            $t->string('judul');
            $t->text('keterangan')->nullable();
            $t->foreignId('user_id')->nullable()->constrained('users');
            $t->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['aktivitas_log', 'notifikasi', 'drop_point', 'edukasi', 'rute_harian_titik', 'rute_harian', 'rute_titik', 'rute', 'jadwal', 'laporan_riwayat', 'laporan'] as $table) {
            Schema::dropIfExists($table);
        }
        Schema::table('users', function (Blueprint $t) {
            $t->dropForeign(['wilayah_id']);
            $t->dropIndex(['role', 'status']);
            $t->dropColumn(['kode', 'nama', 'telepon', 'alamat', 'role', 'status', 'wilayah_id', 'is_super', 'avatar_path', 'tampilkan_nama', 'last_login_at', 'deleted_at']);
        });
        Schema::dropIfExists('wilayah');
    }
};
