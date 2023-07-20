@extends('dashboard.main.main')

@section('container')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class=" justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-2 border-bottom">
      <h1 class="h2">Transaksi Penjualan</h1>
      <div class="d-flex">
        <a href="/penjualan/create" class="btn btn-primary mb-3">Tambah Penjualan Baru</a>
        <a href="{{ route('pelanggan_!terdaftar') }}" class="btn btn-secondary mb-3" style="margin-left:5px">Penjualan Offline</a>
        <form action="/penjualan" method="GET" style="margin-left:5px;">
          <select name="bulan" id="bulan" class="form-select" style="background-color: crimson; color:aliceblue">
            <option value="00" @if (request('bulan') == "00") selected  @endif>Default</option>
            <option value="01" @if (request('bulan') == "01") selected  @endif>Januari</option>
            <option value="02" @if (request('bulan') == "02") selected  @endif>Februari</option>
            <option value="03" @if (request('bulan') == "03") selected  @endif>Maret</option>
            <option value="04" @if (request('bulan') == "04") selected  @endif>April</option>
            <option value="05" @if (request('bulan') == "05") selected  @endif>Mei</option>
            <option value="06" @if (request('bulan') == "06") selected  @endif>Juni</option>
            <option value="07" @if (request('bulan') == "07") selected  @endif>Juli</option>
            <option value="08" @if (request('bulan') == "08") selected  @endif>Agustus</option>
            <option value="09" @if (request('bulan') == "09") selected  @endif>September</option>
            <option value="10" @if (request('bulan') == "10") selected  @endif>Oktober</option>
            <option value="11" @if (request('bulan') == "11") selected  @endif>November</option>
            <option value="12" @if (request('bulan') == "12") selected  @endif>Desember</option>
          

          </select>

          <button type="submit" id="btnbtn" class="d-none">Click</button>
        </form>
      </div>

  
      <script>
        $(document).ready(function(){
          $('#bulan').change(function(){
            $('#btnbtn').trigger('click');
          })
        })

      </script>
    
     @if (session()->has('success'))
     <div class="alert alert-success alert-dismissible fade show w-25" role="alert">
     {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
     @endif
    
     @if (request('bulan') && request('bulan') != "00")
      @php
          $produk_terjual = 0;
          $uang_masuk = 0;
          foreach($penjualan as $s_produk){
            $produk_terjual += $s_produk->qty;

            //cek total uang masuk pada bulan yang dipilih
            $uang = explode(' ', $s_produk->pembayaran);
            $uang = end($uang);
            $uang = explode('.' , $uang);
            $uang = implode('' , $uang);

            $uang_masuk += $uang;
            
          }

          $uang_masuk = number_format($uang_masuk, 0);
          $uang_masuk = explode(',' , $uang_masuk);
          $uang_masuk = implode('.' , $uang_masuk);
      @endphp

       <div class="d-flex justify-content-around" style="width: 45%">
        <p><p class="text-muted">Total Penjualan :</p> <p style="margin-left: 2px" class="fw-bold">{{ $totalData }}</p> , <p class="text-muted">Total Produk Terjual :</p> <p style="margin-left:2px" class="fw-bold">{{ $produk_terjual }} pcs</p> , <p class="text-muted">Total Uang Masuk :</p> <p class="fw-bold">Rp {{ $uang_masuk }}</p> </p>
       </div>
     @endif
      
     <div class="d-flex">
      @foreach ($tahuns as $tahun)
          <a href="/sesi_tahun/{{ $tahun->tahun }}" class="btn btn-success me-2">{{ $tahun->tahun }}</a>
      @endforeach
     </div>

    </div>  
  </main>

  <div class="row-100">
    <div class="col-md-6 ms-sm-auto col-lg-10 px-md-4">
        <form action="/penjualan" method="GET">
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
                  <th scope="col" style="width: 12%">Aksi</th>
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
                          @if ($item->user_id != 0 && $item->user_id != 666)
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
                            <a href="/penjualan/{{ $item->kode_penjualan }}/edit" class="badge bg-warning text-decoration-none "> <span data-feather="edit" ></span></a>
                            <form action="/penjualan/{{ $item->kode_penjualan }}" method="POST" id="sumbitform" class="d-inline">
                            @method('delete')
                            @csrf
                            <button id="del{{ $item->kode_penjualan }}" type="submit" class="badge bg-danger  border-0"><span data-feather="trash-2"></span></button>
                                <script>
                            $(document).ready(function (){
                        
                                $("#del{{ $item->kode_penjualan }}").click(function(event){
                                event.preventDefault();
                                Swal.fire({
                                title: 'Yakin hapus data?',
                                text: "Data akan terhapus secara permanen!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ya, Hapus!'
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    $(event.target).closest('form').submit();//from stack overflow
                                }
                                })
                                });
                            });
                        </script>
                        </form>
                        @can('petugas')
                        <a href="/notajual/{{ $item->kode_penjualan }}" class="badge bg-success text-decoration-none "> <span data-feather="printer" ></span></a>
                        @endcan
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