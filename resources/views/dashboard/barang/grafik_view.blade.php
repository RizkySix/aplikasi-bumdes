@extends('dashboard.main.main')

@section('container')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class=" justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-2 border-bottom">
      <h1 class="h2">Grafik Barang</h1>
    </div>  
  </main>

  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 ms-sm-auto col-lg-10 px-md-4">
            <div class="card">
                <div class="card-header">Grafik barang Bumdes Sad Mertha Nadi</div>
              

                <div class="card-body">

                    <h3>Barang Terjual Pada Bulan Ini</h3>
                    <p class="text-muted">(Grafik berubah-ubah secara otomatis setiap ada penjualan barang setiap bulan)</p>
                    {!! $chart1->renderHtml() !!}

                </div>

            </div>
        </div>
    </div>
</div>
{!! $chart1->renderChartJsLibrary() !!}
{!! $chart1->renderJs() !!}


@endsection