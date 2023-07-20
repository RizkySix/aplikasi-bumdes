@extends('dashboard.main.main')

@section('container')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="text-center justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Detail Pembelian</h1>
      <p class="h5">Kode Pembelian : {{ $pembelian->kode_pembelian }}</p>
      
    </div>  

  </main>

  <div class="row w-100 mt-4">
    <div class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
        <form action="/pembelian/{{ $pembelian->kode_pembelian }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        @method('put')
        @csrf
        <div class="row g-3 justify-content-center">
            <div class="col-sm-8">
                  <label for="tanggal_transaksi" class="form-label h5">Tanggal Transaksi :</label><br>
                  <span id="tanggal_transaksi" class="text-muted">
                    {{ date('d-M-Y', strtotime($pembelian->tanggal_transaksi)) }}
                  </span>
              </div>
            <div class="col-sm-2">
                  <label for="pelanggan" class="form-label h5">Supplier :</label><br>
                  <span id="pelanggan" class="text-muted">
                   @if ($pembelian->supplier_id != 0)
                   {{ $pembelian->supplier->nama_supplier }}
                   @else
                   Tidak Ada Supplier
                   @endif
                  </span>
              </div>
            <div class="col-sm-3">
                  <label for="produk" class="form-label h5">Nama Produk :</label><br>
                  <span id="produk" class="text-muted">
                   @foreach ($allPembelian as $prod)
                       {{ $prod->produk }} <br>
                   @endforeach
                  </span>
              </div>
            <div class="col-sm-2">
                  <label for="qty" class="form-label h5">Qty :</label><br>
                  <span id="qty" class="text-muted">
                    @foreach ($allPembelian as $qty)
                        {{ $qty->qty }} Pcs <br>
                    @endforeach
                  </span>
                 
              </div>
            <div class="col-sm-3" id="sats">
                <label for="harga_satuan" class="form-label h5">Harga Beli :</label><br>
                <span id="qty" class="text-muted">
                   @foreach ($allPembelian as $beli)
                       {{ $beli->harga_beli }} <br>
                   @endforeach
                     </span>
               </div>


              <div class="col-sm-2" id="tots">
                <label for="total" class="form-label h5">Harga Total :</label> <br>
                <span class="text-muted">
                    @php
                        $bigTot = 0;
                    @endphp
                    @foreach ($allPembelian as $tot)
                        {{ $tot->total_beli }}<br>
                        @php
                            $gosh = explode(' ',$tot->total_beli);
                            $lash = end($gosh);
                            $yeasu = explode('.',$lash);
                            $plode = implode('', $yeasu);

                            $bigTot += $plode;
                        @endphp
                    @endforeach
                </span>
               
              </div>
              
              <script>
                $("#tots").keydown(function(event) { 
                    return false;
                });
              </script>

              <div class="col-sm-8">
                <label for="big_total" class="form-label h5">Total Pembayaran :</label>
              </div>

              <div class="col-sm-2">
                <div class="input-group" style="height: 25px">
                    @php
                        $bTot = number_format($bigTot , 0);
                        $noTot = explode(',' , $bTot);
                        $thisTot = implode('.' , $noTot);

                        $forSis = implode('' , $noTot);
                    @endphp
                    @if ($pembelian->status == 0)
                    <span class="input-group-text">Rp</span>
                    <input type="text" class="form-control text-muted" id="tot_bay" name="big_total" required readonly value="{{ $thisTot }}">
                    @else
                    <span class="text-muted">
                       Rp {{ $thisTot }}
                    </span>
                    @endif
                </div>
              </div>

              <script>
                $("#tot_bay").keydown(function(event) { 
                    return false;
                });
              </script>

              <div class="col-sm-4">
                <label for="sisa" class="form-label h5">Sisa Pembayaran :</label><br>
                @php
                    $getSis = explode(' ', $pembelian->pembayaran);
                    $fend = end($getSis);
                    $moreSis = explode('.' , $fend);
                    $moreSis2 = implode('' , $moreSis);

                    $theSisa = $forSis - $moreSis2;
                    $theSisa2 = number_format($theSisa , 0);

                    $theSisa2 = explode(',' , $theSisa2);
                    $theSisa2 = implode('.' , $theSisa2);
                @endphp
                @if ($moreSis2 >= $forSis)
                <span class="text-muted">
                    {{ "Rp 0.000" }}
                </span>
                @else
                <span class="text-muted">
                   Rp {{ $theSisa2 }}
                </span>
                @endif
              </div>

              <div class="col-sm-4">
                <label for="status" class="form-label h5">Status :</label><br>
                @if ($moreSis2 >= $forSis)
                <span class="text-muted">
                  Lunas
                </span>
                @else
                <span class="text-muted">
                   Belum Lunas
                </span>
                @endif
              </div>

              <div class="col-sm-2">
                <label for="pembayaran" class="form-label h5">Pembayaran :</label><br>
               @if ($pembelian->status == 0)
               <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="text" id="pay" class="form-control  @error('pembayaran') is-invalid @enderror" name="pembayaran" required autofocus >
                <div class="invalid-feedback">
                  Pembayaran Wajib Dilengkapi
                  </div>
               </div>
               @else
                <span class="text-muted">Pembayaran Selesai</span>
               @endif
                  
              </div>

              <div class="row g-3">
                <div class="col-sm-3" style="margin-left : 8%">
                <label for="nota" class="form-label h5">Nota Pembayaran :</label> <br>
                @if ($pembelian->nota)
                 <div style=" max-height: 350px; overflow:hidden" class="mb-2">
                  <img src="{{ asset('storage/' . $pembelian->nota) }}" alt="" class="img-preview img-fluid mt-3">
                 </div>
                @else
                  <div class="mb-2" style="max-height: 350px; overflow:hidden">
                    <img src="/images/kosong.jpg" class="img-preview img-fluid">
                  </div>
                @endif
                  
             

                <input type="file" name="nota" id="nota" class="form-control  @error('nota') is-invalid @enderror" onchange="previewImage()">
                @error('nota')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
                </div>

                <script>
                 function previewImage()
                  {
                    const nota = document.querySelector('#nota');
                /*     const none = document.querySelector('#none');  */
                    const imgPreview = document.querySelector('.img-preview');

                    imgPreview.style.display = 'block';
                /*     none.style.display = 'none'; */
                   
                  
                    const blob = URL.createObjectURL(nota.files[0]);
                    imgPreview.src = blob;
                  }
                </script>

              </div>

              <div class="col-sm-10 mb-3">
              
                <button class="col-md-2 btn btn-primary btn-md mt-4" type="submit">Ubah Pesanan</button>
                <button class="col-md-2 btn btn-danger btn-md mt-4" type="reset">Reset Form</button>
               
            </div>
           </div>
          
        </form>
    </div>
  </div>
</div>
@endsection