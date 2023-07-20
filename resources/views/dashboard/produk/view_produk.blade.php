@extends('dashboard.main.main')

@section('container')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="text-center justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Harga Total Produk</h1>
    </div>  

  </main>

  <div class="row w-100 mt-4">
    <div class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
        @foreach ($produks as $produk)
        <form action="/produk/{{ $produk->id }}" method="POST" class="needs-validation" novalidate>
        @method('put')
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
                <input type="date"  class="form-control @error('tanggal_transaksi') is-invalid @enderror" id="tanggal_transaksi" placeholder="" value="{{ $produk->pembelian->tanggal_transaksi }}" readonly>
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
                    <input type="text" class="form-control" id="supplier_id" readonly value="{{ $produk->pembelian->supplier->nama_supplier }}">
                </div>
               
            </div>

            <div class="col-sm-4 d-none">
                <label for="pembelian_id" class="form-label">Id Pembelian</label>
                <input type="text" id="pembelian_id" class="form-control @error('pembelian_id') is-invalid @enderror"  value="{{ $produk->pembelian_id }}" readonly required>
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

            <div class="col-sm-4">
                <label for="barang_id" class="form-label">Produk</label>
                <input type="text" id="produk" class="form-control @error('produk') is-invalid @enderror" required value="{{ $produk->produk }}" readonly>
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

            <div class="col-sm-2">
                <label for="qty" class="form-label">Qty</label>
                <input type="number" class="form-control @error('qty') is-invalid @enderror" id="qty" placeholder=""   required value="{{ $produk->qty }}" readonly>
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

            <div class="col-sm-2">
                <label for="harga_satuan" class="form-label">Harga Beli</label>
               <div class="input-group">
                @php
                    $bol = explode(' ', $produk->harga_beli);
                    $bol = end($bol);

                    $deka = explode('.' , $bol);
                    $deka = implode('' , $deka);
                @endphp
                <span class="input-group-text">Rp</span>
                <input type="text" class="form-control @error('harga_beli') is-invalid @enderror" required id="pay" value="{{ $bol }}" readonly>
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

              <div class="col-sm-2" id="tots">
                <label for="total" class="form-label h5">Harga Total :</label>
               <div class="input-group">
                <span class="input-group-text">Rp</span>
                @php
                   
                    $total = $deka * $produk->qty;
                    $honto = number_format($total, 0);
                    $nani = explode(',', $honto);
                    $bakayaro = implode('.', $nani)
                  
                @endphp
                <input type="text" class="form-control" name="total_beli" id="total_beli" required  value="{{ $bakayaro }}" readonly>
               </div>
              </div>



        </div>
         
            <button class="col-md-2 btn btn-primary btn-md mt-4" type="submit">Tambah produk</button>
            <button class="col-md-2 btn btn-danger btn-md mt-4" type="reset">Batalkan produk</button>
        </form>
        <div style="display: absolute">
            <form action="/produk/{{ $produk->id }}" method="POST">
                @csrf
                @method('delete')
                <button class="col-md-2 btn btn-danger btn-md mt-4" type="submit" style="transform: translate(105%, -162%)">Batalkan Produk</button>
            </form>
        </div>
    </div>
  </div>
  @endforeach
@endsection