<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\NotulaController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\DokumentasiController;

// Rute Halaman Awal dan Login
Route::get('/', function () {
    return redirect()->route('login'); 
});
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.post');
Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Grup rute yang memerlukan otentikasi
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute khusus Admin
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('teachers', TeacherController::class);
        Route::resource('agendas', AgendaController::class);
        Route::resource('notulas', NotulaController::class);
        Route::resource('presensi', PresensiController::class)->only(['index', 'edit', 'update', 'destroy']); // Admin hanya mengelola, tidak membuat
        Route::resource('dokumentasi', DokumentasiController::class);
        Route::get('dokumentasi/{dokumentasi}/download', [DokumentasiController::class, 'download'])->name('dokumentasi.download');
    });

    // Rute khusus Guru
    Route::middleware(['role:guru'])->group(function () {
        Route::get('guru/agendas', [AgendaController::class, 'guruIndex'])->name('agendas.guru');
        Route::get('guru/notulas', [NotulaController::class, 'guruIndex'])->name('notulas.guru');
        
        // Rute untuk guru mengisi presensi
        Route::get('presensi/isi', [PresensiController::class, 'createForGuru'])->name('presensi.create');
        Route::post('presensi/isi', [PresensiController::class, 'storeForGuru'])->name('presensi.store');
    });
});