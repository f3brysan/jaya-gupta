<?php

use App\Http\Controllers\AksiNyataController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BiodataController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndoController;
use App\Http\Controllers\InovasiController;
use App\Http\Controllers\StatusInovasiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'auth']);
Route::post('logout', [AuthController::class, 'logout']);

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);

    Route::get('biodata', [BiodataController::class, 'show']);
    Route::post('biodata/simpan', [BiodataController::class, 'store']);

    Route::get('ganti-password', [BiodataController::class, 'show_password']);
    Route::post('ganti-password/simpan', [BiodataController::class, 'store_password']);
});

Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('guru/inovasi', [InovasiController::class, 'index']);
    Route::get('guru/inovasi/tambah/', [InovasiController::class, 'tambah']);
    Route::post('guru/inovasi/store/', [InovasiController::class, 'store']);
    Route::get('guru/inovasi/edit/{id}', [InovasiController::class, 'edit']);
    Route::post('guru/inovasi/hapus', [InovasiController::class, 'hapus']);

    Route::get('guru/aksi-nyata', [AksiNyataController::class, 'index']);
    Route::get('guru/aksi-nyata/tambah/', [AksiNyataController::class, 'tambah']);
    Route::post('guru/aksi-nyata/store/', [AksiNyataController::class, 'store']);
    Route::get('guru/aksi-nyata/edit/{id}', [AksiNyataController::class, 'edit']);
    Route::post('guru/aksi-nyata/hapus', [AksiNyataController::class, 'hapus']);
});

Route::middleware(['auth', 'role:kurator'])->group(function () {
    Route::get('kurator/inovasi', [StatusInovasiController::class, 'index_inovasi']);
    Route::get('kurator/aksi-nyata', [StatusInovasiController::class, 'index_aksi']);
    Route::post('kurator/nilai', [StatusInovasiController::class, 'nilai']);
});

Route::get('ajax/getkabupaten/{id}', [IndoController::class, 'getkabupaten']);
Route::get('ajax/getkecamatan/{id}', [IndoController::class, 'getkecamatan']);