<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminYayasanController;
use App\Http\Controllers\YayasanController;
use App\Http\Controllers\AdminSekolahController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\UserGuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\BobotKriteriaController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\RekomendasiController;

// Login selector
Route::get('/', [LoginController::class, 'showLoginSelector'])->name('login')->middleware('sudahLogin');
Route::get('/login', [LoginController::class, 'showLoginSelector'])->name('login')->middleware('sudahLogin');

// Halaman login per role
Route::get('/login/admin-yayasan', [LoginController::class, 'showAdminYayasanLoginForm'])->name('login.admin-yayasan')->middleware('sudahLogin');
Route::get('/login/admin-sekolah', [LoginController::class, 'showAdminSekolahLoginForm'])->name('login.admin-sekolah')->middleware('sudahLogin');
Route::get('/login/guru', [LoginController::class, 'showGuruLoginForm'])->name('login.guru')->middleware('sudahLogin');

// Proses login
Route::post('/login/admin-yayasan', [LoginController::class, 'loginAdminYayasan'])->name('auth.login.admin-yayasan')->middleware('sudahLogin');
Route::post('/login/admin-sekolah', [LoginController::class, 'loginAdminSekolah'])->name('auth.login.admin-sekolah')->middleware('sudahLogin');
Route::post('/login/guru', [LoginController::class, 'loginGuru'])->name('auth.login.guru')->middleware('sudahLogin');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ADMIN YAYASAN
Route::middleware('cekLogin:admin_yayasan')->group(function () {
    Route::get('/admin-yayasan', [AdminYayasanController::class, 'index']);
    Route::post('/admin-yayasan/store', [AdminYayasanController::class, 'store']);
    Route::post('/admin-yayasan/update/{id}', [AdminYayasanController::class, 'update']);
    Route::get('/admin-yayasan/delete/{id}', [AdminYayasanController::class, 'destroy']);

    Route::get('/yayasan', [YayasanController::class, 'index']);
    Route::post('/yayasan/store', [YayasanController::class, 'store']);
    Route::post('/yayasan/update/{id}', [YayasanController::class, 'update']);
    Route::get('/yayasan/delete/{id}', [YayasanController::class, 'destroy']);

    Route::get('/sekolah', [SekolahController::class, 'index']);
    Route::post('/sekolah/store', [SekolahController::class, 'store']);
    Route::post('/sekolah/update/{id}', [SekolahController::class, 'update']);
    Route::get('/sekolah/delete/{id}', [SekolahController::class, 'destroy']);

    Route::get('/admin-sekolah', [AdminSekolahController::class, 'index']);
    Route::post('/admin-sekolah/store', [AdminSekolahController::class, 'store']);
    Route::post('/admin-sekolah/update/{id}', [AdminSekolahController::class, 'update']);
    Route::get('/admin-sekolah/delete/{id}', [AdminSekolahController::class, 'destroy']);
});

// ADMIN SEKOLAH
Route::middleware('cekLogin:admin_sekolah')->group(function () {
    Route::get('/user-guru', [UserGuruController::class, 'index']);
    Route::post('/user-guru/store', [UserGuruController::class, 'store']);
    Route::post('/user-guru/update/{id}', [UserGuruController::class, 'update']);
    Route::get('/user-guru/delete/{id}', [UserGuruController::class, 'destroy']);

    Route::get('/kelas', [KelasController::class, 'index']);
    Route::post('/kelas/store', [KelasController::class, 'store']);
    Route::post('/kelas/update/{id}', [KelasController::class, 'update']);
    Route::get('/kelas/delete/{id}', [KelasController::class, 'destroy']);

    Route::get('/kriteria', [KriteriaController::class, 'index']);
    Route::post('/kriteria/store', [KriteriaController::class, 'store']);
    Route::post('/kriteria/update/{id}', [KriteriaController::class, 'update']);
    Route::get('/kriteria/delete/{id}', [KriteriaController::class, 'destroy']);

    Route::get('/bobot-kriteria', [BobotKriteriaController::class, 'index']);
    Route::post('/bobot-kriteria/store', [BobotKriteriaController::class, 'store']);
    Route::post('/bobot-kriteria/update/{id}', [BobotKriteriaController::class, 'update']);
    Route::get('/bobot-kriteria/delete/{id}', [BobotKriteriaController::class, 'destroy']);

    Route::get('/periode', [PeriodeController::class, 'index']);
    Route::post('/periode/store', [PeriodeController::class, 'store']);
    Route::post('/periode/update/{id}', [PeriodeController::class, 'update']);
    Route::get('/periode/delete/{id}', [PeriodeController::class, 'destroy']);

    Route::get('/semester', [SemesterController::class, 'index']);
    Route::post('/semester/store', [SemesterController::class, 'store']);
    Route::post('/semester/update/{id}', [SemesterController::class, 'update']);
    Route::get('/semester/delete/{id}', [SemesterController::class, 'destroy']);
});

// GURU
Route::middleware('cekLogin:user_guru')->group(function () {
    Route::get('/siswa', [SiswaController::class, 'index']);
    Route::post('/siswa/store', [SiswaController::class, 'store']);
    Route::post('/siswa/update/{id}', [SiswaController::class, 'update']);
    Route::get('/siswa/delete/{id}', [SiswaController::class, 'destroy']);

    Route::get('/penilaian', [PenilaianController::class, 'index']);
    Route::post('/penilaian/store', [PenilaianController::class, 'store']);
    Route::post('/penilaian/update/{id}', [PenilaianController::class, 'update']);
    Route::get('/penilaian/delete/{id}', [PenilaianController::class, 'destroy']);

    Route::get('/ranking', [RekomendasiController::class, 'index']);
    Route::post('/ranking/store', [RekomendasiController::class, 'store']);
    Route::post('/ranking/update/{id}', [RekomendasiController::class, 'update']);
    Route::get('/ranking/delete/{id}', [RekomendasiController::class, 'destroy']);
});

