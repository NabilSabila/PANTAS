<?php

use App\Http\Controllers\Petugas\AuthController;
use App\Http\Controllers\Petugas\BerandaController;
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
    });
});
