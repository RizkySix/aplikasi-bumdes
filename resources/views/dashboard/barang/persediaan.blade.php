@extends('dashboard.main.main')

@section('container')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class=" justify-content-between flex-wrap d-flex flex-md-nowrap align-items-center pt-3 pb-2 mb-2 border-bottom">
      <h1 class="h2">Laporan Persediaan</h1>
     <div>
      <a href="/grafikbarang">
        <button class="btn btn-info">Grafik Barang</button>
      </a>
      <a href="/persediaan/generatePDF">
        <button class="btn btn-success">Export PDF</button>
      </a>
     </div>
    </div>  
  </main>

  <div class="row-100">
    <div class="col-md-6 ms-sm-auto col-lg-10 px-md-4">
       </div>

       <div class="col-md-10 ms-sm-auto col-lg-10 px-md-4 table-responsive">
        <table class="table table-striped table-primary table-bordered table-hover text-center" border="2px solid black">
            <thead>
                <tr class="table-secondary">
                  <th scope="col">No</th>
                  <th scope="col">Nama Barang</th>
                  <th scope="col">Kode Barang</th>
                  <th scope="col">Harga Beli</th>
                  <th scope="col">Harga Jual</th>
                  <th scope="col">Jumlah</th>
                  <th scope="col">Sisa</th>
                  <th scope="col">Terjual</th>
                  <th scope="col">Supplier</th>
                </tr>
              </thead>
              @if ($barang->count())
                  
              <tbody>
              
               @foreach ($barang as $item)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama_barang }}</td>
                <td>{{ $item->kode_barang }}</td>
                <td>
                  @php
                       $string = $item->harga_beli;
                       $cut = explode(' ', $string);
                       $data = end($cut);
                  @endphp
                  Rp {{ $data }}
                </td>
                <td>
                  @php
                      $string2 = $item->harga_jual;
                      $cut2 = explode(' ', $string2);
                      $data2 = end($cut2);
                  @endphp
                   Rp {{ $data2 }}
                </td>
                <td>{{ $item->jumlah }}</td>
                <td>{{ $item->sisa }}</td>
                <td>{{ $item->terjual }}</td>
                @if ($item->supplier_id == 0)
                <td class="text-danger table-warning">
                  Tidak Ada Supplier
                </td>
                  @else
                <td>
                  {{ $item->supplier->nama_supplier }}
                </td>
                  @endif
              </tr>
               
               @endforeach
               @else
                <tr>
                <td class="h5">🤖</td>
                <td colspan="8" class="h5">Kode atau nama barang <strong>{{ request('search') }}</strong> tidak ditemukan 😥</td>
                </tr>
              </tbody>
              @endif
        </table>
        {{ $barang->links() }}
       </div>
  </div>
@endsection