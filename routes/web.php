<?php

use App\Http\Controllers\ActivationController;
use App\Http\Controllers\Api\GeocodeController;
use App\Http\Controllers\Landing\LandingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::middleware(['auth', 'aktif', 'throttle:30,1'])->prefix('api/geocode')->group(function () {
    Route::get('search', [GeocodeController::class, 'search']);
    Route::get('reverse', [GeocodeController::class, 'reverse']);
});
require __DIR__ . '/warga.php';
require __DIR__ . '/petugas.php';
require __DIR__ . '/admin.php';

Route::get('/aktivasi/{token}', [ActivationController::class, 'form'])->name('activation.form');
Route::post('/aktivasi', [ActivationController::class, 'store'])->middleware('throttle:10,1')->name('activation.store');
Route::post('/admin/pengguna/{id}/aktivasi', [ActivationController::class, 'resend'])->middleware(['auth', 'role:admin', 'aktif', 'throttle:10,1'])->name('admin.pengguna.activation');
