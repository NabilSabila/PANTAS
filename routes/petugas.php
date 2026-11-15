<?php

use App\Http\Controllers\Petugas\AuthController;
use App\Http\Controllers\Petugas\BantuanController;
use App\Http\Controllers\Petugas\BerandaController;
use App\Http\Controllers\Petugas\EdukasiController;
use App\Http\Controllers\Petugas\LaporanController;
use App\Http\Controllers\Petugas\NotifikasiController;
use App\Http\Controllers\Petugas\PrivasiController;
use App\Http\Controllers\Petugas\ProfilController;
use App\Http\Controllers\Petugas\RuteController;
use Illuminate\Support\Facades\Route;

Route::prefix('petugas')->name('petugas.')->group(function () {
    Route::get('login', [AuthController::class, 'form'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.store');
    Route::get('daftar', [AuthController::class, 'form'])->name('daftar');
    Route::post('daftar', [AuthController::class, 'register'])->name('daftar.store')->middleware('throttle:10,1');
    Route::get('daftar/berhasil', [AuthController::class, 'success'])->name('daftar.berhasil');
    Route::middleware(['auth', 'role:petugas', 'aktif'])->group(function () {
        Route::post('keluar', [AuthController::class, 'logout'])->name('keluar');
        Route::get('beranda', [BerandaController::class, 'index'])->name('beranda');
        Route::get('rute', [RuteController::class, 'index'])->name('rute.index');
        Route::get('rute/skema', [RuteController::class, 'index'])->name('rute.skema');
        Route::post('rute/mulai', [RuteController::class, 'start'])->name('rute.mulai');
        Route::patch('rute/titik/{id}', [RuteController::class, 'point'])->name('rute.titik');
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
        Route::patch('laporan/{laporan}', [LaporanController::class, 'update'])->name('laporan.update');
    });
});
