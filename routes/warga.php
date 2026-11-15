<?php

use App\Http\Controllers\Warga\AuthController;
use App\Http\Controllers\Warga\BantuanController;
use App\Http\Controllers\Warga\BerandaController;
use App\Http\Controllers\Warga\DropPointController;
use App\Http\Controllers\Warga\EdukasiController;
use App\Http\Controllers\Warga\JadwalController;
use App\Http\Controllers\Warga\LaporanController;
use App\Http\Controllers\Warga\LaporanWizardController;
use App\Http\Controllers\Warga\NotifikasiController;
use App\Http\Controllers\Warga\PengaturanController;
use App\Http\Controllers\Warga\PrivasiController;
use App\Http\Controllers\Warga\ProfilController;
use Illuminate\Support\Facades\Route;

Route::prefix('warga')->name('warga.')->group(function () {
    Route::get('login', [AuthController::class, 'form'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.store');
    Route::get('daftar', [AuthController::class, 'form'])->name('daftar');
    Route::post('daftar', [AuthController::class, 'register'])->name('daftar.store')->middleware('throttle:10,1');
    Route::get('daftar/berhasil', [AuthController::class, 'success'])->name('daftar.berhasil');
    Route::middleware(['auth', 'role:warga', 'aktif'])->group(function () {
        Route::post('keluar', [AuthController::class, 'logout'])->name('keluar');
        Route::get('beranda', [BerandaController::class, 'index'])->name('beranda');
        Route::get('laporan/buat', [LaporanWizardController::class, 'create'])->name('laporan.create');
        Route::post('laporan/foto', [LaporanWizardController::class, 'photo'])->name('laporan.foto');
        Route::get('laporan/buat/detail', [LaporanWizardController::class, 'detail'])->name('laporan.detail');
        Route::post('laporan/detail', [LaporanWizardController::class, 'saveDetail'])->name('laporan.detail.store');
        Route::get('laporan/buat/konfirmasi', [LaporanWizardController::class, 'confirm'])->name('laporan.konfirmasi');
        Route::post('laporan', [LaporanWizardController::class, 'store'])->name('laporan.store')->middleware('throttle:10,60');
        Route::get('laporan/terkirim/{laporan}', [LaporanWizardController::class, 'sent'])->name('laporan.terkirim');
        Route::get('jadwal', [JadwalController::class, 'index'])->name('jadwal');
        Route::get('drop-point', [DropPointController::class, 'index'])->name('drop-point');
        Route::get('pengaturan', [PengaturanController::class, 'index'])->name('pengaturan');
        Route::get('profil', [ProfilController::class, 'show'])->name('profil');
        Route::get('profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');
        Route::get('edukasi', [EdukasiController::class, 'index'])->name('edukasi');
        Route::get('edukasi/konten/{edukasi}', [EdukasiController::class, 'content'])->name('edukasi.konten');
        Route::get('edukasi/{slug}', [EdukasiController::class, 'show'])->name('edukasi.show');
        Route::get('pengaturan/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi');
        Route::get('pengaturan/privasi', [PrivasiController::class, 'index'])->name('privasi');
        Route::get('pengaturan/bantuan', [BantuanController::class, 'index'])->name('bantuan');
        Route::patch('profil', [ProfilController::class, 'update'])->name('profil.update');
        Route::post('pengaturan/notifikasi/{id?}', [NotifikasiController::class, 'read'])->name('notifikasi.read');
        Route::put('pengaturan/password', [PrivasiController::class, 'password'])->name('password');
        Route::put('pengaturan/privasi', [PrivasiController::class, 'update'])->name('privasi.update');
        Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('laporan/{laporan}', [LaporanController::class, 'show'])->name('laporan.show');
    });
});
