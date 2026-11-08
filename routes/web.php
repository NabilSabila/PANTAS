<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Warga\LaporanController;

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

// Laporan Sampah
Route::prefix('warga/laporan')->name('warga.laporan.')->group(function () {
    Route::get('/', [LaporanController::class, 'index'])->name('index');
    Route::get('/buat', [LaporanController::class, 'create'])->name('create');
    Route::post('/buat/proses', [LaporanController::class, 'postCreate'])->name('create.process'); // Menyimpan data step sementara ke session
    Route::post('/simpan', [LaporanController::class, 'store'])->name('store'); // Simpan permanen ke DB di step 3
    Route::get('/konfirmasi/{id}', [LaporanController::class, 'konfirmasi'])->name('konfirmasi');
    Route::get('/{id}', [LaporanController::class, 'show'])->name('show');
});