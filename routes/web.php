<?php

use App\Http\Controllers\AuthSiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Jika ingin menggunakan kembali AuthSiswaController yang lama:
Route::get('/login-siswa', [AuthSiswaController::class, 'showLoginForm'])->name('login');
Route::post('/login-siswa', [AuthSiswaController::class, 'login']);
Route::post('/logout-siswa', [AuthSiswaController::class, 'logout'])->name('siswa.logout');

// Rute redirect untuk Filament Ujian
Route::get('/ujian/login', function () {
    return redirect('/login-siswa');
})->name('filament.ujian.auth.login');