<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PembelianController;

// Halaman Utama (bisa nanti diarahkan ke dashboard)
Route::get('/', function () {
    return view('welcome');
});

// ==================== DASHBOARD ====================
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// ==================== MASTER DATA ==================

// Barang
Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
Route::get('/barang/{barang}/edit', [BarangController::class, 'edit'])->name('barang.edit');
Route::put('/barang/{barang}', [BarangController::class, 'update'])->name('barang.update');
Route::delete('/barang/{barang}', [BarangController::class, 'destroy'])->name('barang.destroy');
Route::get('/kategori/{kategori}/barang', [BarangController::class, 'showByCategory'])->name('barang.by_category');

// Kategori
Route::resource('/kategori', KategoriController::class);

// Supplier
Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
Route::delete('/supplier/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');

// ==================== TRANSAKSI ====================

// Penjualan
Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
Route::get('/penjualan/create', [PenjualanController::class, 'create'])->name('penjualan.create');
Route::post('/penjualan', [PenjualanController::class, 'store'])->name('penjualan.store');

// Rute API untuk pencarian produk oleh Javascript
Route::get('/api/products', [PenjualanController::class, 'fetchProducts'])->name('products.fetch');

// Pembelian
Route::resource('pembelian', PembelianController::class);

// ==================== LAPORAN ======================
Route::get('/laporan', function () {
    return "Halaman Laporan";
})->name('laporan.index');
