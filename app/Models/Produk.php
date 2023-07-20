<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function pembelian(){
        return $this->belongsTo(Pembelian::class);
    }

    public function barang(){
        return $this->hasOne(Barang::class);
    }


}
