<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $table = 'products';
    public $timestamps = true;
    protected $guarded = [];
    // public function product()
    // {
    //     return $this->hasOne(tblCart::class, '', 'id');
    // }
}
