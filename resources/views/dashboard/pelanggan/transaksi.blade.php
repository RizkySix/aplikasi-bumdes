@extends('dashboard.main.main')

@section('midtrans')
     <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
     <script type="text/javascript"
     src="https://app.sandbox.midtrans.com/snap/snap.js"
     data-client-key="SB-Mid-client-eoxKdd_O3x1--7pt"></script>
   <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
@endsection

@section('container')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="text-center justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Total Pemesanan Barang</h1>
    </div>  

  </main>

  <div class="row w-100 mt-4">
    <div class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
        <form action="/pelanggan/transaksi" method="POST" class="needs-validation" novalidate>
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
                    <input type="date" name="tanggal_transaksi" class="form-control @error('tanggal_transaksi') is-invalid @enderror" id="tanggal_transaksi" placeholder=""  value="{{ request('tanggal_transaksi') }}" readonly>
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
                    <input type="text" class="form-control d-none" name="barang_id" value="{{ request('barang_id') }}" readonly required>
                    @foreach ($produk as $item)
                    <input type="text" class="form-control"  value="{{ $item->nama_barang }}" readonly required>
                    @endforeach
                   </div>
                   
                </div>

                <div class="col-sm-3">
                    <label for="note" class="form-label">Note</label>
                   <select name="note" id="note" class="form-select">
                   @if (request('note') == 1)
                   <option value="1" selected>Satuan</option>
                   @else
                    <option value="2" id="grosir" selected>Grosir</option>
                   @endif
                   </select>
                </div>

                <div class="col-sm-3">
                    <label for="qty" class="form-label">Qty</label>
                    <input type="text" name="qty" class="form-control @error('qty') is-invalid @enderror"  placeholder="" required value=" {{ request('qty') }}" readonly>
                  
                </div>

               
                <div class="col-sm-10">
                  <label for="tujuan" class="form-label">Lokasi Pengiriman</label>
                  <div class="input-group ">
                    <span class="input-group-text"><span data-feather="map-pin"></span></span>
                    <input type="text" name="tujuan" class="form-control @error('tujuan') is-invalid @enderror" id="tujuan" placeholder=""   required value="{{ request('tujuan') }}" readonly>
                  </div>
                
              </div>

                @foreach ($produk as $item2)
                <input type="text" class="d-none" name="harga_beli" readonly required value="{{ $item2->harga_beli }}">
                <div class="col-sm-3">
                    <label for="qty" class="form-label">Harga Satuan</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        @php
                            $harjug = explode(' ', $item2->harga_jual);
                            $harjug = end($harjug);
                        @endphp
                        <input type="text" name="harga_satuan" class="form-control" required value="{{ $harjug }}" readonly>
                    </div>
                  
                </div>

                <div class="col-sm-3">
                    <label for="qty" class="form-label">Harga Total</label>
                   <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    @if (request('note') == 1)
                    @php
                    $tot = explode(' ', $item2->harga_jual);
                    $tot = end($tot);
                    $tot = explode('.', $tot);
                    $tot = implode('', $tot);

                    $final_tot = $tot * request('qty');
                    $fitot = number_format($final_tot, 0);
                    $fitot = explode(',' , $fitot);
                    $fitot = implode('.' , $fitot);
                @endphp
                <input type="text" name="total" class="form-control" required value="{{ $fitot }}" readonly>
                @else
                    @php
                     $tot = explode(' ', $item2->harga_jual);
                    $tot = end($tot);
                    $tot = explode('.', $tot);
                    $tot = implode('', $tot);


                    $total =  $tot * request('qty');
                    $final = (5/100) * $total;
                    $result = $total - $final;
                    $gore =  number_format($result, 0);
                    $gone = explode(',',$gore);
                    $gonok = implode('.',$gone);

                    @endphp
                      <input type="text" class="form-control" name="total" id="total" required  value="{{ $gonok }}" readonly>
                    @endif
                   </div>
                  
                </div>
                @endforeach

                <input type="text" class="form-control d-none" name="kode_penjualan">


            </div>
            <button class="col-md-2 btn btn-primary btn-md mt-4" type="submit">Buat Pesanan</button>
           <a href="/dashboard" class="col-md-2 btn btn-danger btn-md mt-4">Batalkan Pesanan</a>
        </form>
        <button class="col-md-2 btn btn-primary btn-md mt-4" type="submit" id="pay-button">Buat Midtrans</button>
    <script type="text/javascript">
      // For example trigger on button clicked, or any time you need
      var payButton = document.getElementById('pay-button');
      payButton.addEventListener('click', function () {
        // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
        window.snap.pay('{{ $snapToken }}');
        // customer will be redirected after completing payment pop-up
      });
    </script>
    </div>
  </div>
@endsection