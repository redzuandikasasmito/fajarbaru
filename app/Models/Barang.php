<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    //
    protected $table = 'barangs';
    protected $fillable = [
        'nama',
        'barcode',
        'harga_jual'
    ];
    public function purchaseDetails()
    {
        return $this->hasMany(DetailPembelian::class, 'barang_id');
    }

    // Relasi dengan tabel sale_details
    public function saleDetails()
    {
        return $this->hasMany(DetailPenjualan::class, 'barang_id');
    }

    // Relasi dengan tabel stock
    public function stock()
    {
        return $this->hasOne(Stok::class, 'barang_id');
    }
}
