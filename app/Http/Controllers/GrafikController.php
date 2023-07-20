<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class GrafikController extends Controller
{
    public function grafik_penjualan()
    {
          
        $chart_options = [
            'chart_title' => 'Jumlah penjualan per-minggu',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Penjualan',
            'group_by_field' => 'tanggal_transaksi',
            'group_by_period' => 'week',
            'filter_field' => 'tanggal_transaksi',
          /*   'filter_days' => 31, */
            'filter_period' => 'month', // show only transactions for this month
            'chart_type' => 'bar',
        ];
        $chart1 = new LaravelChart($chart_options);
        
        return view('dashboard.penjualan.grafik_view', [
            "title" => "Grafik Penjualan"
        ], compact('chart1'));
    }

    public function grafik_pembelian()
    {
          
        $chart_options = [
            'chart_title' => 'Jumlah pembelian per-minggu',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Pembelian',
            'group_by_field' => 'tanggal_transaksi',
            'group_by_period' => 'week',
            'filter_field' => 'tanggal_transaksi',
          /*   'filter_days' => 31, */
            'filter_period' => 'month', // show only transactions for this month
            'chart_type' => 'bar',
        ];
        $chart1 = new LaravelChart($chart_options);
        
        return view('dashboard.pembelian.grafik_view', [
            "title" => "Grafik Pembelian"
        ], compact('chart1'));
    }

    public function grafik_barang()
    {
       /*  $data = Penjualan::all();
        foreach($data as $var){
            $jual = $var->barang->terjual;
           
        } */
        $chart_options = [
            'chart_title' => 'Barang terjual bulan ini',
            'report_type' => 'group_by_relationship',
            'model' => 'App\Models\Penjualan',
            'relationship_name' => 'barang',
            'group_by_field' => 'nama_barang',
        /*     'group_by_period' => 'week', */
           'aggregate_function' => 'sum',
           'aggregate_field' => 'qty',
            'filter_field' => 'tanggal_transaksi',
              /* 'filter_days' => '7', */
            'filter_period' => 'month', // show only transactions for this month
            'chart_type' => 'bar',
        ];
        $chart1 = new LaravelChart($chart_options);
        
        return view('dashboard.barang.grafik_view', [
            "title" => "Grafik Persediaan"
        ], compact('chart1'));
    }
}
