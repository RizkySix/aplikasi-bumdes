<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PelangganTidakTerdaftarController extends Controller
{
    public function create(Request $request){

        $barang  = Barang::orderBy('created_at' , 'DESC');

        if($request->search){
            $barang = Barang::where('nama_barang' , 'like' , '%' . $request->search . '%');
        }

        return view('dashboard.penjualan.create_penjualan_!terdaftar' , [
            'title' => 'Penjualan Pelanggan Offline',
            'barang' => $barang->get()
        ]);
    }

    public function store(Request $request, Barang $barang){
        $validatedData = $request->validate([
            'tanggal_transaksi' => 'nullable|date',
            'pembeli' => 'required|string|min:3',
            'barang_id' => 'required|numeric',
            'note' => 'required|integer',
            'qty' => 'required|integer',
            'kode_penjualan' => 'nullable|unique:penjualans',
        ]);

        $validatedData['user_id'] = 666;

        if(!$request->tanggal_transaksi){
            $validatedData['tanggal_transaksi'] = Carbon::now();
        }

        $getBarang = $barang::where('id', $validatedData['barang_id'])->get();
        foreach($getBarang as $get){
            $value = $get->sisa;
        }
        if($value < $validatedData['qty']){
            return back()->with('folks', 'Stok Barang Tidak Cukup');
        }

        if($validatedData['note'] == 2){
            $request->validate([
             'qty' => 'required|integer|gt:1',
            ]);
         }

         $validatedData['petugas'] = auth()->user()->nama;

         $validatedData['kode_penjualan'] = fake()->swiftBicNumber();

         Penjualan::create($validatedData);
        session()->put('time', Carbon::now());
 
         return redirect('/penjualan/transaksi');
    }
}
