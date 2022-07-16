<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\CabangController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\JabatanController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\AkunBankController;
use App\Http\Controllers\Admin\PenjualanController;
use App\Http\Controllers\Sales\PengirimanController;
use App\Http\Controllers\Sales\TugasController;

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
Route::get('sales/home', [HomeController::class, 'salesHome'])->name('sales.home')->middleware('is_sales');

// -------------------------------ADMIN-------------------------
Route::group(['middleware' => 'is_admin'], function () {
    // Cabang
    Route::get('/cabang', [CabangController::class, 'index'])->name('cabang');
    Route::post('/list_cabang', [CabangController::class, 'listCabang']);
    Route::post('/upload/cabang', [CabangController::class, 'addCabang']);
    Route::post('/upload/cabang/{id_cabang}', [CabangController::class, 'updateCabang']);
    Route::get('/delete_cabang/{id_cabang}', [CabangController::class, 'hapusCabang']);

    //Jabatan
    Route::get('/jabatan', [JabatanController::class, 'index'])->name('jabatan');
    Route::post('/jenis_jabatan', [JabatanController::class, 'jenisJabatan']);
    Route::post('/add/jabatan', [JabatanController::class, 'addJabatan']);

    // Pengguna
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna');
    Route::post('/list_pengguna', [PenggunaController::class, 'listPengguna']);
    Route::post('/kodearea', [PenggunaController::class, 'kodeArea']);
    Route::post('/kodeareaedited', [PenggunaController::class, 'kodeAreaEdited']);
    Route::post('/upload/pengguna', [PenggunaController::class, 'addPengguna']);
    Route::post('/edit/pengguna/{id}', [PenggunaController::class, 'editPengguna']);
    Route::get('/delete_pengguna/{id}', [PenggunaController::class, 'hapusPengguna']);

    //Pelanggan
    Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan');
    Route::post('/data_pelanggan', [PelangganController::class, 'listPelanggan']);
    Route::post('/add/pelanggan', [PelangganController::class, 'addPelanggan']);
    Route::get('/detail_pelanggan', [PelangganController::class, 'detailPelanggan']);
    Route::post('/update/pelanggan/{id_pelanggan}', [PelangganController::class, 'updatePelanggan']);
    Route::get('/delete_pelanggan/{id_pelanggan}', [PelangganController::class, 'deletePelanggan']);

    //Akun Bank
    Route::get('/akunbank', [AkunBankController::class, 'index'])->name('akunbank');
    Route::post('/list_bank', [AkunBankController::class, 'listBank']);
    Route::post('/add_bank', [AkunBankController::class, 'addBank']);

    //Penjualan
    Route::get('/penjualan', [PenjualanController::class, 'index']);
    Route::post('/data_penjualan', [PelangganController::class, 'listPelanggan']);
    Route::get('/detail_penjualan/{id_pelanggan}', [PenjualanController::class, 'detailPenjualan']);
});

Route::group(['middleware' => 'is_sales'], function () {
    // Pengiriman
    Route::get('/pengiriman/{id_cabang}', [PengirimanController::class, 'index'])->name('pengiriman');
    Route::post('/pengiriman/{id_cabang}', [PengirimanController::class, 'listPengiriman']);
    Route::get('/add/pengiriman/{id_cabang}', [PengirimanController::class, 'addPengiriman'])->name('tambah.pengiriman');

    Route::post('/kodeareapengguna', [PenggunaController::class, 'kodeArea']);
    Route::post('/kodepelanggan', [PengirimanController::class, 'kodePelanggan']);
    Route::post('/upload/pengiriman/{id_cabang}', [PengirimanController::class, 'uploadDataPengiriman']);
    Route::post('/listpengiriman/update_status', [PengirimanController::class, 'updateStatus']);
    Route::post('/show_fill/{id_cabang}', [PengirimanController::class, 'showFill']);
    Route::post('/show_fill_kondisi/{id_cabang}', [PengirimanController::class, 'showFillKondisi']);
    Route::post('/show_fill_all/{id_cabang}', [PengirimanController::class, 'showFillAll']);

    Route::get('/daftartugas/{id_cabang}', [TugasController::class, 'index'])->name('daftartugas');
});
