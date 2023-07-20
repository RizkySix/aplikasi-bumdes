<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use PDF;

class PelangganController extends Controller
{

    public function all_pesanan(Request $request)
    {
        $pesanan = Penjualan::where('user_id' , auth()->user()->id)->orderBy('created_at' , 'DESC');

        if($request->search && $request->search2){
            $pesanan = Penjualan::whereBetween('tanggal_transaksi', [$request->search , $request->search2])->where('total', '!=' , '0')->where('user_id' , auth()->user()->id)->orderBy('created_at', 'DESC');
        }

        if($request->search && !$request->search2){
            $pesanan = Penjualan::where('tanggal_transaksi' , '=' , $request->search)->where('total', '!=' , '0')->where('user_id' , auth()->user()->id)->orderBy('created_at', 'DESC');
        }

        if($request->search2 && !$request->search){
            $pesanan = Penjualan::where('tanggal_transaksi' , '=' , $request->search2)->where('total', '!=' , '0')->where('user_id' , auth()->user()->id)->orderBy('created_at', 'DESC');
        }
        return view('dashboard.pelanggan.all_pesanan' , [
            "title" => "Semua Pesanan",
            "pesanan" => $pesanan->with(['barang' , 'user'])->paginate(10)->withQueryString()
        ]);
    }


    public function pesan(Request $request, Barang $barang)
    {
        $barangs = $barang::orderBy('created_at', 'DESC');

        if($request->search){
            $barangs = $barang::where('nama_barang', 'like' , '%' . $request->search . '%');
        }
       return view('dashboard.pelanggan.pesan_view' , [
            "title" => "Tambah Pesanan",
            "barang" => $barangs->get()
       ]);
    }

    public function transaksi(Request $request, Barang $barang)
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-ZIQN-OESa2DqSuWktHb9lGqW';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        //midtrans payment gateway code check di ytb
        $TotalBayar = Barang::where('id' , $request->barang_id)->get();
    
        foreach($TotalBayar as $item2){
            $kdBR = $item2->kode_barang;
            $hrj = $item2->harga_jual;
            $nmb = $item2->nama_barang;
        if($request->note == 1){
            $tot = explode(' ', $item2->harga_jual);
            $tot = end($tot);
            $tot = explode('.', $tot);
            $tot = implode('', $tot);

            $final_tot = $tot * request('qty');
            $fitot = number_format($final_tot, 0);
            $fitot = explode(',' , $fitot);
            $fitot = implode('' , $fitot);
        }else{
            $tot = explode(' ', $item2->harga_jual);
           $tot = end($tot);
           $tot = explode('.', $tot);
           $tot = implode('', $tot);


           $total =  $tot * request('qty');
           $final = (5/100) * $total;
           $result = $total - $final;
           $gore =  number_format($result, 0);
           $gone = explode(',',$gore);
           $fitot = implode('',$gone);
         }
        }
        
      
        $transaction_details = array(
            'order_id' => rand(),
            'gross_amount' => $fitot, // no decimal allowed for creditcard
        );
        // Optional
      if($request->note == 1){
        $item_details = array (
            array(
                'id' => 'a1',
                'price' => $tot,
                'quantity' => $request->qty,
                'name' => $nmb
            ),
          );
      }else{
        
        $tos = (5/100) * $tot ;
        $tot =  $tot - $tos;
        
        $item_details = array (
            [
                'id' => 'a1',
                'price' => $tot,
                'quantity' => $request->qty,
                'name' => $nmb
            ],
           [
                'id' => 'a2',
                'price' => 50000,
                'quantity' => 10,
                'name' => 'permen'
           ],
          );
      }

        
        // Optional
        $customer_details = array(
            'first_name'    => auth()->user()->nama,
          /*   'last_name'     => "Litani", */
            'email' => auth()->user()->email,
            'phone' => auth()->user()->no_hp,
          
        );
        
        $params = array(
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        /////////////////code view edit diluar dari code midtrans
        $getBarang = $barang::where('id', $request->barang_id)->get();
        foreach($getBarang as $get){
            $value = $get->sisa;
        }
        if($value < $request->qty){
            return back()->with('folks', 'Stok Barang Tidak Cukup');
        }

        if($request->note == 2  && $request->qty == 1){
           
            session()->put('gross' , 'restric');
            return back()->with('folks' , 'Grosir minimal beli 2 barang');
          
        }

        $produk = Barang::where('id' , $request->barang_id)->get();
        return view('dashboard.pelanggan.transaksi' , [
            "title" => "Konfirmasi Pesanan",
            "produk" => $produk,
            "snapToken" => $snapToken
       ]);
    }

    public function store(Request $request, Barang $barang)
    {
        $validatedData = $request->validate([
            'tanggal_transaksi' => 'nullable|date',
            'user_id' => 'required|numeric',
            'barang_id' => 'required|numeric',
            'note' => 'required|integer',
            'qty' => 'required|integer',
            'kode_penjualan' => 'nullable|unique:penjualans',
            'harga_satuan' => 'required', 
            'total' => 'required',
            'harga_beli' => 'required',
            'tujuan' => 'required'
        ]);

        

        if($validatedData['tanggal_transaksi'] == null){
            $validatedData['tanggal_transaksi'] = Carbon::now();
           }else{
            $validatedData['tanggal_transaksi'] =  $validatedData['tanggal_transaksi'] . " " . Carbon::now()->format('H:i:s');
           }
           


        $validatedData['kode_penjualan'] = fake()->swiftBicNumber();

        $validatedData['harga_satuan'] = "Rp " . $validatedData['harga_satuan'];
        $validatedData['total'] = "Rp " . $validatedData['total'];

        $validatedData['pembayaran'] = "Rp 0";
        $validatedData['sisa_bayar'] = $validatedData['total'];
        $validatedData['detail'] = "Dipesan";

        $data = $barang::where('id', $validatedData['barang_id'])->get();
       foreach($data as $sisa){
        $stok = $sisa->sisa;
        $terjual = $sisa->terjual;
        $nama_barang  = $sisa->nama_barang;
       }

       $validatedData['nama_barang'] = $nama_barang;
       $validatedData['pembeli'] = auth()->user()->nama;

       $result = $stok - $validatedData['qty'];
       $laku = $terjual + $validatedData['qty'];
       $tanggal_terjual = Carbon::now()->format('Y-m-d');

        Barang::where('id', $validatedData['barang_id'])->update(['sisa' => $result , 'terjual' => $laku , 'terakhir_terjual' => $tanggal_terjual]); 

        $getProduk = Barang::where('id' , $validatedData['barang_id'])->pluck('produk_id');
        Produk::where('id' , $getProduk[0])->update(['qty' => $result]);  

        Penjualan::create($validatedData);
        return redirect('/dashboard')->with('success' , 'Pesanan Berhasil Dibuat');
    }

    public function detail(Request $request, Penjualan $penjualan)
    {
        $penjualans = $penjualan::where('kode_penjualan' , $request->kode_penjualan)->get();
        return view('dashboard.pelanggan.detail_pesanan', [
            "title" => "Detail Pesanan",
            "penjualans" => $penjualans
        ]);
    }

    public function nota_jual(Request $request, Penjualan $penjualan)
    {
        $penjualans = $penjualan::where('kode_penjualan' , $request->kode_penjualan)->get();
        $pdf = PDF::loadView('dashboard.pelanggan.nota_pesanan', [
            "title" => "Nota Pesanan",
            "penjualans" => $penjualans
        ]);

        return $pdf->download('nota_pesanan('. $request->kode_penjualan  . ').pdf');

        
    }
}
