<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\NotulaController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\DokumentasiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute Login/Logout
Route::get('/', function () { return redirect()->route('login'); });
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// Rute yang membutuhkan otentikasi
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute Admin - Hanya bisa diakses oleh user dengan role 'admin'
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('teachers', TeacherController::class);

        Route::resource('agendas', AgendaController::class);
        // Khusus untuk halaman create/edit agenda, karena form LLM ada di sana (meskipun fitur LLMnya dihapus, rutenya tetap diperlukan)
        Route::get('agendas/create', [AgendaController::class, 'create'])->name('agendas.create');
        Route::get('agendas/{agenda}/edit', [AgendaController::class, 'edit'])->name('agendas.edit');

        Route::resource('notulas', NotulaController::class);
        // Khusus untuk halaman create/edit notula
        Route::get('notulas/create', [NotulaController::class, 'create'])->name('notulas.create');
        Route::get('notulas/{notula}/edit', [NotulaController::class, 'edit'])->name('notulas.edit');

        Route::resource('presensi', PresensiController::class)->except(['create', 'store']); // Admin melihat presensi
        Route::resource('dokumentasi', DokumentasiController::class);
    });

    // Rute Guru - Hanya bisa diakses oleh user dengan role 'guru'
    Route::middleware(['role:guru'])->group(function () {
        Route::get('/agendas/guru', [AgendaController::class, 'guruIndex'])->name('agendas.guru');
        Route::get('/notulas/guru', [NotulaController::class, 'guruIndex'])->name('notulas.guru');

        // Rute untuk guru mengisi presensi
        Route::get('/presensi/create', [PresensiController::class, 'createForGuru'])->name('presensi.create');
        Route::post('/presensi/store', [PresensiController::class, 'storeForGuru'])->name('presensi.store');
    });
});