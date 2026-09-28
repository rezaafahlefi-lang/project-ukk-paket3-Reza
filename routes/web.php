<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

// Halaman utama langsung diarahkan ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// Route untuk Login & Logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route khusus Admin
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/aspirasi/{id_aspirasi}', [\App\Http\Controllers\AdminController::class, 'update'])->name('admin.aspirasi.update');
    
    // Tambahan route untuk menyimpan kategori baru
    Route::post('/admin/kategori', [\App\Http\Controllers\AdminController::class, 'storeKategori'])->name('admin.kategori.store');
    
    // Tambahan route untuk menghapus data (D) - Harus di dalam blok Admin
    Route::delete('/admin/aspirasi/hapus/{id_pelaporan}', [\App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.aspirasi.destroy');
});

// Route khusus Siswa
Route::middleware(['auth:siswa'])->group(function () {
    Route::get('/siswa/dashboard', [\App\Http\Controllers\SiswaController::class, 'index'])->name('siswa.dashboard');
    Route::post('/siswa/aspirasi', [\App\Http\Controllers\SiswaController::class, 'store'])->name('siswa.aspirasi.store');
});