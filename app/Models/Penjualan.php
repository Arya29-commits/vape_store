<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $fillable = [
        'barang_id',
        'jumlah',
        'total_harga',
        'pelanggan',
        'tanggal',
    ];

    
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
