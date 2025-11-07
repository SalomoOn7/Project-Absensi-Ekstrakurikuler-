<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EskulController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\Admin\AnggotaController;
use App\Http\Controllers\Admin\RekapAbsensiController;
use App\Http\Controllers\Admin\RekapCetakController;
use App\Http\Controllers\Jadwal\JadwalEskulController;
use App\Http\Controllers\Petugas\AbsensiController;


Route::get('/', function () {
    return view('welcome');
});

// Dashboard utama
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// SuperAdmin
Route::prefix('superadmin')->middleware(['auth', 'role:super_admin'])->name('superadmin.')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'index'])->name('dashboard');
    Route::resource('eskul', EskulController::class);
    Route::get('/rekap', [RekapCetakController::class, 'index'])->name('rekap.index');
    Route::get('/rekap/pdf/{eskul}/{bulan}/{tahun}', [RekapCetakController::class, 'cetakPDF'])->name('rekap.pdf');
    Route::get('/rekap/excel/{eskul}/{bulan}/{tahun}', [RekapCetakController::class, 'cetakExcel'])->name('rekap.excel');
    Route::get('/rekap/detail-excel/{eskul_id}/{bulan}/{tahun}', [RekapAbsensiController::class, 'exportDetailExcel'])->name('rekap.detailExcel');

});

// Admin
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    Route::resource('petugas', PetugasController::class)->parameters([
        'petugas' => 'petugas'
    ]);
    Route::resource('anggota', AnggotaController::class);
    Route::resource('jadwal', JadwalEskulController::class);
    Route::resource('rekap', RekapAbsensiController::class);
});



// Petugas
Route::prefix('petugas')->middleware(['auth', 'role:petugas'])->name('petugas.')->group(function () {
    Route::get('/dashboard', function () {
        return view('petugas.dashboard');
    })->name('dashboard');
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/absensi/{jadwal_id}/create', [AbsensiController::class, 'create'])->name('absensi.create');
    Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
});


require __DIR__.'/auth.php';
