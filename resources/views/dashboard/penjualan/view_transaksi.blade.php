@extends('dashboard.main.main')

@section('container')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="text-center justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Transaksi Penjualan</h1>
      
    </div>  

  </main>

 @foreach ($penjualans as $penjualan)
 <div class="row w-100 mt-4">
    <div class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
        <form action="/penjualan/{{ $penjualan->kode_penjualan }}" method="POST" class="needs-validation" novalidate>
        @method('put')
        @csrf
           <div class="row g-3">
            <div class="col-sm-4">
                  <label for="tanggal_transaksi" class="form-label h5">Tanggal Transaksi :</label><br>
                  <span id="tanggal_transaksi" class="text-muted">
                    {{ date('d-M-Y', strtotime($penjualan->tanggal_transaksi)) }}
                  </span>
              </div>
            <div class="col-sm-4">
                  <label for="pelanggan" class="form-label h5">Nama Pelanggan :</label><br>
                  <span id="pelanggan" class="text-muted">
                   @if ($penjualan->user_id != 0 && $penjualan->user_id != 666)
                   {{ $penjualan->user->nama }}
                   @else
                   {{ $penjualan->pembeli }}
                   @endif
                  </span>
              </div>
            <div class="col-sm-4">
                  <label for="produk" class="form-label h5">Nama Produk :</label><br>
                  <span id="produk" class="text-muted">
                    <td>
                      @if ($penjualan->barang_id != 0)
                      {{ $penjualan->barang->nama_barang }}
                      @else
                      {{ $penjualan->nama_barang }}
                      @endif
                    </td>
                  </span>
              </div>
            <div class="col-sm-4">
                  <label for="note" class="form-label h5">Note :</label><br>
                  <span id="note" class="text-muted">
                   @if ($penjualan->note == 1)
                       Satuan
                       @else
                      Grosir
                   @endif
                  </span>
              </div>
            <div class="col-sm-4">
                  <label for="qty" class="form-label h5">Qty :</label><br>
                  <span id="qty" class="text-muted">
                 {{ $penjualan->qty }} Pcs
                  </span>
                 
              </div>
            <div class="col-sm-4">
                  <label for="pt" class="form-label h5">Petugas :</label><br>
                  <span id="pt" class="text-muted">
                 {{ $penjualan->petugas }} 
                  </span>
              </div>
            <div class="col-sm-4" id="sats">
                <label for="harga_satuan" class="form-label h5">Harga Satuan :</label>
               <div class="input-group">
                @php
                $string = $penjualan->barang->harga_jual;
                $cut = explode(' ', $string);
                $data = end($cut);
                $findAg = explode('.', $data);
                $findMo = implode('', $findAg);
             @endphp
                <span class="input-group-text">Rp</span>
                <input type="text" class="form-control"  name="harga_satuan" id="harga_satuan" required  value="{{ $data }}">
               </div>
              </div>

              <div class="col-sm-4" id="tots">
                <label for="total" class="form-label h5">Harga Total :</label>
               <div class="input-group">
                <span class="input-group-text">Rp</span>
                @if ($penjualan->note == 1)
                @php
                    $total = $findMo * $penjualan->qty;
                    $honto = number_format($total, 0);
                    $nani = explode(',', $honto);
                    $bakayaro = implode('.', $nani)
                  
                @endphp
                <input type="text" class="form-control" name="total" id="total" required  value="{{ $bakayaro }}">
                @else
                @php
                      $total = $findMo * $penjualan->qty;
                      $final = (5/100) * $total;
                      $result = $total - $final;
                      $gore =  number_format($result, 0);
                      $gone = explode(',',$gore);
                      $gonok = implode('.',$gone);

                @endphp
                <input type="text" class="form-control" name="total" id="total" required  value="{{ $gonok }}">
                @endif
               </div>
              </div>
              
              <script>
                $("#tots").keydown(function(event) { 
                    return false;
                });
                $("#sats").keydown(function(event) { 
                    return false;
                });
              </script>

              <div class="col-sm-2">
                <label for="pengirim" class="form-label h5">Pengirim :</label>
                <input type="text" id="pengirim" name="pengirim" class="form-control @error('pengirim') is-invalid @enderror" required value="{{ old('pengirim') }}">
                <div class="invalid-feedback">
                    Pengirim Wajib Dilengkapi
                    </div>
              </div>

              <div class="col-sm-4">
                <label for="pembayaran" class="form-label h5">Pembayaran :</label><br>
                <div class="input-group has-validation">
                    <span class="input-group-text">Rp</span>
                    <input type="text" id="pay" class="form-control @error('pembayaran') is-invalid @enderror" name="pembayaran" required autofocus>
                    <div class="invalid-feedback">
                      Pembayaran Wajib Dilengkapi
                      </div>
                   </div>
                  
              </div>

              <div class="col-sm-4">
                <label for="tujuan" class="form-label h5">Lokasi Pengiriman :</label><br>
                <div class="input-group has-validation">
                  <span class="input-group-text"><span data-feather="map-pin"></span></span>      
                  <input type="text" class="form-control @error('tujuan') is-invalid @enderror" name="tujuan" id="tujuan" required > 
                  <div class="invalid-feedback">
                    Lokasi Pengiriman Wajib Dilengkapi
                    </div>
                 </div>
                
                  
              </div>
              
              
           </div>
            <button class="col-md-2 btn btn-primary btn-md mt-4" type="submit" id="satu">Buat Pesanan</button>
            
        </form>
        <div style="display: absolute">
            <form action="/penjualan/{{ $penjualan->kode_penjualan }}" method="POST">
                @csrf
                @method('delete')
                <button class="col-md-2 btn btn-danger btn-md mt-4" type="submit" style="transform: translate(105%, -162%)">Batalkan Pesanan</button>
            </form>
        </div>
    </div>
  </div>
 @endforeach
@endsection