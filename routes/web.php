<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\KaryawanController as AdminKaryawanController;
use App\Http\Controllers\Admin\AbsensiAdminController;
use App\Http\Controllers\Admin\GajiController as AdminGajiController;
use App\Http\Controllers\Karyawan\KaryawanDashboardController;
use App\Http\Controllers\Karyawan\AbsensiKaryawanController;

// Halaman Awal (Jika ada, jika tidak bisa redirect ke login)
Route::get('/', function () {
    // Cek jika sudah login, redirect sesuai role
    if (Auth::check()) {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        if (Auth::user()->isKaryawan()) {
            return redirect()->route('karyawan.dashboard');
        }
    }
    return redirect()->route('login'); // Redirect ke login jika belum login
});


// Auth Routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'login'])->middleware('guest');
Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // CRUD Karyawan
    Route::resource('karyawan', AdminKaryawanController::class);

    // Absensi Admin
    Route::get('absensi/rekap', [AbsensiAdminController::class, 'rekapAbsensi'])->name('absensi.rekap');
    // Tambahkan route untuk create/edit absensi manual oleh admin jika perlu

    // Gaji Admin
    Route::get('gaji', [AdminGajiController::class, 'index'])->name('gaji.index');
    Route::get('gaji/hitung', [AdminGajiController::class, 'formHitungGaji'])->name('gaji.form_hitung');
    Route::post('gaji/hitung', [AdminGajiController::class, 'prosesHitungGaji'])->name('gaji.proses_hitung');
    Route::get('gaji/slip/{gaji}', [AdminGajiController::class, 'cetakSlip'])->name('gaji.cetak_slip');
});


// Karyawan Routes
Route::middleware(['auth', 'role:karyawan'])->prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('dashboard', [KaryawanDashboardController::class, 'index'])->name('dashboard');

    // Absensi Karyawan
    Route::get('absensi', [AbsensiKaryawanController::class, 'formPresensi'])->name('absensi.form');
    Route::post('absensi/masuk', [AbsensiKaryawanController::class, 'presensiMasuk'])->name('absensi.masuk');
    Route::post('absensi/pulang', [AbsensiKaryawanController::class, 'presensiPulang'])->name('absensi.pulang');
    Route::get('absensi/riwayat', [AbsensiKaryawanController::class, 'riwayatAbsensi'])->name('absensi.riwayat');
});