<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Tahun;
use Illuminate\Http\Request;

class TahunController extends Controller
{
    public function riwayat(Request $request, Penjualan $penjualan)
    {

        $penjualans = $penjualan::whereRaw('YEAR(tanggal_transaksi) = '. $request->tahun)->where('total', 'like' ,'%' . 'Rp' . '%')->where('detail' , '!=' , 'Dipesan')->orderBy('tanggal_transaksi', 'DESC');

        $carbon1 = date('Y-m-d H:i:s' , strtotime($request->search));
        $carbon2 = date('Y-m-d H:i:s' , strtotime('+23 hours +59 minutes' , strtotime($request->search2)));

        if($request->search && $request->search2){
            $penjualans = $penjualan::whereRaw('YEAR(tanggal_transaksi) = '. $request->tahun)->whereBetween('tanggal_transaksi', [$carbon1 , $carbon2])->where('total', '!=' , '0')->where('detail' , '!=' , 'Dipesan')->orderBy('tanggal_transaksi', 'DESC');
        }

        if($request->search && !$request->search2){
            $penjualans = $penjualan::whereRaw('YEAR(tanggal_transaksi) = '. $request->tahun)->where('tanggal_transaksi' , 'like' , '%' . $request->search . '%')->where('total', '!=' , '0')->where('detail' , '!=' , 'Dipesan')->orderBy('tanggal_transaksi', 'DESC');
        }

        if($request->search2 && !$request->search){
            $penjualans = $penjualan::whereRaw('YEAR(tanggal_transaksi) = '. $request->tahun)->where('tanggal_transaksi' , 'like' , '%' . $request->search2 . '%')->where('total', '!=' , '0')->where('detail' , '!=' , 'Dipesan')->orderBy('tanggal_transaksi', 'DESC');
        }

        //filter penjualan berdsarkan bulan transaksi (gunakan fungsi whereRaw untuk hanya mengambil bulan dari tanggal transaksi)
        $totalData = 0;
        if($request->bulan && $request->bulan != "00"){
            $penjualans = $penjualan::whereRaw('MONTH(tanggal_transaksi) = '. $request->bulan)->whereRaw('YEAR(tanggal_transaksi) = '. $request->tahun)->where('total', '!=' , '0')->where('detail' , '!=' , 'Dipesan')->orderBy('tanggal_transaksi', 'DESC');

            $totalData = $penjualan::whereRaw('MONTH(tanggal_transaksi) = '. $request->bulan)->whereRaw('YEAR(tanggal_transaksi) = '. $request->tahun)->count();
        }
        return view('dashboard.penjualan.riwayat' , [
            "title" => "Sesi Tahunan",
            "penjualan" => $penjualans->with(['barang' , 'user'])->paginate(10)->withQueryString(),
            "totalData" => $totalData
        ]);
    }
}
