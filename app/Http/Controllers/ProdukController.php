<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;
use App\Models\Barang;
use App\Models\Pembelian;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Pembelian $pembelian)
    {
        $pembelians = $pembelian::where('created_at' , session('date'));
        return view('dashboard.produk.create_produk', [
            "title" => "Beli Barang",
            "pembelian" => $pembelians->with('supplier')->get()

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProdukRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProdukRequest $request)
    {
        $validatedData = $request->validate([
            'pembelian_id' => 'required|numeric',
            'produk' => 'required',
            'qty' => 'required|integer',
            'harga_beli' => 'required',
        
          
        ]);

        $validatedData['harga_beli'] = "Rp ". $validatedData['harga_beli'];

        $barangs1 = Barang::all();
        foreach($barangs1 as $br1){
            if($br1->nama_barang != $request->produk && $br1->supplier_id != $request->supplier_id){
                $validatedData['dipasarkan'] = false;
            }else{
                $validatedData['dipasarkan'] = true;
            }
        }

      

        $trash = Produk::all();
        $valTrs = array();
        foreach($trash as $trs){
            if($trs->produk == $request->produk && $trs->pembelian_id == $request->pembelian_id){
                $valTrs[] = $trs->produk;
            }
        }
        $mff6 = session()->put('count', $valTrs);
        
        Produk::create($validatedData);
        $mtr = session()->put('dateProd', Carbon::now());
        $mff = session()->put('supp_id', $request->supplier_id);
        $mff2 = session()->put('produk', $request->produk);
        $mff3 = session()->put('pem_id', $request->pembelian_id);
        return redirect('/produk/transaksi');
    }


    public function produk(Request $request, Produk $produk)
    {
          $produks = $produk::where('created_at' , session('dateProd'));
        return view('dashboard.produk.view_produk',[
            "title" => "Total Harga Produk",
            "produks" => $produks->with('pembelian')->get()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function edit(Produk $produk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProdukRequest  $request
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProdukRequest $request, Produk $produk)
    {
        $validatedData = $request->validate([
            'total_beli' => 'required'
        ]);

        $pembelian = Pembelian::where('id' , $produk->pembelian_id)->get();
        foreach($pembelian as $beli){
            $bigTot = $beli->big_total ;
            $sisBay = $beli->sisa_bayar ;
        }
        $nilai = explode('.' , $validatedData['total_beli']);
        $nilai = implode('' , $nilai);

        $bigTot = explode(' ', $bigTot);
        $bigTot = end($bigTot);
        $bigTot = explode('.' , $bigTot);
        $bigTot = implode('' , $bigTot);

        $bigTot = $bigTot + $nilai;
        $bigTot = number_format($bigTot , 0);
        $bigTot = explode(',' , $bigTot);
        $bigTot = implode('.' , $bigTot);

        $bigTot = "Rp " . $bigTot;
        //////////////////////////
        $sisBay = explode(' ', $sisBay);
        $sisBay = end($sisBay);
        $sisBay = explode('.' , $sisBay);
        $sisBay = implode('' , $sisBay);

        $sisBay = $sisBay + $nilai;
        $sisBay = number_format($sisBay , 0);
        $sisBay = explode(',' , $sisBay);
        $sisBay = implode('.' , $sisBay);

        $sisBay = "Rp " . $sisBay;

      
        $validatedData['total_beli'] = "Rp " . $validatedData['total_beli'];
        
        $getBarangs = Barang::where('nama_barang' , $produk->produk)->where('supplier_id' , session('supp_id'))->get();
        if($getBarangs){
          foreach($getBarangs as $gbr){
            Barang::where('nama_barang' , $produk->produk)->where('supplier_id' , session('supp_id'))->update(['jumlah' => $gbr->jumlah + $produk->qty , 'sisa' => $gbr->sisa + $produk->qty]);

          }
        }

        $prod = Produk::all();
        foreach($prod as $prd){
            if(count(session('count')) >= 1 && $prd->produk == session('produk') && $prd->pembelian_id == session('pem_id')){
                Produk::where('id' , $prd->id)->update(['qty' => $prd->qty + $produk->qty]);
            }
        }

        $brgsAll = Barang::all();
        foreach($brgsAll as $all){
            if($all->nama_barang == $produk->produk && $all->supplier_id == session('supp_id')){
                $validatedData['dipasarkan'] = true;
            }else{
                $validatedData['dipasarkan'] = false;
            }
        }
        

       
        $trash = Produk::all();
        foreach($trash as $trs){
           
            if(count(session('count')) >= 1  && $trs->pembelian_id === $produk->pembelian_id){
               
                Produk::destroy('id' , $produk->id);
            }
        }
      

        Produk::where('id' , $produk->id)->update($validatedData);
        Barang::where('nama_barang' , $produk->produk)->where('supplier_id' , session('supp_id'))->update(['harga_beli' => $produk->harga_beli]);
        Pembelian::where('id' , $produk->pembelian_id)->update(['pembayaran' => 'Rp 0' , 'big_total' => $bigTot , 'sisa_bayar' => $sisBay]);
        $request->session()->forget('dateProd');
        $request->session()->forget('count');
        
        return redirect('/produk/create')->with('folks' , 'Produk Berhasil Ditambah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produk $produk, Pembelian $pembelian , Request $request)
    {
      
       
        $getBarangs = Barang::where('nama_barang' , $produk->produk)->where('supplier_id' , session('supp_id'))->get();
        foreach($getBarangs as $gbr){
            Barang::where('nama_barang' , $produk->produk)->where('supplier_id' , session('supp_id'))->update(['jumlah' => $gbr->jumlah - $produk->qty , 'sisa' => $gbr->sisa - $produk->qty]);
        }        
        Produk::destroy('id' , $produk->id);
        $request->session()->forget('supp_id');
        $request->session()->forget('produk');
        $request->session()->forget('pem_id');
       
        
     
        $trash2 = $produk::all();
        foreach($trash2 as $rat2){
         if($rat2->total_beli == 0){
           
            Produk::destroy('id' , $rat2->id);
         }
        }
       
        return redirect('/produk/create')->with('folks' , 'Produk Dibatalkan');

    }
}
