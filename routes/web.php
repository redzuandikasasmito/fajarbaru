<?php

use App\Http\Controllers\BarangController;
use App\Models\Barang;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StokController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\SupplierController;

Route::get('/', function () {
    return view('dashboard');
});


// Route for Barang
Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/penjualan', function () {
    return view('pages.transaksi.penjualan');
});

Route::get('/barang-data', function () {
    return view('pages.data.data_barang');
});



//Route Barang
Route::resource('barang', BarangController::class);
Route::get('/api/barang/search', [BarangController::class, 'search'])->name('barang.search');

//Route Stok
Route::resource('stok', StokController::class)->except(['create', 'show', 'destroy']);
Route::get('/api/stok/search', [StokController::class, 'search'])->name('stok.search');

// routes/web.php
Route::resource('customer', CustomerController::class);
Route::get('/api/customer/search', [CustomerController::class, 'search'])->name('customer.search');

// routes/web.php
Route::resource('sales', SalesController::class);
Route::get('/api/sales/search', [SalesController::class, 'search'])->name('sales.search');

Route::resource('penjualan', PenjualanController::class);
Route::get('/api/penjualan/search-barang', [PenjualanController::class, 'searchBarang'])
    ->name('penjualan.search-barang');


// routes/web.php
Route::resource('supplier', SupplierController::class);
Route::get('/api/supplier/search', [SupplierController::class, 'search'])->name('supplier.search');


Route::resource('pembelian', PembelianController::class);
Route::post('/pembelian/store-barang', [PembelianController::class, 'storeBarang'])->name('pembelian.store-barang');




Route::get('/penjualan/create', [PenjualanController::class, 'create'])->name('penjualan.create');
Route::post('/penjualan/add-item', [PenjualanController::class, 'addItem'])->name('penjualan.add-item');
Route::post('/penjualan/update-item', [PenjualanController::class, 'updateItem'])->name('penjualan.update-item');
Route::post('/penjualan/remove-item', [PenjualanController::class, 'removeItem'])->name('penjualan.remove-item');

