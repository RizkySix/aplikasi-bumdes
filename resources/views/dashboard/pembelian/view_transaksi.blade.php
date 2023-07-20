@extends('dashboard.main.main')

@section('container')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="text-center justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Transaksi Pembelian</h1>
      
    </div>  

  </main>

 @foreach ($pembelians as $pembelian)
 <div class="row w-100 mt-4">
    <div class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
        <form action="/pembelian/{{ $pembelian->kode_pembelian }}" method="POST" class="needs-validation" novalidate>
            @method('put')
            @csrf
               <div class="row g-3">
                <div class="col-sm-4">
                      <label for="tanggal_transaksi" class="form-label h5">Tanggal Transaksi :</label><br>
                      <span id="tanggal_transaksi" class="text-muted">
                        {{ date('d-M-Y', strtotime($pembelian->tanggal_transaksi)) }}
                      </span>
                  </div>
                <div class="col-sm-4">
                      <label for="pelanggan" class="form-label h5">Nama Supplier :</label><br>
                      <span id="pelanggan" class="text-muted">
                        @if ($pembelian->supplier_id != 0)
                        {{ $pembelian->supplier->nama_supplier }}
                        @else
                        Tidak Ada Supplier
                        @endif
                      </span>
                  </div>
                <div class="col-sm-4">
                      <label for="produk" class="form-label h5">Nama Produk :</label><br>
                      <span id="produk" class="text-muted">
                        {{ $pembelian->produk }}
                      </span>
                  </div>
                <div class="col-sm-4">
                      <label for="qty" class="form-label h5">Qty :</label><br>
                      <span id="qty" class="text-muted">
                     {{ $pembelian->qty }} Pcs
                      </span>
                     
                  </div>
                <div class="col-sm-4" id="sats">
                    <label for="harga_satuan" class="form-label h5">Harga Beli :</label><br>
                    <span id="qty" class="text-muted">
                        {{ $pembelian->harga_beli }}
                         </span>
                   </div>

    
                  <div class="col-sm-2" id="tots">
                    <label for="total" class="form-label h5">Harga Total :</label>
                   <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    @php
                        $imps = explode(' ', $pembelian->harga_beli);
                        $val = end($imps);
                        $vals = explode('.', $val);
                        $gocha = implode('', $vals);

                        $total = $gocha * $pembelian->qty;
                        $honto = number_format($total, 0);
                        $nani = explode(',', $honto);
                        $bakayaro = implode('.', $nani)
                      
                    @endphp
                    <input type="text" class="form-control" name="total_beli" id="total_beli" required  value="{{ $bakayaro }}">
                   </div>
                  </div>
                  
                  <script>
                    $("#tots").keydown(function(event) { 
                        return false;
                    });
                  </script>
    
    
                  <div class="col-sm-4">
                    <label for="pembayaran" class="form-label h5">Pembayaran :</label><br>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="text" id="pay" class="form-control  @error('pembayaran') is-invalid @enderror" name="pembayaran" required autofocus placeholder="Total bayar semua barang pada toko">
                        <div class="invalid-feedback">
                          Pembayaran Wajib Dilengkapi
                          </div>
                       </div>
                      
                  </div>
                  
                  
               </div>
                <button class="col-md-2 btn btn-primary btn-md mt-4" type="submit">Buat Pembelian</button>
            </form>
            <div style="display: absolute">
                <form action="/pembelian/{{ $pembelian->kode_pembelian }}" method="POST">
                    @csrf
                    @method('delete')
                    <button class="col-md-2 btn btn-danger btn-md mt-4" type="submit" style="transform: translate(105%, -162%)">Batalkan Pembelian</button>
                </form>
       
    </div>
  </div>
 @endforeach
@endsection