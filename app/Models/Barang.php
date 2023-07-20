<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'kode_barang';
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
    
    public function penjualan(){
        return $this->hasMany(Penjualan::class);
    }

    public function retur(){
        return $this->hasMany(Retur::class);
    }

    public function produk(){
        return $this->belongsTo(Produk::class);
    }

}
