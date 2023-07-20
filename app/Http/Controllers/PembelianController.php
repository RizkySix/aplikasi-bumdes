<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Http\Requests\StorePembelianRequest;
use App\Http\Requests\UpdatePembelianRequest;
use App\Models\Barang;
use App\Models\Konten;
use App\Models\Produk;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use PDF;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Pembelian $pembelian)
    {
        $carbon1 = date('Y-m-d H:i:s' , strtotime($request->search));
        $carbon2 = date('Y-m-d H:i:s' , strtotime('+23 hours +59 minutes' , strtotime($request->search2)));
        $pembelians = $pembelian::where('pembayaran', '!=' , null)->orWhere('pembayaran', 'like' , '%' . 'Rp' . '%')->orderBy('tanggal_transaksi', 'DESC');

        if($request->search && $request->search2){
            $pembelians = $pembelian::whereBetween('tanggal_transaksi', [$carbon1 , $carbon2])->where('pembayaran', '!=' , null)->orderBy('tanggal_transaksi', 'DESC');
        }

        if($request->search && !$request->search2){
            $pembelians = $pembelian::where('tanggal_transaksi' , 'like' , '%' . $request->search . '%')->where('pembayaran', '!=' , null)->orderBy('tanggal_transaksi', 'DESC');
        }

        if($request->search2 && !$request->search){
            $pembelians = $pembelian::where('tanggal_transaksi' , 'like' , '%' . $request->search2 . '%')->where('pembayaran', '!=' , null)->orderBy('tanggal_transaksi', 'DESC');
        }

        $request->session()->forget('tgl_fix');
       return view('dashboard.pembelian.view_pembelian', [
            "title" => "All Pembelian",
            "pembelian" => $pembelians->with('supplier')->paginate(10)->withQueryString()
       ]);
    }



    public function total_beli(Request $request, Pembelian $pembelian)
    {
        $carbon1 = date('Y-m-d H:i:s' , strtotime($request->search));
        $carbon2 = date('Y-m-d H:i:s' , strtotime('+23 hours +59 minutes' , strtotime($request->search2)));
       //untuk petugas
       if(auth()->user()->role === 1)
       {
        $pembelians = $pembelian::where('status', '=' , 1)->where('pembayaran', 'like' , '%' . 'Rp' . '%')->orderBy('tanggal_transaksi', 'DESC');

        if($request->search && $request->search2){
            $pembelians = $pembelian::whereBetween('tanggal_transaksi', [$carbon1 , $carbon2])->where('pembayaran', '!=' , null)->where('status', '=' , 1)->orderBy('tanggal_transaksi' , 'DESC');
        }

        if($request->search && !$request->search2){
            $pembelians = $pembelian::where('tanggal_transaksi' , 'like' , '%' . $request->search . '%')->where('pembayaran', '!=' , null)->where('status', '=' , 1)->orderBy('tanggal_transaksi' , 'DESC');
        }

        if($request->search2 && !$request->search){
            $pembelians = $pembelian::where('tanggal_transaksi' , 'like' , '%' . $request->search2 . '%')->where('pembayaran', '!=' , null)->where('status', '=' , 1)->orderBy('tanggal_transaksi' , 'DESC');
        }
       }

       //untuk pimpinan
       if(auth()->user()->role === 2)
       {
        $pembelians = $pembelian::where('pembayaran', '!=' , null)->orWhere('pembayaran', 'like' , '%' . 'Rp' . '%')->orderBy('tanggal_transaksi', 'DESC');

        if($request->search && $request->search2){
            $pembelians = $pembelian::whereBetween('tanggal_transaksi', [$carbon1 , $carbon2])->where('pembayaran', '!=' , null)->orderBy('tanggal_transaksi', 'DESC');

            $request->session()->forget('beli1');
            $request->session()->forget('beli2');

            $bel1 = session()->put('beli1' , $carbon1);
            $bel2 = session()->put('beli2' , $carbon2);
        }

        if($request->search && !$request->search2){
            $pembelians = $pembelian::where('tanggal_transaksi' , 'like' , '%' . $request->search . '%')->where('pembayaran', '!=' , null)->orderBy('tanggal_transaksi', 'DESC');
            
            $request->session()->forget('beli1');
            $request->session()->forget('beli2');
    
            $bel1 = session()->put('beli1' , $request->search);
        }

        if($request->search2 && !$request->search){
            $pembelians = $pembelian::where('tanggal_transaksi' , 'like' , '%' . $request->search2 . '%')->where('pembayaran', '!=' , null)->orderBy('tanggal_transaksi', 'DESC');
            
            $request->session()->forget('beli1');
            $request->session()->forget('beli2');

            $bel2 = session()->put('beli2' , $request->search2);
        }
       }

        return view('dashboard.pembelian.total_beli' , [
             "title" => "Total Pembelian",
             "pembelian" => $pembelians->with('supplier')->paginate(10)->withQueryString()
        ]);
    }



    public function generate()
    {

       if(session('beli1') && session('beli2')){
        $pembelians = Pembelian::whereBetween('tanggal_transaksi' , [session('beli1') , session('beli2')])->where('pembayaran' , '!=' , null)->orderBy('tanggal_transaksi' , 'DESC')->get();
       }
       if(session('beli1') && !session('beli2')){
        $pembelians = Pembelian::Where('tanggal_transaksi' , 'like' , '%' . session('beli1') . '%')->where('pembayaran' , '!=' , null)->orderBy('tanggal_transaksi' , 'DESC')->get();
       }
       if(session('beli2') && !session('beli1')){
        $pembelians = Pembelian::Where('tanggal_transaksi' , 'like' , '%' . session('beli2') . '%')->where('pembayaran' , '!=' , null)->orderBy('tanggal_transaksi' , 'DESC')->get();
       }
       

        $ktn = "";
        $pesan = Konten::all();
        foreach($pesan as $psn){
         $ktn = $psn->pesan_pembelian;
        }
        if(!$ktn){
          
          $konten = "Tidak ada informasi laporan pembelian terbaru";
        }
  
        $konten = $ktn;
        $pdf = PDF::loadView('dashboard.pembelian.pdf_view', [
            "title" => "Laporan Pembelian",
            "pembelian" => $pembelians,
            "allPembelian" => Produk::all(),
            "konten" => $konten
        ]);

       if(session('beli1') && session('beli2')){
            $date1 = date('d-M-Y' , strtotime(session('beli1')));
            $date2 = date('d-M-Y' , strtotime(session('beli2')));

            return $pdf->download('laporan_pembelian(' . $date1 . '-' . 'sampai' . '-' . $date2 . ').pdf');
       }
       if(session('beli1') && !session('beli2')){
            $date1 = date('d-M-Y' , strtotime(session('beli1')));
            return $pdf->download('laporan_pembelian(' . $date1 . ').pdf');
       }
       if(session('beli2') && !session('beli1')){
            $date2 = date('d-M-Y' , strtotime(session('beli2')));
            return $pdf->download('laporan_pembelian(' . $date2 . ').pdf');
       }

       if(!session('beli1') && !session('beli2')){
        return $pdf->download('laporan_pembelian.pdf');
   }
       
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Supplier $supplier, Request $request)
    {
        $suppliers = $supplier::orderBy('created_at', 'DESC');
        if($request->search){
            $suppliers = $supplier::where('nama_supplier', 'like' , '%' . $request->search . '%');
        }
        return view('dashboard.pembelian.create_pembelian',[
            "title" => "Buat Pembelian",
            "supplier" => $suppliers->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePembelianRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePembelianRequest $request)
    {
       $validatedData = $request->validate([
            'tanggal_transaksi' => 'nullable|date',
            'supplier_id' => 'required|numeric',
            'kode_pembelian' => 'nullable|unique:pembelians',
           
       ]);

       if($validatedData['tanggal_transaksi'] == null){
        $validatedData['tanggal_transaksi'] = Carbon::now();
       }

       session()->put('tgl_fix', Carbon::parse($validatedData['tanggal_transaksi'])->format('Y-m-d'));
    
       $validatedData['big_total'] = "Rp 0";
       $validatedData['sisa_bayar'] = "Rp 0";
       $validatedData['kode_pembelian'] = fake()->swiftBicNumber();

       $getSupp = Supplier::where('id' , $validatedData['supplier_id'])->pluck('nama_supplier');
       $validatedData['nama_supplier'] = $getSupp[0];


       Pembelian::create($validatedData);
        $prm = session()->put('date', Carbon::now());
        return redirect('/produk/create');
     
    }

   

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function show(Pembelian $pembelian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function edit(Pembelian $pembelian, Produk $produk)
    {
        $allPembelian = Produk::where('pembelian_id' , $pembelian->id)->where('total_beli' , '!=' , '0')->where('total_beli', '!=' , 'Rp 0');
        return view('dashboard.pembelian.edit_pembelian',[
            "title" => "Edit Pembelian",
            "pembelian" => $pembelian,
            "allPembelian" => $allPembelian->get()
        ]);
    }




    public function detail_total(Pembelian $pembelian, Request $request)
    {
        $pembelians = $pembelian::where('kode_pembelian' , $request->kode_pembelian)->get();
        foreach($pembelians as $getId){
            $theId = $getId->id;
        }

        $allPembelian = Produk::where('pembelian_id' , $theId);
        return view('dashboard.pembelian.detail_total',[
            "title" => "Detail Pembelian",
            "pembelians" => $pembelians,
            "allPembelian" => $allPembelian->get(),
            "ID" => $theId
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePembelianRequest  $request
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePembelianRequest $request, Pembelian $pembelian)
    {

            $validatedData = $request->validate([
                'big_total' => 'nullable',
                'pembayaran' => 'nullable',
                'nota' => 'image|file|max:2048' 
            ]);

            if($pembelian->status == 1){
                $validatedData['big_total'] = $pembelian->big_total;
                $validatedData['pembayaran'] = $pembelian->pembayaran;
                $status =  $pembelian->status;
            }else{
                
                $getSis = explode(' ', $pembelian->pembayaran);
                $fend = end($getSis);
                $moreSis = explode('.' , $fend);
                $moreSis2 = implode('' , $moreSis);
    
                $findBay = explode('.' , $validatedData['pembayaran']);
                $findBay = implode('' , $findBay);
    
                $sisaBayar  = $moreSis2 + $findBay;
    
                $format = number_format($sisaBayar , 0);
                $format = explode(',' , $format);
                $formatBayar = implode('.' , $format);
    
                $bigTot = explode('.' , $validatedData['big_total']);
                $bigTot = implode('' , $bigTot);
    
                $status = 666;
                if($sisaBayar >= $bigTot){
                    $status = 1;
                    $total_sisa = 0;
                }else{
                    $status = 0;
                    $total_sisa = $bigTot - $sisaBayar;
                }

                $total_sisa = number_format($total_sisa , 0);
                $total_sisa = explode(',' ,$total_sisa);
                $total_sisa = implode('.' ,$total_sisa);
      
                $total_sisa = "Rp " .$total_sisa;

                $validatedData['big_total'] = "Rp " . $validatedData['big_total'];
                $validatedData['pembayaran'] = "Rp " . $formatBayar;
           
    
            }

           
            //upload gambar
            if($request->file('nota')){
                if($pembelian->nota){
                    Storage::delete($pembelian->nota);
                }
                $validatedData['nota'] = $request->file('nota')->store('nota-images');
            }

            Pembelian::where('id' , $pembelian->id)->update($validatedData);
            Pembelian::where('id' , $pembelian->id)->update(['status' => $status , 'sisa_bayar' => $total_sisa]);

        return redirect('/pembelian')->with('success', 'Pembelian Berhasil Dirubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pembelian $pembelian)
    {
        $trash = Produk::all();
        foreach($trash as $rat){
            if($rat->pembelian_id == $pembelian->id){
                Produk::destroy('id' , $rat->id);
            }
        }
        if($pembelian->nota){
            Storage::delete($pembelian->nota);
        }
        Pembelian::destroy('id' , $pembelian->id);

        return redirect('/pembelian')->with('success', 'Pembelian Berhasil Dibatalkan');
    }
}
