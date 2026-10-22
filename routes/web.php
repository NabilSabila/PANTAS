<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/login/warga', function () {
    return "Halaman Login / Dashboard Warga";
});

Route::get('/login/petugas', function () {
    return "Halaman Login / Dashboard Petugas Kebersihan";
});

Route::get('/login/admin', function () {
    return "Halaman Login / Dashboard Admin";
});
