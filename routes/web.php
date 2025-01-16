<?php

use App\Http\Controllers\BarangController;
use App\Models\Barang;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StokController;

Route::get('/', function () {
    return view('dashboard');
});

// Route for Barang
Route::get('/barang', function () {
    $barangs = Barang::all();
    return view('admin.barang', compact('barangs'));
});


//Route Barang
Route::resource('barang', BarangController::class);
Route::put('/barang/{barang}', [BarangController::class, 'updateBarang'])
    ->name('barang.updateBarang');

// Stok Routes
Route::resource('stok', StokController::class);

// Custom route for updating quantity
Route::put('/stok/{stok}/quantity', [StokController::class, 'updateQuantity'])
    ->name('stok.updateQuantity');
