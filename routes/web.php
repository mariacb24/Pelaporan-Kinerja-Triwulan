<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndikatorKinerjaController;
use App\Http\Controllers\RealisasiKinerjaController;
use App\Http\Controllers\DokumenWebsiteController;
use App\Http\Controllers\DokumenSpmiController;
use App\Http\Controllers\PedomanSopController;
use App\Http\Controllers\AkreditasiController;
use App\Http\Controllers\SurveiController;
use App\Http\Controllers\KepuasanMahasiswaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart', [DashboardController::class, 'chartData'])->name('dashboard.chart');

    Route::prefix('realisasi')->name('realisasi.')->middleware('role:admin,operator_bpm')->group(function () {
        Route::get('/', [RealisasiKinerjaController::class, 'index'])->name('index');
        Route::get('/create', [RealisasiKinerjaController::class, 'create'])->name('create');
        Route::post('/', [RealisasiKinerjaController::class, 'store'])->name('store');
        Route::get('/{realisasi}/edit', [RealisasiKinerjaController::class, 'edit'])->name('edit');
        Route::put('/{realisasi}', [RealisasiKinerjaController::class, 'update'])->name('update');
        Route::delete('/{realisasi}', [RealisasiKinerjaController::class, 'destroy'])->name('destroy');
        Route::post('/{realisasi}/verifikasi', [RealisasiKinerjaController::class, 'verifikasi'])->name('verifikasi');
    });

    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/draft', [LaporanController::class, 'draft'])->name('draft');
        Route::get('/final', [LaporanController::class, 'final'])->name('final');
        Route::get('/export/pdf', [LaporanController::class, 'generatePdf'])->name('pdf');
        Route::get('/export/excel', [LaporanController::class, 'generateExcel'])->name('excel');
    });

    Route::resource('indikator', IndikatorKinerjaController::class)->middleware('role:admin,operator_bpm');
    Route::get('/indikator-export/excel', [IndikatorKinerjaController::class, 'exportExcel'])->name('indikator.export.excel');
    Route::get('/indikator-export/pdf', [IndikatorKinerjaController::class, 'exportPdf'])->name('indikator.export.pdf');

    Route::resource('dokumen/website', DokumenWebsiteController::class)->names('dokumen.website')->middleware('role:admin,operator_bpm');
    Route::resource('dokumen/spmi', DokumenSpmiController::class)->names('dokumen.spmi')->middleware('role:admin,operator_bpm');
    Route::resource('pedoman', PedomanSopController::class)->middleware('role:admin,operator_bpm');

    Route::resource('akreditasi', AkreditasiController::class)->middleware('role:admin,operator_bpm');

    Route::resource('survei', SurveiController::class)->middleware('role:admin,operator_bpm');
    Route::resource('kepuasan', KepuasanMahasiswaController::class)->middleware('role:admin,operator_bpm');

    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle');
    });
});
