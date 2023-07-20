<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Http\Requests\StorePenjualanRequest;
use App\Http\Requests\UpdatePenjualanRequest;
use App\Models\Barang;
use App\Models\Konten;
use App\Models\Produk;
use App\Models\Tahun;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use PDF;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Penjualan $penjualan)
    {
        $penjualans = $penjualan::where('total', '!=', 0)->orWhere('total', 'like' ,'%' . 'Rp' . '%')->where('detail' , '!=' , 'Dipesan')->orderBy('tanggal_transaksi', 'DESC');

        $carbon1 = date('Y-m-d H:i:s' , strtotime($request->search));
        $carbon2 = date('Y-m-d H:i:s' , strtotime('+23 hours +59 minutes' , strtotime($request->search2)));

        if($request->search && $request->search2){
            $penjualans = $penjualan::whereBetween('tanggal_transaksi', [$carbon1 , $carbon2])->where('total', '!=' , '0')->where('detail' , '!=' , 'Dipesan')->orderBy('tanggal_transaksi', 'DESC');
        }

        if($request->search && !$request->search2){
            $penjualans = $penjualan::where('tanggal_transaksi' , 'like' , '%' . $request->search . '%')->where('total', '!=' , '0')->where('detail' , '!=' , 'Dipesan')->orderBy('tanggal_transaksi', 'DESC');
        }

        if($request->search2 && !$request->search){
            $penjualans = $penjualan::where('tanggal_transaksi' , 'like' , '%' . $request->search2 . '%')->where('total', '!=' , '0')->where('detail' , '!=' , 'Dipesan')->orderBy('tanggal_transaksi', 'DESC');
        }

        //filter penjualan berdsarkan bulan transaksi (gunakan fungsi whereRaw untuk hanya mengambil bulan dari tanggal transaksi)
        $totalData = 0;
        if($request->bulan && $request->bulan != "00"){
            $penjualans = $penjualan::whereRaw('MONTH(tanggal_transaksi) = '. $request->bulan)->where('total', '!=' , '0')->where('detail' , '!=' , 'Dipesan')->orderBy('tanggal_transaksi', 'DESC');

            $totalData = $penjualan::whereRaw('MONTH(tanggal_transaksi) = '. $request->bulan)->count();
        }
        return view('dashboard.penjualan.view_penjualan', [
            "title" => "Data Penjualan",
            "penjualan" => $penjualans->with(['barang' , 'user'])->paginate(10)->withQueryString(),
            "totalData" => $totalData,
            "tahuns" => Tahun::all()
        ]);
    }


    public function total_jual(Request $request, Penjualan $penjualan)
    {
    
        $carbon1 = date('Y-m-d H:i:s' , strtotime($request->search));
        $carbon2 = date('Y-m-d H:i:s' , strtotime('+23 hours +59 minutes' , strtotime($request->search2)));
        //untuk petugas
       if(auth()->user()->role === 1)
       {
        $penjualans = $penjualan::where('status' , '=' , 1)->where('detail' , '=' , 'selesai')->orderBy('tanggal_transaksi' , 'DESC');

        if($request->search && $request->search2){
            $penjualans = $penjualan::whereBetween('tanggal_transaksi', [$carbon1 , $carbon2])->where('total', '!=' , '0')->where('status' , '=' , 1)->orderBy('tanggal_transaksi' , 'DESC');
        }

        if($request->search && !$request->search2){
            $penjualans = $penjualan::where('tanggal_transaksi' , 'like' , '%' . $request->search . '%')->where('total', '!=' , '0')->where('status' , '=' , 1)->orderBy('tanggal_transaksi' , 'DESC');
        }

        if($request->search2 && !$request->search){
            $penjualans = $penjualan::where('tanggal_transaksi' , 'like' , '%' . $request->search2 . '%')->where('total', '!=' , '0')->where('status' , '=' , 1)->orderBy('tanggal_transaksi' , 'DESC');
        }
       }


       //untuk pimpinan
       if(auth()->user()->role === 2)
       {
        $penjualans = $penjualan::where('total', '!=', 0)->orWhere('total', 'like' ,'%' . 'Rp' . '%')->where('detail' , '!=' , 'Dipesan')->orderBy('tanggal_transaksi', 'DESC');

        if($request->search && $request->search2){
            $penjualans = $penjualan::whereBetween('tanggal_transaksi', [$carbon1 , $carbon2])->where('total', '!=' , '0')->where('detail' , '!=' , 'Dipesan')->orderBy('tanggal_transaksi', 'DESC');

            $request->session()->forget('src1');
            $request->session()->forget('src2');

            $sespen1 = session()->put('src1' , $carbon1);
            $sespen2 = session()->put('src2' ,$carbon2);
        }

        if($request->search && !$request->search2){
            $penjualans = $penjualan::where('tanggal_transaksi' , 'like' , '%' . $request->search . '%')->where('total', '!=' , '0')->where('detail' , '!=' , 'Dipesan')->orderBy('tanggal_transaksi', 'DESC');

            $request->session()->forget('src1');
            $request->session()->forget('src2');

            $sespen1 = session()->put('src1' , $request->search);
        }

        if($request->search2 && !$request->search){
            $penjualans = $penjualan::where('tanggal_transaksi' , 'like' , '%' . $request->search2 . '%')->where('total', '!=' , '0')->where('detail' , '!=' , 'Dipesan')->orderBy('tanggal_transaksi', 'DESC');
           
            $request->session()->forget('src1');
            $request->session()->forget('src2');

            $sespen2 = session()->put('src2' , $request->search2);
        }
       }
        return view('dashboard.penjualan.total_jual' , [
            "title" => "Total Penjualan",
            "penjualan" =>  $penjualans->with(['barang' , 'user'])->paginate(10)->withQueryString()
        ]);
    }

    public function generate(Request $request, Penjualan $penjualan)
    {
        if(session('src1') && session('src2')){
            $penjualans = $penjualan::whereBetween('tanggal_transaksi', [session('src1') ,session('src2')])->where('total', '!=' , '0')->where('detail' , '!=' , 'Dipesan')->orderBy('tanggal_transaksi' , 'DESC');
        }
        if(session('src1') && !session('src2')){
            $penjualans = $penjualan::Where('tanggal_transaksi' , 'like' , '%' . session('src1') . '%')->where('total', '!=' , '0')->where('detail' , '!=' , 'Dipesan')->orderBy('tanggal_transaksi' , 'DESC');
        }
        if(session('src2') && !session('src1')){
            $penjualans = $penjualan::Where('tanggal_transaksi' , 'like' , '%' . session('src2') . '%')->where('total', '!=' , '0')->where('detail' , '!=' , 'Dipesan')->orderBy('tanggal_transaksi' , 'DESC');
        }
        


        $ktn = "";
      $pesan = Konten::all();
      foreach($pesan as $psn){
       $ktn = $psn->pesan_penjualan;
      }
      if(!$ktn){
        
        $konten = "Tidak ada informasi laporan penjualan terbaru";
      }

      $konten = $ktn;
        $pdf = PDF::loadView('dashboard.penjualan.pdf_view', [
            "title" => "Laporan Penjualan",
            "penjualan" => $penjualans->get(),
            "konten" => $konten
        ]);


       if(session('src1') && session('src2')){
        $date1 = date('d-M-Y' , strtotime(session('src1')));
        $date2 = date('d-M-Y' , strtotime(session('src2')));
        return $pdf->download('laporan_penjualan('. $date1 . '-' . 'sampai' . '-' . $date2 . ').pdf');

       }
       if(session('src1') && !session('src2')){
        $date1 = date('d-M-Y' , strtotime(session('src1')));
        return $pdf->download('laporan_penjualan('. $date1 . ').pdf');

       }
       if(session('src2') && !session('src1')){
        $date2 = date('d-M-Y' , strtotime(session('src2')));
        return $pdf->download('laporan_penjualan('. $date2 . ').pdf');

       }

       if(!session('src1') && !session('src2')){
       
        return $pdf->download('laporan_penjualan.pdf');

       }
        
    }



    public function total_pesan(Request $request, Penjualan $penjualan)
    {
        $carbon1 = date('Y-m-d H:i:s' , strtotime($request->search));
        $carbon2 = date('Y-m-d H:i:s' , strtotime('+23 hours +59 minutes' , strtotime($request->search2)));
        $penjualans = $penjualan::where('detail' , '=' , 'dipesan')->orderBy('tanggal_transaksi' , 'DESC');

        if($request->search && $request->search2){
            $penjualans = $penjualan::whereBetween('tanggal_transaksi', [$carbon1 , $carbon2])->where('detail' , '=' , 'dipesan')->orderBy('tanggal_transaksi' , 'DESC');
        }

        if($request->search && !$request->search2){
            $penjualans = $penjualan::where('tanggal_transaksi' , 'like' , '%' . $request->search . '%')->where('detail' , '=' , 'dipesan')->orderBy('tanggal_transaksi' , 'DESC');
        }

        if($request->search2 && !$request->search){
            $penjualans = $penjualan::where('tanggal_transaksi' , 'like' , '%' . $request->search2 . '%')->where('detail' , '=' , 'dipesan')->orderBy('tanggal_transaksi' , 'DESC');
        }

        session()->put('pesan' , Route::current()->getName());

        return view('dashboard.penjualan.total_pesan' , [
            "title" => "Total Penjualan",
            "penjualan" =>  $penjualans->with(['barang' , 'user'])->paginate(10)->withQueryString()
        ]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, User $user, Barang $barang)
    {
        $users = $user::orderBy('created_at', 'DESC');
        $barangs = $barang::orderBy('created_at', 'DESC');

        if($request->search){
            $users = $user::where('nama', 'like' , '%' . $request->search . '%');
        }

        $request->session()->forget('pesan');
       return view('dashboard.penjualan.create_penjualan' , [
            "title" => "Tambah Data Penjualan",
            "user" => $users->get(),
            "barang" => $barangs->get()
       ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePenjualanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePenjualanRequest $request, Barang $barang)
    {
        $validatedData = $request->validate([
            'tanggal_transaksi' => 'nullable|date',
            'user_id' => 'required|numeric',
            'barang_id' => 'required|numeric',
            'note' => 'required|integer',
            'qty' => 'required|integer',
            'kode_penjualan' => 'nullable|unique:penjualans',
            'petugas' => 'nullable'   
        ]);

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

        if($validatedData['tanggal_transaksi'] == null){
            $validatedData['tanggal_transaksi'] = Carbon::now();
           }

        if(auth()->user()->role == 1){
            $validatedData['petugas'] = auth()->user()->nama;
        }


        $validatedData['kode_penjualan'] = fake()->swiftBicNumber();

        Penjualan::create($validatedData);
       
        $param = session()->put('time', Carbon::now());

          //menambah sesi tahunan penjualan #numpangdicontrollerpenjualan
        
          $hanya_tahun = Carbon::parse($validatedData['tanggal_transaksi'])->format('Y');
          $getTahun = Tahun::where('tahun' , $hanya_tahun)->count();

          if($getTahun == 0 ){
            Tahun::create(['tahun' => $hanya_tahun]);
          }
        
          /////////////////////////////////////////////////////////////////
       
        return redirect('/penjualan/transaksi');
    }


    public function penjualan(Request $request, Barang $barang, Penjualan $penjualan){
        $penjualans = $penjualan::where('created_at', session('time'));
        $uerl = session()->put('uerl', Route::current()->getName());
        return view('dashboard.penjualan.view_transaksi', [
            "title" => "Final Trade",
            "penjualans" => $penjualans->with(['barang' , 'user'])->get(),
            "uerl" => $uerl 
        ]);
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function show(Penjualan $penjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Barang $barang, Penjualan $penjualan)
    {
        $uerl = session()->put('uerl', Route::current()->getName());
        $alrt = session()->put('alert', Route::current()->getName());
        return view('dashboard.penjualan.edit_penjualan', [
            "title" => "Edit Penjualan",
            "penjualan" => $penjualan,
            "uerl" => $uerl
        ]);
    }



    public function detail_total(Request $request, Barang $barang, Penjualan $penjualan)
    {

        $penjualans = $penjualan::where('kode_penjualan' , $request->kode_penjualan);
        return view('dashboard.penjualan.detail_total', [
            "title" => "Detail Penjualan",
            "penjualans" => $penjualans->get()
        ]);
    }

    public function detail_pesan(Request $request, Penjualan $penjualan)
    {
        $alrt = session()->put('alert', Route::current()->getName());
        $penjualans = $penjualan::where('kode_penjualan' , $request->kode_penjualan);
        return view('dashboard.penjualan.detail_total', [
            "title" => "Detail Pesanan",
            "penjualans" => $penjualans->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePenjualanRequest  $request
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePenjualanRequest $request, Penjualan $penjualan, Barang $barang)
    {

        if(session('uerl') == 'penjualan.edit' || session('alert') == 'pesanantotal'){
            $validatedData = $request->validate([
                'pembayaran' => 'nullable',
                'detail' => 'nullable|string',
                'pengirim' => 'nullable',
                'sisa_bayar' => 'string',
                'petugas' => 'nullable',
                'bukti_gambar' => 'nullable|image|file|max:2048'
            ]);
          
            $findSisa = $penjualan->pembayaran;
            $cutSisa = explode(' ', $findSisa);
            $gotit = end($cutSisa);
            $newExp = explode('.', $gotit);
            $imp = implode('', $newExp);


            $findTot = $penjualan->total;
            $cutTot = explode(' ', $findTot);
            $gotot = end($cutTot);
            $newTot = explode('.', $gotot);
            $impos = implode('', $newTot);

            if($validatedData['pembayaran'] == null){
                $validatedData['pembayaran'] = 0;
            }
            
            if($request->detail){
                $detail = $validatedData['detail'];
            }else{
                $detail = "Selesai";
            }

            if($request->pengirim){
                $pengirim = $validatedData['pengirim'];
            }else{
                $pengirim = $penjualan->pengirim;
            }

           $validatedData['pembayaran'] = explode('.', $validatedData['pembayaran']);
           $validatedData['pembayaran'] = implode('', $validatedData['pembayaran']);
           $nilai = $imp + $validatedData['pembayaran'];
           

           $status = 666;
           if($nilai >= $impos){
                $status = 1;
               $sisa_bayar = 0;
           }else{
               $status = 0;
              $sisa_bayar = $impos - $nilai;
           }

          $sisa_bayar = number_format($sisa_bayar , 0);
          $sisa_bayar = explode(',' ,$sisa_bayar);
          $sisa_bayar = implode('.' ,$sisa_bayar);

          $sisa_bayar = "Rp " .$sisa_bayar;


           $nilai = number_format($nilai, 0);
           $nilai = explode(',', $nilai);
           $nilai = implode('.', $nilai);

           $nilai = "Rp ".$nilai;

          if(auth()->user()->role === 1){
            $validatedData['petugas'] = auth()->user()->nama;
          }

          //belum ada bukti gambar dihalaman pesanan 
          $validatedData['bukti_gambar'] = $penjualan->bukti_gambar;

          //upload gambar bukti barang diterima
          if($request->file('bukti_gambar')){
            if($penjualan->bukti_gambar){
                Storage::delete($penjualan->bukti_gambar);
            }
            $validatedData['bukti_gambar'] = $request->file('bukti_gambar')->store('barang-diterima');
          }

           Penjualan::where('id' , $penjualan->id)->update(['pembayaran' => $nilai , 'sisa_bayar' => $sisa_bayar , 'petugas' => $validatedData['petugas'] , 'bukti_gambar' => $validatedData['bukti_gambar'] , 'status' => $status, 'detail' => $detail, 'pengirim' => $pengirim]);
          // Penjualan::where('id' , $penjualan->id)->update(['status' => $status, 'detail' => $detail, 'pengirim' => $pengirim]);
         
           if(session('uerl') == 'penjualan.edit'){
            $request->session()->forget('uerl');
            return redirect('/penjualan')->with('success', 'Penjualan Berhasil Dirubah');
           }

           if(session('alert') == 'pesanantotal'){
            $request->session()->forget('alert');
            return redirect('/pesanantotal')->with('success', 'Pesanan Berhasil Diproses');
           }
        }

        /////////
        
       if(session('uerl') == 'transaksi'){
        $validatedData = $request->validate([
            'harga_satuan' => 'required',
            'total' => 'required',
            'pengirim' => 'required|min:3|max:50',
            'pembayaran' => 'required',
            'nama_barang' => 'nullable',
            'pembeli' => 'nullable',
            'sisa_bayar' => 'nullable',
            'harga_beli' => 'nullable',
            'tujuan' => 'required'
        ]);

        $validatedData['pembayaran'] = explode('.', $validatedData['pembayaran']);
        $validatedData['pembayaran'] = implode('', $validatedData['pembayaran']);

        $validatedData['total'] = explode('.', $validatedData['total']);
        $validatedData['total'] = implode('', $validatedData['total']);

        $status = 666;
        if($validatedData['pembayaran'] >= $validatedData['total']){
            $status = 1;    
            $validatedData['sisa_bayar'] = 0;
        }else{
            $status = 0;   
             $validatedData['sisa_bayar'] = $validatedData['total'] - $validatedData['pembayaran'];
        }

        $validatedData['sisa_bayar'] = number_format($validatedData['sisa_bayar'] , 0);
        $validatedData['sisa_bayar'] = explode(',' , $validatedData['sisa_bayar']);
        $validatedData['sisa_bayar'] = implode('.' , $validatedData['sisa_bayar']);

        $validatedData['sisa_bayar'] = "Rp " . $validatedData['sisa_bayar'];

        $validatedData['pembayaran'] = number_format($validatedData['pembayaran'], 0);
        $validatedData['pembayaran'] = explode(',', $validatedData['pembayaran']);
        $validatedData['pembayaran'] = implode('.', $validatedData['pembayaran']);

        $validatedData['total'] = number_format($validatedData['total'], 0);
        $validatedData['total'] = explode(',', $validatedData['total']);
        $validatedData['total'] = implode('.', $validatedData['total']);

        $validatedData['harga_satuan'] = "Rp ". $validatedData['harga_satuan'];
        $validatedData['total'] = "Rp ".  $validatedData['total'];
        $validatedData['pembayaran'] = "Rp ".  $validatedData['pembayaran'];

        $validatedData['nama_barang'] = $penjualan->barang->nama_barang;
        $validatedData['harga_beli'] = $penjualan->barang->harga_beli;
       
        if($penjualan->user_id != 666){
            $validatedData['pembeli'] = $penjualan->user->nama;
        }


      

       $data = $barang::where('id', $penjualan->barang_id)->get();
       foreach($data as $sisa){
        $stok = $sisa->sisa;
        $terjual = $sisa->terjual;
       }

       $result = $stok - $penjualan->qty;
       $laku = $terjual + $penjualan->qty;
       $tanggal_terjual =  Carbon::now()->format('Y-m-d');

        Barang::where('id', $penjualan->barang_id)->update(['sisa' => $result , 'terjual' => $laku , 'terakhir_terjual' => $tanggal_terjual]);  
      
        $getProduk = Barang::where('id' , $penjualan->barang_id)->pluck('produk_id');
        Produk::where('id' , $getProduk[0])->update(['qty' => $result]);  

        Penjualan::where('id' , $penjualan->id)->update($validatedData);
        Penjualan::where('id' , $penjualan->id)->update(['status' => $status, 'detail' => "Selesai"]);

        $request->session()->forget('time');
        return redirect('/penjualan')->with('success', 'Penjualan Berhasil Ditambah');
       
       }
       

        
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penjualan $penjualan)
    {

        if($penjualan->detail == "Dipesan"){
          $br =   Barang::where('id' , $penjualan->barang_id)->get();
          $getProduk = Barang::where('id' , $penjualan->barang_id)->pluck('produk_id');
          
            foreach($br as $itm){
                Barang::where('id' , $penjualan->barang_id)->update(['sisa' => $itm->sisa + $penjualan->qty , 'terjual' => $itm->terjual - $penjualan->qty]);
                Produk::where('id' , $getProduk[0])->update(['qty' => $itm->sisa + $penjualan->qty]);  
            }

           
        }
        Penjualan::destroy('id', $penjualan->id);

        $trash = Penjualan::all();
        foreach($trash as $rat){
            if($rat->total == 0 || $rat->total == null){
                Penjualan::destroy('id' , $rat->id);
            }
        }

        if(session('pesan') == "allpesanan"){
            return redirect('/pesanantotal')->with('success', 'Pesanan Berhasil Dibatalkan');
        }

        return redirect('/penjualan')->with('success', 'Penjualan Berhasil Dibatalkan');
    }
}
