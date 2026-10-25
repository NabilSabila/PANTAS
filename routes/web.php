<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Halaman Utama Beranda
Route::get('/', function () {
    return view('welcome');
});

// Route Login Warga (Menggunakan AuthController)
Route::get('/login/warga', [AuthController::class, 'showLoginWarga'])->name('warga.login');
Route::post('/login/warga', [AuthController::class, 'loginWarga']);

// Route Sign Up Warga
Route::get('/register/warga', [AuthController::class, 'showRegisterWarga'])->name('warga.register');
Route::post('/register/warga', [AuthController::class, 'registerWarga']);

// Route Login Petugas Kebersihan
Route::get('/login/petugas', [AuthController::class, 'showLoginPetugas'])->name('petugas.login');
Route::post('/login/petugas', [AuthController::class, 'loginPetugas']);

// Route Sign Up Petugas Kebersihan
Route::get('/register/petugas', [AuthController::class, 'showRegisterPetugas'])->name('petugas.register');
Route::post('/register/petugas', [AuthController::class, 'registerPetugas']);

// Route Login Admin
Route::get('/login/admin', [AuthController::class, 'showLoginAdmin'])->name('admin.login');
Route::post('/login/admin', [AuthController::class, 'loginAdmin']);

// Route Sign Up Admin
Route::get('/register/admin', [AuthController::class, 'showRegisterAdmin'])->name('admin.register');
Route::post('/register/admin', [AuthController::class, 'registerAdmin']);

// Beranda Warga
Route::middleware('auth')->get('/warga/dashboard', function () {
    return view('warga.dashboard');
})->name('warga.dashboard');
