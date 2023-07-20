<?php

namespace App\Http\Controllers;

use App\Models\Retur;
use App\Http\Requests\StoreReturRequest;
use App\Http\Requests\UpdateReturRequest;
use App\Models\Barang;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReturController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Retur $retur)
    {
        $returs = $retur::orderBy('created_at' , 'DESC');
        $request->session()->forget('barang_!laku');
        if($request->search){
            $fil =  $request->search;
            $returs = $retur::wherehas('barang' , function($query) use ($fil) {
                $query->where('nama_barang' , 'like' , '%' . $fil . '%')->orWhere('kode_barang' , '=' , $fil);
            });
        }
        return view('dashboard.retur.view_retur', [
            "title" => "Daftar Retur Barang",
            "retur" => $returs->with('barang')->paginate(10)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Barang $barang)
    {
        $barangs = $barang::orderBy('created_at' , 'DESC');

        if($request->search){
            $barangs = $barang::where('nama_barang' , 'like' , '%' . $request->search . '%');
        }
        return view('dashboard.retur.create_retur', [
            "title" => "Buat Retur",
            "barang" => $barangs->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReturRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReturRequest $request , Barang $barang)
    {
        $validatedData = $request->validate([
            'tanggal_retur' => 'nullable|date', 
            'barang_id' => 'required|numeric',
            'jumlah' => 'required|numeric',
            'keterangan' => 'required|min:5'
        ]);

        if(!$validatedData['tanggal_retur']){
            $validatedData['tanggal_retur'] = Carbon::now();
        }


        $findSisa = $barang::where('id' , $validatedData['barang_id'])->get();
        foreach($findSisa as $sisa){
            $getSisa = $sisa->sisa;
        }
        $stok = $getSisa - $validatedData['jumlah'];

        if($getSisa < $validatedData['jumlah']){
            return back()->with('folks', 'Stok Barang Tidak Cukup');
        }

        Barang::where('id' , $validatedData['barang_id'])->update(['sisa' => $stok]);

        $getProduk = Barang::where('id' , $validatedData['barang_id'])->pluck('produk_id');
        Produk::where('id' , $getProduk[0])->update(['qty' => $stok]);
        Retur::create($validatedData);

        return redirect('/retur')->with('success', 'Retur Berhasil Dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Retur  $retur
     * @return \Illuminate\Http\Response
     */
    public function show(Retur $retur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Retur  $retur
     * @return \Illuminate\Http\Response
     */
    public function edit(Retur $retur , Barang $barang , Request $request)
    {
        $barangs = $barang::orderBy('created_at' , 'DESC');

        if($request->search){
            $barangs = $barang::where('nama_barang' , 'like' , '%' . $request->search . '%');
        }
        return view('dashboard.retur.edit_retur' , [
            "title" => "Edit Data Retur",
            "retur" => $retur,
            "barang" => $barangs->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReturRequest  $request
     * @param  \App\Models\Retur  $retur
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReturRequest $request, Retur $retur)
    {
        $validatedData = $request->validate([
            'tanggal_retur' => 'required|date', 
            'barang_id' => 'required|numeric',
            'jumlah' => 'required|numeric',
            'keterangan' => 'required|min:5'
        ]);

        $barang = Barang::where('id' , $retur->barang_id)->get();
        $newBarang = Barang::where('id' , $validatedData['barang_id'])->get();

        

        foreach($barang as $produk){
            $stok = $produk->sisa;
        }

        foreach($newBarang as $sisa){
            $newStok = $sisa->sisa;
        }

        $reStok = $stok;
     

        if($validatedData['barang_id'] != $retur->barang_id){

            $param = $newStok;
            $reStok = $stok + $retur->jumlah;
            $finalStok = $newStok - $validatedData['jumlah'];
        }


        if($validatedData['barang_id'] == $retur->barang_id){

            $sisaStok  = $newStok - $validatedData['jumlah'];
            $finalStok = $sisaStok + $retur->jumlah;
            $param = $newStok + $retur->jumlah;
        }

        if($param < $validatedData['jumlah']){
            return back()->with('folks', 'Stok Barang Tidak Cukup');
        }


        Barang::where('id' , $retur->barang_id)->update(['sisa' => $reStok]);
        Barang::where('id' , $validatedData['barang_id'])->update(['sisa' => $finalStok]);
        Retur::where('id' , $retur->id)->update($validatedData);


        return redirect('/retur')->with('success', 'Retur Berhasil Dirubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Retur  $retur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Retur $retur)
    {
        Retur::destroy('id' , $retur->id);
        return redirect('/retur')->with('success', 'Retur Berhasil Dihapus');
    }
}
