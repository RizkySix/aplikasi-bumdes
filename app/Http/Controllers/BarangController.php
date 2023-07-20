<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Http\Requests\StoreBarangRequest;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateBarangRequest;
use App\Models\Konten;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\Retur;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PDF;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Barang $barang)
    {
        $barangs = $barang::orderBy('created_at', 'DESC');
        $request->session()->forget('barang_!laku');
        if($request->search){
            $barangs = $barang::where('nama_barang', 'like' , '%'.$request->search . '%')->orWhere('kode_barang' , '=', $request->search);
        }

        if($request->filter_barang == "b_laris"){
           $barangs = $barang::orderBy('terjual', 'DESC');
        }
        if($request->filter_barang == "b_!laris"){
           $barangs = $barang::orderBy('terjual', 'ASC');
        }
        if($request->filter_barang == "default"){
           $barangs = $barang::orderBy('created_at', 'DESC');
        }
        return view('dashboard.barang.view_barang', [
            "title" => "Data Barang",
            "barang" => $barangs->with('supplier')->paginate(10)->withQueryString()
        ]);
    }



    public function persediaan(Request $request, Barang $barang)
    {
        $barangs = $barang::orderBy('created_at', 'DESC');
        if($request->search){
            $barangs = $barang::where('nama_barang', 'like' , '%'.$request->search . '%')->orWhere('kode_barang' , '=', $request->search);
        }
  
        return view('dashboard.barang.persediaan', [
            "title" => "Data Barang",
            "barang" => $barangs->with('supplier')->paginate(10)->withQueryString()
        ]);
    }



    public function generate()
    {
        $barangs = Barang::orderBy('created_at' , 'DESC')->get();

        $ktn = "";
      $pesan = Konten::all();
      foreach($pesan as $psn){
       $ktn = $psn->pesan_stok;
      }
      if(!$ktn){
        
        $konten = "Tidak ada informasi laporan persediaan terbaru";
      }

      $konten = $ktn;

        $pdf = PDF::loadView('dashboard.barang.pdf_view', [
            "title" => "Data Barang",
            "barang" => $barangs,
            "konten" => $konten
        ]);

        $date = Carbon::now()->format('F'); //mengambil nama bulan saat ini contoh: dari 11 menjadi November
        return $pdf->download('laporan_persedian(' . $date . ').pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Supplier $supplier, Barang $barang)
    {
        $suppliers = $supplier::orderBy('created_at' , 'DESC');

        $produk = Produk::with(['pembelian', 'barang'])->where('total_beli' , '!=' , '0')->where('dipasarkan' , false)->latest();

        
        if($request->search){
            $suppliers = $supplier::where('nama_supplier' , 'like' , '%' . $request->search . '%');
        }
        return view('dashboard.barang.create_barang', [
            "title" => "Tambah Barang",
            "supplier" => $suppliers->get(),
            "produks" => $produk->get(),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBarangRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBarangRequest $request)
    {
        $validatedData = $request->validate([
            'supplier_id' => 'required|numeric',
            'produk_id' => 'required',
            'kode_barang' => 'nullable|unique:barangs',
            'harga_beli' => 'required|min:3|max:255',
            'harga_jual' => 'required|min:3|max:255',
            'jumlah' => 'required|integer',
            'sisa' => 'required|integer',
            'terjual' => 'nullable',
            'image' => 'nullable|image|file|max:2048',
            'petugas' => 'nullable'
        ]);

        $terjual = $validatedData['jumlah'] - $validatedData['sisa'];
        $validatedData['terjual'] = $terjual;

        $validatedData['terakhir_terjual'] = Carbon::now()->format('Y-m-d');

        $validatedData['kode_barang'] = fake()->swiftBicNumber();
        $validatedData['harga_beli'] = "Rp ".$validatedData['harga_beli'];
        $validatedData['harga_jual'] = "Rp ".$validatedData['harga_jual'];

        if(auth()->user()->role === 1){
            $validatedData['petugas'] = auth()->user()->nama;
        }

        $nameProduk = Produk::where('id' , $validatedData['produk_id'])->pluck('produk');

        $validatedData['nama_barang'] = $nameProduk[0];
       
        //upload gambar
        if($request->file('image')){
            $validatedData['image'] = $request->file('image')->store('produk-images');
        }

        Barang::create($validatedData);
        Produk::where('id' , $validatedData['produk_id'])->update(['qty' => $validatedData['sisa'] , 'dipasarkan' => true]);
        return redirect('/barang')->with('success', 'Barang Baru Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Supplier $supplier ,Barang $barang)
    {
        $suppliers = $supplier::orderBy('created_at' , 'DESC');
        if($barang->terakhir_terjual < date('Y-m-d' , strtotime('-1 months'))){
           session()->put('barang_!laku' , $barang->id);
        }

        if($request->search){
            $suppliers = $supplier::where('nama_supplier' , 'like' , '%' . $request->search . '%');
        }

        $request->session()->forget('param_sisa');
        $request->session()->forget('new_sisa');
        return view('dashboard.barang.edit_barang', [
            "title" => "Ubah Data Barang",
            "barang" => $barang,
            "supplier" => $suppliers->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBarangRequest  $request
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBarangRequest $request, Barang $barang)
    {
       $validatedData = $request->validate([
        'nama_barang' => 'required|min:2|max:255',
        'supplier_id' => 'required|numeric',
        'harga_beli' => 'required|min:3|max:255',
        'harga_jual' => 'required|min:3|max:255',
        'jumlah' => 'required|integer',
        'sisa' => 'required|integer',
        'terjual' => 'nullable',
        'image' => 'nullable|image|file|max:2048',
        'petugas' => 'nullable'
       ]);

       $margin = Retur::where('barang_id' , $barang->id)->get();

       $validatedData['terjual'] = $validatedData['jumlah'] - $validatedData['sisa'];
     
       foreach($margin as $mrg){
        if($barang->id == $mrg->barang_id){
            $validatedData['terjual'] = $validatedData['terjual'] - $mrg->jumlah;
        }
       }

       $validatedData['harga_beli'] = "Rp ".$validatedData['harga_beli'];
       $validatedData['harga_jual'] = "Rp ".$validatedData['harga_jual'];

       if(auth()->user()->role === 1){
        $validatedData['petugas'] = auth()->user()->nama;
    }

    //update tanggal terakhir penjualan jika terdapat barang yang terjual
    if($validatedData['terjual'] != 0){
        $validatedData['terakhir_terjual'] = Carbon::now()->format('Y-m-d');
    }

       //upload image
       if($request->file('image')){
        if($barang->image){
            Storage::delete($barang->image);
        }
        $validatedData['image'] = $request->file('image')->store('produk-images');
    }


       $penjualan = Penjualan::all();
        foreach($penjualan as $new){
          if($new->barang_id ==  $barang->id){
            Penjualan::where('barang_id' , $barang->id)->update(['nama_barang' => $validatedData['nama_barang']]);
          }
        }

        //set session param jika sisa barang sebelum diupdate bernilai 0
        if($request->param_sisa == 0){
            session()->put('param_sisa' , $request->param_sisa);
            session()->put('new_sisa' , $validatedData['sisa']);
            session()->put('alert' , true);
            session()->put('data_barang' , [$validatedData['nama_barang'] , $validatedData['supplier_id'] , $barang->id]);
        }


       Barang::where('id', $barang->id)->update($validatedData);
       Produk::where('id' , $barang->produk_id)->update(['qty' => $validatedData['sisa' ] ]);
       Produk::where('produk' , $barang->nama_barang)->update(['produk' => $validatedData['nama_barang' ] ]);
       return redirect('/barang')->with('success', 'Data Barang Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barang $barang)
    {
        $retur = Retur::where('barang_id', $barang->id)->get();
        foreach($retur as $trash){
            if($trash->barang_id == $barang->id){
                Retur::destroy('id' , $trash->id);
            }
        }
        
        $penjualan = Penjualan::all();
        foreach($penjualan as $new){
          if($new->barang_id ==  $barang->id){
            Penjualan::where('barang_id' , $barang->id)->update(['barang_id' => 0]);
          }
        }

        if($barang->image){
            Storage::delete($barang->image);
          }
        Barang::destroy($barang->id);
        Produk::where('id' , $barang->produk_id)->update(['dipasarkan' => false]);
        return redirect('/barang')->with('success', 'Data Barang Berhasil Dihapus');
    }

/* 
    public function api_barang()
    {
        return response()->json([
            'message' => 'Data barang',
            'status' => true,
            'barang' => Barang::latest()->get()
        ], 200);
    } */
}
