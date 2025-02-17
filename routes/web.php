<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KtpController as AdminKtpController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Petugas\KtpController as PetugasKtpController;
use App\Http\Controllers\Petugas\TugasController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ExportController as AdminExportController;
use App\Http\Controllers\Petugas\ExportController as PetugasExportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth routes
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    
    // KTP routes
    Route::get('/ktp/export', [AdminKtpController::class, 'exportPDF'])->name('ktp.export');
    Route::get('/ktp/export/{year}/{month}', [AdminKtpController::class, 'exportBulanan'])
        ->where(['year' => '[0-9]+', 'month' => '[0-9]+'])
        ->name('ktp.export.bulanan');
    Route::get('/ktp/export/{year}', [AdminKtpController::class, 'exportTahunan'])
        ->where('year', '[0-9]+')
        ->name('ktp.export.tahunan');
    Route::get('/ktp/export-pdf', [AdminKtpController::class, 'exportPDF'])->name('ktp.export-pdf');
    Route::patch('/ktp/{ktp}/toggle-status', [AdminKtpController::class, 'toggleStatus'])->name('ktp.toggle-status');
    Route::resource('/ktp', AdminKtpController::class);
    
    // Laporan routes
    Route::resource('/laporan', LaporanController::class);
    Route::put('/laporan/{laporan}/status', [LaporanController::class, 'updateStatus'])->name('laporan.update-status');
    Route::get('/laporan/{laporan}/download-pdf', [LaporanController::class, 'downloadPDF'])->name('laporan.download-pdf');
    
    // Petugas routes
    Route::resource('/petugas', PetugasController::class);
    
    // Export routes
    Route::get('/export', [AdminExportController::class, 'index'])->name('export.index');
    Route::get('/export/ktp', [AdminExportController::class, 'exportKtp'])->name('export.ktp');
    Route::get('/export/laporan', [AdminExportController::class, 'exportLaporan'])->name('export.laporan');
});

// Petugas routes
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [PetugasDashboardController::class, 'index'])->name('dashboard');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    
    // KTP routes
    Route::resource('/ktp', PetugasKtpController::class);
    Route::get('/ktp/export-pdf', [PetugasKtpController::class, 'exportPDF'])->name('ktp.export-pdf');
    
    // Tugas routes
    Route::get('/tugas', [TugasController::class, 'index'])->name('tugas.index');
    Route::get('/tugas/{laporan}', [TugasController::class, 'show'])->name('tugas.show');
    Route::patch('/tugas/{laporan}/status', [TugasController::class, 'updateStatus'])->name('tugas.update-status');
    
    // Status Ketersediaan route
    Route::patch('/status', [PetugasController::class, 'updateKetersediaan'])->name('status.update');
    
    // Export routes
    Route::get('/export', [PetugasExportController::class, 'index'])->name('export.index');
    Route::get('/export/ktp', [PetugasExportController::class, 'exportKtp'])->name('export.ktp');
    Route::get('/export/ktp/print', [PetugasExportController::class, 'printKtp'])->name('export.ktp.print');
    Route::get('/export/laporan', [PetugasExportController::class, 'exportLaporan'])->name('export.laporan');
    Route::get('/export/laporan/print', [PetugasExportController::class, 'printLaporan'])->name('export.laporan.print');
});
