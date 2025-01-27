<?php

use App\Http\Controllers\BarangController;
use App\Models\Barang;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StokController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PenjualanController;

Route::get('/', function () {
    return view('index');
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
