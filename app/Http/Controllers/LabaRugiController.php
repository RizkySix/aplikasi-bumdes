<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Konten;
use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class LabaRugiController extends Controller
{
    

    public function create()
    {
        return view('dashboard.labarugi.create_view' ,[
            "title" => "Buat Laporan Laba Rugi"
        ]);
    }

    public function generate(Request $request)
    {
        $carbon1 = date('Y-m-d H:i:s' , strtotime($request->search));
        $carbon2 = date('Y-m-d H:i:s' , strtotime('+23 hours +59 minutes' , strtotime($request->search2)));
       $allPenjualan = Penjualan::whereBetween('tanggal_transaksi' , [$carbon1 , $carbon2])->where('detail' , '!=' , 'Dipesan')->get();
        $barang = Barang::all();

        $harga_pokok = 0;
        $real_keuntungan = 0;
        $tunggakan = 0;
        $modal = 0;
        $sisa_bayar = 0;
       foreach($allPenjualan as $penjualan){

        $exp = explode(' ' , $penjualan->harga_beli);
        $format = end($exp);
        $format = explode('.' , $format);
        $format = implode('' , $format);

        $harga_pokok = $format;

           $harga_qty  = $harga_pokok * $penjualan->qty;

           $exp2 = explode(' ' , $penjualan->pembayaran);
           $format2 = end($exp2);
           $format2 = explode('.' , $format2);
           $format2 = implode('' , $format2);

           $final_untung = $format2;

           $sis = explode(' ' , $penjualan->sisa_bayar);
           $sis = end($sis);
           $sis = explode('.',$sis);
           $sis = implode('',$sis);

           $sisa_bayar += $sis;

                if($final_untung >= $harga_qty){
                    $tunggakan += $sis;
                }else{
                    $modal += $harga_qty - $final_untung;
                }

           $keuntungan = $final_untung - $harga_qty;

           $real_keuntungan += $keuntungan;
       }
       
       $ktn = "";
      $pesan = Konten::all();
      foreach($pesan as $psn){
       $ktn = $psn->pesan_labarugi;
      }
      if(!$ktn){
        
        $konten = "Tidak ada informasi laporan laba-rugi terbaru";
      }

      $konten = $ktn;

       $pdf = PDF::loadView('dashboard.labarugi.pdf_view', [
        "title" => "Laporan Laba Rugi",
        "keuntungan" => $real_keuntungan,
        "tunggakan" => $tunggakan,
        "modal" => $modal,
        "sisa_bayar" => $sisa_bayar,
        "konten" => $konten
    ]);

    $date1 = date('d-M-Y' , strtotime($request->search));
    $date2 = date('d-M-Y' , strtotime($request->search2));
    return $pdf->download('laporan_laba-rugi(' . $date1 . '-' . 'sampai' . '-' . $date2 . ').pdf');


    }


}
