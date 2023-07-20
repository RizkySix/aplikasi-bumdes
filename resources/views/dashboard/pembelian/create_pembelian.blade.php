@extends('dashboard.main.main')

@section('container')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="text-center justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Form Tambah Data Pembelian</h1>
      <form action="/pembelian/create" method="GET" >
        <div class="input-group mb-1 w-50 m-auto">
          <input type="text" class="form-control bg-light border border-dark" placeholder="Cari nama supplier..." name="search" value="{{ request('search') }}" autofocus>
          <button class="btn btn-danger text-white btn-outline-primary" type="submit" id="button-addon2">Search</button>
        </div>
      </form>
    </div>  

  </main>

  <div class="row w-100 mt-4">
    <div class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
        <form action="/pembelian" method="POST" class="needs-validation" novalidate>
        @csrf
            <div class="row g-3">
                <div class="col-sm-10">
                  @if (session()->has('folks'))
                  <div class="alert alert-danger alert-dismissible fade show w-25" role="alert">
                  {{ session('folks') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                  @endif
                    <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
                    <input type="date" name="tanggal_transaksi" class="form-control @error('tanggal_transaksi') is-invalid @enderror" id="tanggal_transaksi" placeholder="" value="{{ old('tanggal_transaksi' , request('tanggal_transaksi')) }}">
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
                    <label for="supplier_id" class="form-label">Nama Supplier</label>
                    <div class="input-group">
                      <span class="input-group-text"><span data-feather="user"></span></span>
                    <select name="supplier_id" id="supplier_id" class="form-select" required onmousedown="if(this.options.length>5){this.size=5;}" onchange='this.size=0;' onblur="this.size=0;">
                      @if ($supplier->count())
                      @foreach ($supplier as $toko)
                         <option value="{{ $toko->id }}" {{ old('supplier_id') == $toko->id ? 'selected':''}}>{{ $toko->nama_supplier }}</option> 
                      @endforeach
                      @else
                      <option value="none" disabled selected>Toko Tidak Ditemukan</option>
                      @endif
                    </select>
                    </div>
                   
                </div>

              

                <input type="text" class="form-control d-none" name="kode_pembelian">


            </div>
            <button class="col-md-2 btn btn-primary btn-md mt-4" type="submit">Buat Pembelian</button>
            <button class="col-md-2 btn btn-danger btn-md mt-4" type="reset">Reset Form</button>
        </form>
    </div>
  </div>
@endsection