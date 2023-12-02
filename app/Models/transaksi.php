<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    protected $table = 'transaksis';

    public $timestamps = true;

    protected $fillable = [
        'status',
    ];

    protected $guarder = [
        // 'code_transaksi',
        // 'total_qty',
        // 'total_harga',
        // 'nama_customer',
        // 'alamat',
        // 'no_tlp',
        // 'ekspedisi',
        // 'status',
    ];
    // protected $hidden;
}
