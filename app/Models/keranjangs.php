<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class keranjangs extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'idUser',
        'id_barang',
        'qty',
        'price',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(product::class, 'id_barang', 'id');
    }

    public function totalPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->price * $this->qty,
        );
    }
}
