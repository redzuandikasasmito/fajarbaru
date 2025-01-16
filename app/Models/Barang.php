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

    public function DetailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'barang_id');
    }
    public function DetailPembelian()
    {
        return $this->hasMany(DetailPembelian::class, 'barang_id');
    }
    public function Stok()
    {
        return $this->hasOne(Stok::class, 'barang_id');
    }
}
