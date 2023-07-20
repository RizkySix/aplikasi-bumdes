<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GrafikController;
use App\Http\Controllers\KontenController;
use App\Http\Controllers\LabaRugiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PelangganTidakTerdaftarController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReturController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TahunController;
use App\Http\Controllers\UserController;
use App\Models\Penjualan;
use Database\Factories\PenjualanFactory;

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

Route::get('/', [LoginController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/dashboard', [DashboardController::class, 'view_dashboard'])->middleware('auth');
Route::get('/users/checkSlug', [UserController::class, 'checkSlug']);
Route::get('/users/pelanggan', [UserController::class, 'pelanggan'])->name('pelanggan')->middleware('auth');
Route::get('/totaljual', [PenjualanController::class, 'total_jual'])->middleware('auth');
Route::get('/totalbeli', [PembelianController::class, 'total_beli'])->middleware('auth');
Route::get('/pesanantotal', [PenjualanController::class, 'total_pesan'])->name('allpesanan')->middleware(['auth' , 'petugas']);
Route::get('/pesanantotal/{kode_penjualan}', [PenjualanController::class, 'detail_pesan'])->name('pesanantotal')->middleware(['auth' , 'petugas']);
Route::get('/totaljual/{kode_penjualan}', [PenjualanController::class, 'detail_total'])->middleware('auth');
Route::get('/totalbeli/{kode_pembelian}', [PembelianController::class, 'detail_total'])->middleware('auth');
Route::get('/penjualan/transaksi', [PenjualanController::class, 'penjualan'])->name('transaksi')->middleware(['auth' , 'res_penjualan', 'petugas']);
Route::get('/produk/transaksi', [ProdukController::class, 'produk'])->name('produk')->middleware(['auth' , 'res_produk', 'petugas']);

Route::get('/penjualan_offline' , [PelangganTidakTerdaftarController::class, 'create'])->middleware(['auth' , 'petugas'])->name('pelanggan_!terdaftar');
Route::post('/penjualan_offline' , [PelangganTidakTerdaftarController::class  , 'store'])->middleware(['auth' , 'petugas'])->name('store_pelanggan_!terdaftar');

Route::get('/sesi_tahun/{tahun}' , [TahunController::class , 'riwayat'])->middleware(['auth' , 'petugas'])->name('riwayat');

Route::get('/persediaan' , [BarangController::class , 'persediaan'])->middleware(['auth' , 'pimpinan']);
Route::get('/persediaan/generatePDF' , [BarangController::class , 'generate'])->middleware(['auth' , 'pimpinan']);

Route::get('/laporanjual/generatePDF' , [PenjualanController::class , 'generate'])->middleware(['auth' , 'pimpinan']);
Route::get('/laporanbeli/generatePDF' , [PembelianController::class , 'generate'])->middleware(['auth' , 'pimpinan']);

Route::get('/labarugi' , [LabaRugiController::class , 'create'])->middleware(['auth' , 'pimpinan']);
Route::get('/labarugi/final' , [LabaRugiController::class , 'generate'])->middleware(['auth' , 'pimpinan']);

Route::get('/pelanggan/pesan' , [PelangganController::class , 'pesan'])->middleware(['auth' , 'pelanggan']);
Route::get('/pelanggan/create' , [PelangganController::class , 'transaksi'])->middleware(['auth' , 'pelanggan']);
Route::post('/pelanggan/transaksi' , [PelangganController::class , 'store'])->middleware(['auth' , 'pelanggan']);
Route::get('/pelanggan/totalpesan' , [PelangganController::class , 'all_pesanan'])->middleware(['auth' , 'pelanggan']);
Route::get('/pelanggan/pesanan/{kode_penjualan}' , [PelangganController::class , 'detail'])->middleware(['auth' , 'pelanggan']);

Route::resource('/users', UserController::class)->except('show')->middleware(['auth', 'petugas']);
Route::resource('/barang', BarangController::class)->except('show')->middleware(['auth', 'petugas']);
Route::resource('/suppliers', SupplierController::class)->except('show')->middleware(['auth', 'petugas']);
Route::resource('/penjualan', PenjualanController::class)->except('show')->middleware(['auth', 'petugas']);
Route::resource('/pembelian', PembelianController::class)->except('show')->middleware(['auth', 'petugas']);
Route::resource('/produk', ProdukController::class)->except('show')->middleware(['auth', 'petugas']);
Route::resource('/retur', ReturController::class)->except('show')->middleware(['auth', 'petugas']);

Route::get('/register' , [RegisterController::class, 'view_register'])->middleware('guest');
Route::post('/register' , [RegisterController::class, 'store']);

Route::put('/updateprofile/{id}' , [UserController::class, 'update_profile'])->middleware('auth');
Route::get('/konten' , [KontenController::class, 'konten'])->middleware(['auth', 'petugas']);
Route::put('/konten/store' , [KontenController::class, 'store'])->middleware(['auth', 'petugas']);


Route::get('/grafikjual' , [GrafikController::class , 'grafik_penjualan'])->middleware(['auth' , 'pimpinan']);
Route::get('/grafikbeli' , [GrafikController::class , 'grafik_pembelian'])->middleware(['auth' , 'pimpinan']);
Route::get('/grafikbarang' , [GrafikController::class , 'grafik_barang'])->middleware(['auth' , 'pimpinan']);

Route::get('notajual/{kode_penjualan}' , [PelangganController::class , 'nota_jual'])->middleware(['auth']);

Route::get('/send_email' , [MailController::class , 'email'])->middleware('auth');