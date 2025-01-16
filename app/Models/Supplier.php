<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //
    protected $table = 'suppliers';
    protected $fillable = [
        'nama',
        'alamat',
        'no_telp'
    ];


    public function DetailPembelian()
    {
        return $this->hasMany(DetailPembelian::class, 'supplier_id');
    }

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'supplier_id');
    }
}
