<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = 'penjualans';

    protected $fillable = [
        'customer_id',
        'sales_id',
        'total_penjualan',
        'status_pembayaran',
        'tanggal'
    ];

    protected $casts = [
        'tanggal' => 'datetime'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function sales()
    {
        return $this->belongsTo(Sales::class);
    }

    public function details()
    {
        return $this->hasMany(DetailPenjualan::class);
    }
}
