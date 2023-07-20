<?php

namespace App\Http\Controllers;

use App\Models\Konten;
use Illuminate\Http\Request;

class KontenController extends Controller
{
    public function konten()
    {
        $konten = Konten::all();
        return view('dashboard.konten.konten' , [
            "title" => "Konten",
            "konten" => $konten
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'pesan_penjualan' => 'nullable|string',
            'pesan_pembelian' => 'nullable|string',
            'pesan_stok' => 'nullable|string',
            'pesan_labarugi' => 'nullable|string',
            'pesan_login' => 'nullable|string',
        ]);


       $konten = Konten::all();
       if(!$konten->count()){
        Konten::create($validatedData);
        return back()->with('success' , 'Konten Berhasil Dibuat');
       }
       Konten::where('id' , 1)->update($validatedData);
        return back()->with('success' , 'Konten Berhasil Dibuat');
    }
}
