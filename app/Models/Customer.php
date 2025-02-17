<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'nama',
        'telepon',
        'alamat'
    ];

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class);
    }
}
