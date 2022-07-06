<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\CabangController;
use App\Http\Controllers\Admin\PenggunaController;
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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('admin/home', [HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');

// -------------------------------MASTER DATA-------------------------
Route::group(['middleware' => 'is_admin'], function () {
    // Cabang
    Route::get('/cabang', [CabangController::class, 'index'])->name('cabang');
    Route::post('/list_cabang', [CabangController::class, 'listCabang']);
    Route::post('/upload/cabang', [CabangController::class, 'addCabang']);
    Route::post('/upload/cabang/{id_cabang}', [CabangController::class, 'updateCabang']);
    Route::get('/delete_cabang/{id_cabang}', [CabangController::class, 'hapusCabang']);

    //Jabatan
    Route::get('/jenis_jabatan', [PenggunaController::class, 'jenisJabatan'])->name('jenisjabatan');

    // Pengguna
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna');
    Route::post('/list_pengguna', [PenggunaController::class, 'listPengguna']);
    Route::post('/kodearea', [PenggunaController::class, 'kodeArea']);
    Route::post('/upload/pengguna', [PenggunaController::class, 'addPengguna']);
    Route::get('/delete_pengguna/{id}', [PenggunaController::class, 'hapusPengguna']);
});
