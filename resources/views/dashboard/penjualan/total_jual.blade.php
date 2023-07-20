@extends('dashboard.main.main')

@section('container')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class=" justify-content-between flex-wrap d-flex flex-md-nowrap align-items-center pt-3 pb-2 mb-2 border-bottom">
      <h1 class="h2">Total Penjualan</h1>
     @can('pimpinan')
    <div>
      <a href="/grafikjual">
        <button class="btn btn-info">Grafik Penjualan</button>
      </a>
       <a href="/laporanjual/generatePDF">
        <button class="btn btn-success">Export PDF</button>
      </a>
    </div>
    @endcan
    </div>  
  </main>

  <div class="row-100">
    <div class="col-md-6 ms-sm-auto col-lg-10 px-md-4">
        <form action="/totaljual" method="GET">
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
                  <th scope="col">Kode Penjualan</th>
                  <th scope="col">Pelanggan</th>
                  <th scope="col">Produk</th>
                  <th scope="col">Status</th>
                  <th scope="col">Note</th>
                  <th scope="col">Detail</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              @if ($penjualan->count())
                  <tbody>
                    @php
                     $i = 1;
                     @endphp

                     @foreach ($penjualan as $item)
                       <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ date('d-M-Y', strtotime($item->tanggal_transaksi)) }}</td>
                        <td>{{ $item->kode_penjualan }}</td>
                        <td>
                          @if ($item->user_id != 0)
                          {{ $item->user->nama }}
                          @else
                          {{ $item->pembeli }}
                          @endif
                        </td>
                        <td>
                          @if ($item->barang_id != 0)
                          {{ $item->barang->nama_barang }}
                          @else
                          {{ $item->nama_barang }}
                          @endif
                        </td>
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
                            @if ($item->note == 1)
                                Satuan
                            @else
                                Grosir
                            @endif
                        </td>
                        @if ($item->detail == "Selesai")
                            <td class="table-success">
                              {{ $item->detail }}
                            </td>
                        @endif
                        @if ($item->detail == "Dipesan")
                            <td class="table-dark">
                              {{ $item->detail }}
                            </td>
                        @endif
                        @if ($item->detail == "Dikirim")
                            <td class="table-light">
                              {{ $item->detail }}
                            </td>
                        @endif
                        <td>
                            <a href="/totaljual/{{ $item->kode_penjualan }}" class="badge bg-warning text-decoration-none "> <span data-feather="edit" ></span></a>
                        </td>
                     </tr>
                     @endforeach
            
                     @else
                     <tr>
                     <td class="h5">🤖</td>
                      @if (request('search') && request('search2'))
                      <td colspan="8" class="h5">Penjualan pada tanggal <strong>{{ date('d-M-Y', strtotime(request('search'))) }}</strong> sampai <strong>{{ date('d-M-Y', strtotime(request('search2'))) }}</strong> tidak ditemukan 😥</td>
                      @endif

                      @if (request('search') && !request('search2'))
                      <td colspan="8" class="h5">Penjualan pada tanggal <strong>{{ date('d-M-Y', strtotime(request('search'))) }}</strong> tidak ditemukan 😥</td>
                      @endif

                      @if (request('search2') && !request('search'))
                      <td colspan="8" class="h5">Penjualan pada tanggal <strong>{{ date('d-M-Y', strtotime(request('search2'))) }}</strong> tidak ditemukan 😥</td>
                      @endif
                     </tr>
                  </tbody>
              @endif
        </table>
        {{ $penjualan->links() }}
       </div>
  </div>
@endsection