<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\Satpam\BarangController as SatpamBarangController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

// ---------- Autentikasi (Proses 2.0) ----------
Route::middleware('guest')->group(function () {
    Route::get('/login', [PenggunaController::class, 'showLogin'])->name('login');
    Route::post('/login', [PenggunaController::class, 'login'])->name('login.attempt');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [PenggunaController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [PenggunaController::class, 'redirectByRole'])->name('dashboard');
});

// ---------- Mahasiswa ----------
Route::middleware(['auth', 'role:mahasiswa'])
    ->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', [BarangController::class, 'index'])->name('dashboard');

        // Sprint berikutnya (Proses 4.0)
        // Route::get('/barang/{barang}', [BarangController::class, 'show'])->name('barang.show');
        // Route::get('/barang/{barang}/klaim/create', [PengajuanKlaimController::class, 'create'])->name('klaim.create');
        // Route::post('/barang/{barang}/klaim', [PengajuanKlaimController::class, 'store'])->name('klaim.store');
        // Route::get('/klaim', [PengajuanKlaimController::class, 'index'])->name('klaim.index');
    });

// ---------- Satpam ----------
Route::middleware(['auth', 'role:satpam'])
    ->prefix('satpam')->name('satpam.')->group(function () {
        Route::get('/dashboard', [SatpamBarangController::class, 'dashboard'])->name('dashboard');

        // Sprint berikutnya
        // Proses 3.0: Route::resource('barang', SatpamBarangController::class)->except(['destroy']);
        // Proses 5.0: Route::get('/klaim', [PengajuanKlaimController::class, 'index'])->name('klaim.index');
        //             Route::patch('/klaim/{klaim}/verifikasi', [PengajuanKlaimController::class, 'verifikasi'])->name('klaim.verifikasi');
        // Proses 6.0: Route::get('/klaim/{klaim}/serah-terima/create', [BuktiPenyerahanController::class, 'create'])->name('serah-terima.create');
        //             Route::post('/klaim/{klaim}/serah-terima', [BuktiPenyerahanController::class, 'store'])->name('serah-terima.store');
    });