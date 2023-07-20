@extends('dashboard.main.main')

@section('container')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class=" justify-content-between flex-wrap d-flex flex-md-nowrap align-items-center pt-3 pb-2 mb-2 border-bottom">
      <h1 class="h2">Total Pembelian</h1>
     @can('pimpinan')
    <div>
      <a href="/grafikbeli">
        <button class="btn btn-info">Grafik Pembelian</button>
      </a>
       <a href="/laporanbeli/generatePDF">
        <button class="btn btn-success">Export PDF</button>
      </a>
    </div>
    @endcan
    </div>  
  </main>

  <div class="row-100">
    <div class="col-md-6 ms-sm-auto col-lg-10 px-md-4">
        <form action="/totalbeli" method="GET">
         <div class="input-group mb-1">
           <input type="date" class="form-control bg-light border border-dark" name="search">
           <span class="input-group-text border border-dark"><span  data-feather="calendar"></span></span>
           <input type="date" class="form-control bg-light border border-dark" name="search2">
           <button class="btn btn-danger text-white btn-outline-primary" type="submit" id="button-addon2">Search</button>
         </div>
       </form>
       </div>

       <div class="col-md-10 ms-sm-auto col-lg-10 px-md-4 table-responsive">
        <table class="table table-striped table-primary table-bordered table-hover text-center" border="2px solid black">
            <thead>
                <tr class="table-secondary">
                  <th scope="col">No</th>
                  <th scope="col">Tanggal Transaksi</th>
                  <th scope="col">Kode Pembelian</th>
                  <th scope="col">Supplier</th>
                  <th scope="col">Status</th>
                  <th scope="col" style="width: 7%">Aksi</th>
                </tr>
              </thead>
              @if ($pembelian->count())
                  <tbody>
                    @php
                     $i = 1;
                     @endphp
                     @foreach ($pembelian as $item)
                     <tr>
                      <td>{{ $i++ }}</td>
                      <td>{{ date('d-M-Y', strtotime($item->tanggal_transaksi)) }}</td>
                      <td>{{ $item->kode_pembelian }}</td>
                      @if ($item->supplier_id == 0)
                      <td class="text-danger table-warning">
                        Tidak Ada Supplier
                      </td>
                        @else
                      <td>
                        {{ $item->supplier->nama_supplier }}
                      </td>
                        @endif
                      @if ($item->status == 1)
                      <td>
                          Lunas
                      </td>
                      @else
                      <td class="table-warning">
                          Belum Lunas
                      </td>
                      @endif
                      <td>
                          <a href="/totalbeli/{{ $item->kode_pembelian }}" class="badge bg-warning text-decoration-none "> <span data-feather="edit" ></span></a>
                      </td>
                   </tr>
                     @endforeach
                     @else
                     <tr>
                     <td class="h5">🤖</td>
                      @if (request('search') && request('search2'))
                      <td colspan="8" class="h5">Pembelian pada tanggal <strong>{{ date('d-M-Y', strtotime(request('search'))) }}</strong> sampai <strong>{{ date('d-M-Y', strtotime(request('search2'))) }}</strong> tidak ditemukan 😥</td>
                      @endif

                      @if (request('search') && !request('search2'))
                      <td colspan="8" class="h5">Pembelian pada tanggal <strong>{{ date('d-M-Y', strtotime(request('search'))) }}</strong> tidak ditemukan 😥</td>
                      @endif

                      @if (request('search2') && !request('search'))
                      <td colspan="8" class="h5">Pembelian pada tanggal <strong>{{ date('d-M-Y', strtotime(request('search2'))) }}</strong> tidak ditemukan 😥</td>
                      @endif
                     </tr>
                  </tbody>
              @endif
        </table>
        {{ $pembelian->links() }}
       </div>
  </div>
@endsection