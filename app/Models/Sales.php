<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $fillable = [
        'nama',
        'telepon',
        'alamat',
        'status'
    ];

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class);
    }
}
