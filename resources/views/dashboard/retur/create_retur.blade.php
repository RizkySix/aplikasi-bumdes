@extends('dashboard.main.main')

@section('container')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="text-center justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Form Tambah Data Retur</h1>
      <form action="/retur/create" method="GET" >
        <div class="input-group mb-1 w-50 m-auto">
          <input type="text" class="form-control bg-light border border-dark" placeholder="Cari nama barang..." name="search" value="{{ request('search') }}" autofocus>
          <button class="btn btn-danger text-white btn-outline-primary" type="submit" id="button-addon2">Search</button>
        </div>
      </form>
    </div>  

  </main>

  <div class="row w-100 mt-4">
    <div class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
        <form action="/retur" method="POST" class="needs-validation" novalidate>
        @csrf
            <div class="row g-3">
                <div class="col-sm-10">
                  @if (session()->has('folks'))
                  <div class="alert alert-danger alert-dismissible fade show w-25" role="alert">
                  {{ session('folks') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                  @endif
                    <label for="tanggal_retur" class="form-label">Tanggal Retur</label>
                    <input type="date" name="tanggal_retur" class="form-control @error('tanggal_retur') is-invalid @enderror" id="tanggal_retur" placeholder="" value="{{ old('tanggal_retur') }}">
                    @if (old('tanggal_retur'))
                    @error('tanggal_retur')
                    <div class="invalid-feedback">
                    {{ $message }}
                    </div>
                    @enderror
                    @else
                    <div class="invalid-feedback">
                    Tanggal Retur Wajib Dilengkapi
                    </div>
                    @endif
                </div>

                <div class="col-sm-4">
                    <label for="barang_id" class="form-label">Barang</label>
                   <div class="input-group">
                    <span class="input-group-text"><span data-feather="truck"></span></span>
                    <select name="barang_id" id="barang_id" class="form-select" required onmousedown="if(this.options.length>5){this.size=5;}" onchange='this.size=0;' onblur="this.size=0;">
                      @if ($barang->count())
                      @foreach ($barang as $produk)
                      

                         @if ($produk->sisa == 0)
                             <option value="{{ $produk->id }}" data-toggle="tooltip" data-placement="top" title="Stok tersedia {{ $produk->sisa }}"  disabled class="bg-warning"> {{ $produk->nama_barang }}</option>
                         @elseif(session('barang_!laku'))
                         <option value="{{ $produk->id }}" data-toggle="tooltip" data-placement="top" title="Stok tersedia {{ $produk->sisa }}" {{ session('barang_!laku') == $produk->id ? 'selected':''}}>{{ $produk->nama_barang }}</option> 
                         @else
                         <option value="{{ $produk->id }}" data-toggle="tooltip" data-placement="top" title="Stok tersedia {{ $produk->sisa }}" {{ old('barang_id' , request('barang_id')) == $produk->id ? 'selected':''}}>{{ $produk->nama_barang }}</option> 
                         @endif
                      @endforeach
                      @else
                      <option value="none" disabled selected>Barang Tidak Ditemukan</option>
                      @endif
                    </select>
                   </div>
                   
                </div>

                <div class="col-sm-3">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" placeholder=""   required value="{{ old('jumlah') }}">
                    @if (old('jumlah'))
                    @error('jumlah')
                    <div class="invalid-feedback">
                    {{ $message }}
                    </div>
                    @enderror
                    @else
                    <div class="invalid-feedback">
                    Jumlah Retur Wajib Dilengkapi
                    </div>
                    @endif
                  
                </div>
                <div class="col-sm-3">
                    <label for="keterangan" class="form-label">Keterangan Retur</label>
                    <input type="text" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" placeholder="Keterangan pengembalian..."  required  @if (session('barang_!laku'))
                    value="{{ old('keterangan' , 'Barang tidak laku') }}"
                    @else
                    value="{{ old('keterangan') }}"
                    @endif>
                    @if (old('keterangan'))
                    @error('keterangan')
                    <div class="invalid-feedback">
                    {{ $message }}
                    </div>
                    @enderror
                    @else
                    <div class="invalid-feedback">
                    Keterangan Retur Wajib Dilengkapi
                    </div>
                    @endif
                  
                </div>


            </div>
            <button class="col-md-2 btn btn-primary btn-md mt-4" type="submit">Buat Retur</button>
            <button class="col-md-2 btn btn-danger btn-md mt-4" type="reset">Reset Form</button>
        </form>
    </div>
  </div>
@endsection