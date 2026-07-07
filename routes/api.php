<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\VideoPembelajaranController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KuisController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JumlahSoalController;


Route::get('/', function () {
    return response()->json([
        'success' => true,
        'message' => 'API Laravel aktif'
    ]);
});

Route::post('/login', [AuthController::class, 'login']);

Route::get('/guru/{id}', [GuruController::class, 'profile']);
Route::put('/guru/{id}', [GuruController::class, 'updateProfile']);

Route::get('/video', [VideoPembelajaranController::class, 'index']);
Route::post('/video', [VideoPembelajaranController::class, 'store']);
Route::put('/video/{id}', [VideoPembelajaranController::class, 'update']);
Route::get('/video/stream/{file}', [VideoPembelajaranController::class, 'stream']);

Route::get('/siswa', [SiswaController::class, 'index']);
Route::post('/siswa', [SiswaController::class, 'store']);
Route::put('/siswa/{id}', [SiswaController::class, 'update']);
Route::get('/siswa/{nis}', [SiswaController::class, 'showByNis']);
Route::get('/siswa-aktif', [SiswaController::class, 'siswaAktif']);

Route::get('/hasil/export/excel', [HasilController::class, 'exportExcel']);
Route::get('/hasil/export/pdf', [HasilController::class, 'exportPdf']);

Route::get('/dashboard/statistik', [DashboardController::class, 'statistik']);

// =========================
// ADMIN KUIS
// =========================
Route::get('/admin/kuis', [
    KuisController::class,
    'adminIndex'
]);



// =========================
// KUIS SISWA
// =========================
Route::get('/kuis', [
    KuisController::class,
    'index'
]);

Route::get('/kuis/list', [KuisController::class, 'listKuis']);

Route::get('/kuis/{id}/soal', [
    KuisController::class,
    'soalByKuis'
]);

Route::get('/kuis/{id}', [
    KuisController::class,
    'show'
]);

Route::post('/kuis', [
    KuisController::class,
    'store'
]);


Route::put('/kuis/{id}', [
    KuisController::class,
    'update'
]);

Route::delete('/kuis/{id}', [
    KuisController::class,
    'destroy'
]);

Route::post('/kuis/submit', [
    KuisController::class,
    'submitQuiz'
]);

Route::get('/hasil', [
    HasilController::class,
    'index'
]);



Route::get('/jumlah-soal', [JumlahSoalController::class, 'show']);

Route::put('/jumlah-soal', [JumlahSoalController::class, 'update']);

Route::get('/phpinfo', function () {
    phpinfo();
});
