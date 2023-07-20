@extends('dashboard.main.main')

@section('container')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="text-center justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Form Beli Produk</h1>
    </div>  

  </main>

  <div class="row w-100 mt-4">
    <div class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
        <form action="/produk" method="POST" class="needs-validation" novalidate>
        @csrf
          @foreach ($pembelian as $item)
          <div class="row g-3">
            <div class="col-sm-10">
              @if (session()->has('folks'))
              <div class="alert alert-danger alert-dismissible fade show w-25" role="alert">
              {{ session('folks') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              @endif
                <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
                <input type="date"  class="form-control @error('tanggal_transaksi') is-invalid @enderror" id="tanggal_transaksi" placeholder="" value="{{ session('tgl_fix') }}" readonly>
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
                    <input type="text" class="form-control" id="supplier_id" readonly value="{{ $item->supplier->nama_supplier }}">
                </div>
               
            </div>

            <div class="col-sm-4 d-none">
                <label for="pembelian_id" class="form-label">Id Pembelian</label>
                <input type="text" name="pembelian_id" id="pembelian_id" class="form-control @error('pembelian_id') is-invalid @enderror" required value="{{ $item->id }}" readonly required>
                @if (old('pembelian_id'))
                @error('pembelian_id')
                <div class="invalid-feedback">
                {{ $message }}
                </div>
                @enderror
                @else
                <div class="invalid-feedback">
                Id Pembelian Pesanan Wajib Dilengkapi
                </div>
                @endif
               
            </div>

            <div class="d-none">
              <label for="">supplier_id</label>
              <input type="text" name="supplier_id" id="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror" required value="{{ $item->supplier_id }}" readonly required>
            </div>
            

            <div class="col-sm-4">
                <label for="barang_id" class="form-label">Produk</label>
                <input type="text" name="produk" id="produk" class="form-control @error('produk') is-invalid @enderror" required value="{{ old('produk') }}">
                @if (old('produk'))
                @error('produk')
                <div class="invalid-feedback">
                {{ $message }}
                </div>
                @enderror
                @else
                <div class="invalid-feedback">
                Produk Pesanan Wajib Dilengkapi
                </div>
                @endif
               
            </div>

            <div class="col-sm-3">
                <label for="qty" class="form-label">Qty</label>
                <input type="number" name="qty" class="form-control @error('qty') is-invalid @enderror" id="qty" placeholder=""   required value="{{ old('qty') }}">
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
           
            <div class="col-sm-3">
                <label for="harga_satuan" class="form-label">Harga Beli</label>
               <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="text" class="form-control @error('harga_beli') is-invalid @enderror"  name="harga_beli" required id="pay">
                @if (old('harga_beli'))
                @error('harga_beli')
                <div class="invalid-feedback">
                {{ $message }}
                </div>
                @enderror
                @else
                <div class="invalid-feedback">
                Harga Beli Wajib Dilengkapi
                </div>
                @endif
               </div>
              </div>

            <input type="text" class="form-control d-none" name="kode_produk">
          


        </div>
          @endforeach
            <button class="col-md-2 btn btn-primary btn-md mt-4" type="submit">Cek Harga Total</button>
            <button class="col-md-2 btn btn-danger btn-md mt-4" type="reset">Reset Form</button>
        </form>
    </div>
  </div>
@endsection