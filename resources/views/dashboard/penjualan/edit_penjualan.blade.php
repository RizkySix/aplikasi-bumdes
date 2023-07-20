@extends('dashboard.main.main')

@section('container')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="text-center justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Detail Penjualan</h1>
      <p class="h5">Kode Penjualan : {{ $penjualan->kode_penjualan }}</p>
      
    </div>  

  </main>

  <div class="row w-100 mt-4">
    <div class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
        <form action="/penjualan/{{ $penjualan->kode_penjualan }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
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
                    @if ($penjualan->barang_id != 0)
                    {{ $penjualan->barang->nama_barang }}
                    @else
                    {{ $penjualan->nama_barang }}
                    @endif
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
                  @if ($penjualan->petugas)
                  <span id="pt" class="text-muted">
                    {{ $penjualan->petugas }} 
                     </span>
                     @else
                     <span class="text-muted">Belum Diproses</span>
                  @endif
              </div>
            <div class="col-sm-4" id="sats">
                <label for="harga_satuan" class="form-label h5">Harga Satuan :</label><br>
             
                @php
                $string = $penjualan->harga_satuan;
                $cut = explode(' ', $string);
                $data = end($cut);
                $morp = explode('.', $data);
                $morps = implode('', $morp);
             @endphp
                <span class="text-muted">Rp {{ $data }}</span>
               
              </div>

              <div class="col-sm-4" id="tots">
                <label for="total" class="form-label h5">Harga Total :</label><br>
             
                @if ($penjualan->note == 1)
                @php
                    $total = $morps * $penjualan->qty;
                    $morl = number_format($total, 0);
                    $morh = explode(',',$morl);
                    $mors = implode('.',$morh);
                @endphp
                  <span class="text-muted">Rp {{ $mors }}</span>
                @else
                @php
                      $total = $morps * $penjualan->qty;
                      $final = (5/100) * $total;
                      $result = $total - $final;
                      $resol =  number_format($result, 0);
                      $rawr = explode(',',$resol);
                      $rosh = implode('.', $rawr);
                     
                @endphp
               <span class="text-muted">Rp {{ $rosh }}</span>
                @endif
              
              </div>
              
              <script>
                $("#tots").keydown(function(event) { 
                    return false;
                });
                $("#sats").keydown(function(event) { 
                    return false;
                });
              </script>

                <div class="col-sm-3">
                    <label for="pengirim" class="form-label h5">Sisa Pembayaran :</label><br>
                <span class="text-capitalize text-muted">
                @php
                        $findSisa = $penjualan->pembayaran;
                        $cutSisa = explode(' ', $findSisa);
                        $gotit = end($cutSisa);
                        $moreExp = explode('.' , $gotit);
                        $moreImp = implode('' , $moreExp);

                        $findTotal = $penjualan->total;
                        $cutTotal = explode(' ', $findTotal);
                        $gotit2 = end($cutTotal);
                        $moreExp2 = explode('.' , $gotit2);
                        $moreImp2 = implode('' , $moreExp2);

                        $sisa = $moreImp2 - $moreImp;
                        $soda = number_format($sisa, 0);
                        $shes = explode(',',$soda);
                        $slash = implode('.',$shes);
                @endphp
               @if ($penjualan->status == 1)
                   Rp 0.000
                   @else
                   Rp {{ $slash }}
               @endif
                </span>
                </div>

              @if ($penjualan->status == true)
              <div class="col-sm-4 d-none">
                <label for="pembayaran" class="form-label h5">Pembayaran :</label><br>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="text" id="pay" class="form-control  @error('pembayaran') is-invalid @enderror" name="pembayaran"  autofocus>
                    <div class="invalid-feedback">
                      Pembayaran Wajib Dilengkapi
                      </div>
                   </div>                
              </div>
              @else
              <div class="col-sm-4">
                <label for="pembayaran" class="form-label h5">Pembayaran :</label><br>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="text" id="pay" class="form-control  @error('pembayaran') is-invalid @enderror" name="pembayaran"  autofocus>
                    <div class="invalid-feedback">
                      Pembayaran Wajib Dilengkapi
                      </div>
                   </div>                
              </div>
              @endif

              <div class="col-sm-4">
                <label for="pengirim" class="form-label h5">Pengirim :</label><br>
                @if ($penjualan->pengirim)
                <span class="text-capitalize">
                  {{ $penjualan->pengirim }}
              </span>
              @else
                <input type="text" class="form-control" name="pengirim" id="pengirim" required value="{{ old('pengirim') }}">
                <div class="invalid-feedback">
                  Pengirim Wajib Dilengkapi
                  </div>
                @endif
                </div>
              <div class="col-sm-4">
                <label for="pengirim" class="form-label h5">Status :</label><br>
                <span class="text-capitalize">
                  @if ($penjualan->status == 1)
                      Lunas
                      @else
                      Belum Lunas
                  @endif
                </span>
                </div>

                <div class="col-sm-4">
                  <label for="lok" class="form-label h5">Lokasi Pengiriman :</label><br>
                  <span class="text-muted">{{ $penjualan->tujuan }}</span>
                </div>

                <div class="col-sm-4">
                  <label for="detail" class="form-label h5">Detail Pesanan :</label><br>
                  @if ($penjualan->detail == "Selesai")
                   <span class="text-muted">{{ $penjualan->detail }}</span>
                  @else
                  <select name="detail" id="dtl" class="form-select">
                    @if ($penjualan->detail == "Dikirim")
                        <option value="Selesai">Selesai</option>
                        <option value="Dikirim" selected>Dikirim</option>
                        <option value="Dipesan">Dipesan</option>
                    @endif
                    @if ($penjualan->detail == "Dipesan")
                        <option value="Selesai">Selesai</option>
                        <option value="Dikirim">Dikirim</option>
                        <option value="Dipesan" selected>Dipesan</option>
                    @endif
                  </select>
                  @endif
                  </div>

                  <div class="col-sm-4">
                    <label for="hp" class="form-label h5">No.Hp :</label><br>
                   @if ($penjualan->user_id !== 0 && $penjualan->user_id != 666)
                   <span class="text-muted">{{ $penjualan->user->no_hp }}</span>
                   @else
                   No.Hp Tidak Tersedia
                   @endif
                  </div>
                  
                  <div class="col-sm-10 ">
                    <label for="hp" class="form-label h5">Bukti Barang Diterima</label><br>
                    @if ($penjualan->bukti_gambar)
                    <div class="d-flex">
                      <img src="{{ asset('storage/' . $penjualan->bukti_gambar) }}" class="img-preview img-fluid d-block mb-3" style=" max-height: 250px; overflow:hidden">
                    @if ($penjualan->detail == "Selesai")
                    <a href="#" id="edit_img" class="d-flex align-items-center" style="margin-left:10px">Edit gambar</a>
                    @endif
                    </div>
                    @else
                    <img src="/images/kosong.jpg" class="img-preview img-fluid d-block" style=" max-height: 250px; overflow:hidden">
                    @endif
                    <input type="file" class="form-control mt-2 w-25 @error('bukti_gambar') is-invalid @enderror" name="bukti_gambar" id="image" onchange="previewImage()"  @if ($penjualan->bukti_gambar && $penjualan->detail == "Selesai")
                       style="display: none;"
                    @endif >
                    @error('bukti_gambar')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>


                  <script>
                    function previewImage()
                     {
                       const image = document.querySelector('#image');
                       const imgPreview = document.querySelector('.img-preview');
    
                       imgPreview.style.display = 'block';
                      
                     
                       const blob = URL.createObjectURL(image.files[0]);
                       imgPreview.src = blob;
                     }

                     $(document).ready(function(){
                        $('#edit_img').click(function(e){
                          e.preventDefault();
                          $('#image').show();
                          $('#btnbtn').show();
                        });
                     });

                   </script>

                 

         
           </div>
           @if ($penjualan->status == 1 && $penjualan->detail == "Selesai" && $penjualan->bukti_gambar != null)
           <div id="btnbtn" style="display: none">
            <button class="col-md-2 btn btn-primary btn-md mt-4 " type="submit">Ubah Pesanan</button>
            <button class="col-md-2 btn btn-danger btn-md mt-4 " type="reset">Reset Form</button>
           </div>
           @else
           <button class="col-md-2 btn btn-primary btn-md mt-4 mb-2" type="submit">Ubah Pesanan</button>
           <button class="col-md-2 btn btn-danger btn-md mt-4 mb-2" type="reset">Reset Form</button>
           @endif
        </form>
    </div>
  </div>
</div>
@endsection