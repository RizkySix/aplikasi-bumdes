@extends('dashboard.main.main')

@section('container')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="text-center justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Form Pemesanan Barang</h1>
      <form action="/pelanggan/pesan" method="GET" >
        <div class="input-group mb-1 w-50 m-auto">
          <input type="text" class="form-control bg-light border border-dark" placeholder="Cari nama barang..." name="search" value="{{ request('search') }}" autofocus>
          <button class="btn btn-danger text-white btn-outline-primary" type="submit" id="button-addon2">Search</button>
        </div>
      </form>
    </div>  

  </main>

  <div class="row w-100 mt-4">
    <div class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
        <form action="/pelanggan/create" method="GET" class="needs-validation" novalidate>
            <div class="row g-3">
                <div class="col-sm-10">
                  @if (session()->has('folks'))
                  <div class="alert alert-danger alert-dismissible fade show w-25" role="alert">
                  {{ session('folks') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                  @endif
                    <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
                    <input type="date" name="tanggal_transaksi" class="form-control @error('tanggal_transaksi') is-invalid @enderror" id="tanggal_transaksi" placeholder=""  value="{{ old('tanggal_transaksi' , request('tanggal_transaksi')) }}">
                    @if (old('tanggal_transaksi'))
                    @error('tanggal_transaksi')
                    <div class="invalid-feedback">
                    {{ $message }}
                    </div>
                    @enderror
                    @else
                    <div class="invalid-feedback">
                    Tanggal Transaksi Wajib Dilengkapi
                    </div>
                    @endif
                </div>

                <div class="col-sm-10">
                    <label for="user_id" class="form-label">Nama Pelanggan</label>
                    <div class="input-group">
                      <span class="input-group-text"><span data-feather="user"></span></span>
                        <input type="text" class="form-control d-none" name="user_id" value="{{ auth()->user()->id }}" readonly>
                        <input type="text" class="form-control"  value="{{ auth()->user()->nama }}" readonly>
                    </div>
                   
                </div>

                <div class="col-sm-4">
                    <label for="barang_id" class="form-label">Produk</label>
                   <div class="input-group">
                    <span class="input-group-text"><span data-feather="truck"></span></span>
                    <select name="barang_id" id="barang_id" class="form-select" required onmousedown="if(this.options.length>5){this.size=5;}" onchange='this.size=0;' onblur="this.size=0;">
                      @if ($barang->count())
                      @foreach ($barang as $produk)
                         @if ($produk->sisa == 0)
                             <option value="{{ $produk->id }}" data-toggle="tooltip" data-placement="top" title="Stok tersedia {{ $produk->sisa }}"  disabled class="bg-warning"> {{ $produk->nama_barang }}</option>
                             @if (request('search'))
                             <option value="{{ $produk->id }}" data-toggle="tooltip" data-placement="top" title="Stok tersedia {{ $produk->sisa }}"  disabled selected class="bg-warning"> {{ $produk->nama_barang }}</option>
                             @endif
                          @elseif(session('mail_bar_id'))
                          <option value="{{ $produk->id }}" data-toggle="tooltip" data-placement="top" title="Stok tersedia {{ $produk->sisa }}" {{ old('barang_id' , session('mail_bar_id')) == $produk->id ? 'selected':''}}>{{ $produk->nama_barang }}</option> 
                         @else
                         <option value="{{ $produk->id }}" data-toggle="tooltip" data-placement="top" title="Stok tersedia {{ $produk->sisa }}" {{ old('barang_id' , request('id')) == $produk->id ? 'selected':''}}>{{ $produk->nama_barang }}</option> 
                         @endif

                        
                      @endforeach
                      @else
                      <option value="none" disabled selected>Produk Tidak Ditemukan</option>
                      @endif
                    </select>
                   </div>
                   
                </div>

                <div class="col-sm-3">
                    <label for="note" class="form-label">Note</label>
                   <select name="note" id="note" class="form-select">
                    @if (session('gross'))
                    <option value="1">Satuan</option>
                    <option value="2" id="gros" selected>Grosir</option>
                    @else
                    <option value="1">Satuan</option>
                    <option value="2" id="gros">Grosir</option>
                    @endif
                   </select>
                </div>

                <div class="col-sm-3">
                    <label for="qty" class="form-label">Qty</label>
                    <input type="number" name="qty" class="form-control @error('qty') is-invalid @enderror" id="qtys" placeholder=""   required value="{{ old('qty') }}">
                    @if (old('qty'))
                    @error('qty')
                    <div class="invalid-feedback">
                    {{ $message }}
                    </div>
                    @enderror
                    @else
                    <div class="invalid-feedback">
                    Jumlah Pesanan Wajib Dilengkapi
                    </div>
                    @endif
                  
                </div>

                <script>
                  //thanks stackoverflows
                $(document).ready(function () {     
                $('#note').change(function(){
                var qtys = $(this).val();
                $('#qtys').val(qtys);
                })
                });

                </script>
              
                <div class="col-sm-10">
                  <label for="tujuan" class="form-label">Lokasi Pengiriman</label>
                  <div class="input-group has-validation">
                    <span class="input-group-text"><span data-feather="map-pin"></span></span>
                    <input type="text" name="tujuan" class="form-control @error('tujuan') is-invalid @enderror" id="tujuan" placeholder=""   required value="{{ old('tujuan') }}">
                  @if (old('tujuan'))
                  @error('tujuan')
                  <div class="invalid-feedback">
                  {{ $message }}
                  </div>
                  @enderror
                  @else
                  <div class="invalid-feedback">
                  Lokasi Pengiriman Wajib Dilengkapi
                  </div>
                  @endif
                  </div>
                
              </div>

                

                <input type="text" class="form-control d-none" name="kode_penjualan">
                <input type="text" class="form-control d-none" name="petugas">


            </div>
            <button class="col-md-2 btn btn-primary btn-md mt-4" type="submit">Lanjutkan Pesanan</button>
            <button class="col-md-2 btn btn-danger btn-md mt-4" type="reset">Reset Form</button>
        </form>
    </div>
  </div>
@endsection