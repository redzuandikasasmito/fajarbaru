<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    //
    protected $table = 'detail_penjualans';
    protected $fillable = [
        'penjualan_id',
        'barang_id',
        'harga_jual',
        'subtotal'
    ];
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
