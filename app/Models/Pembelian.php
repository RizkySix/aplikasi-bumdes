<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'kode_pembelian';
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function produk(){
        return $this->hasMany(Produk::class);
    }
}
