<?php

use App\Http\Controllers\Admin\AktivitasController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DropPointController;
use App\Http\Controllers\Admin\EdukasiController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\MonitoringController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Admin\RuteController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'form'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.store');
    Route::get('daftar', [AuthController::class, 'form'])->name('daftar');
    Route::post('daftar', [AuthController::class, 'register'])->name('daftar.store')->middleware('throttle:10,1');
    Route::get('daftar/berhasil', [AuthController::class, 'success'])->name('daftar.berhasil');
    Route::middleware(['auth', 'role:admin', 'aktif'])->group(function () {
        Route::get('profil', [ProfilController::class, 'show'])->name('profil');
        Route::get('profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');
        Route::patch('profil', [ProfilController::class, 'update'])->name('profil.update');
        Route::post('keluar', [AuthController::class, 'logout'])->name('keluar');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('monitoring', [MonitoringController::class, 'index'])->name('monitoring');
        Route::get('aktivitas', [AktivitasController::class, 'index'])->name('aktivitas');
        // Sebelumnya hanya index/edit/update/destroy; create/store diperlukan tombol Tambah Pengguna.
        // Route::resource('pengguna', PenggunaController::class)->only(['index', 'edit', 'update', 'destroy'])->parameters(['pengguna' => 'id']);
        Route::resource('pengguna', PenggunaController::class)->except('show')->parameters(['pengguna' => 'id']);
        Route::resource('jadwal', JadwalController::class)->except('show')->parameters(['jadwal' => 'id']);
        Route::resource('rute', RuteController::class)->except('show')->parameters(['rute' => 'id']);
        Route::resource('edukasi', EdukasiController::class)->except('show')->parameters(['edukasi' => 'id']);
        Route::resource('drop-point', DropPointController::class)->except('show')->parameters(['drop-point' => 'id']);
        Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('laporan/{laporan}', [LaporanController::class, 'show'])->name('laporan.show');
        Route::patch('laporan/{laporan}', [LaporanController::class, 'update'])->name('laporan.update');
    });
});
