<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    //
    protected $table = 'pembelians';
    protected $fillable = [
        'supppier_id',
        'nomor_nota',
        'tanggal',
        'total_pembelian',
        'status_pembayaran'

    ];
    public function DetailPembelian()
    {
        return $this->hasMany(DetailPembelian::class, 'id_pembelian');
    }
}
