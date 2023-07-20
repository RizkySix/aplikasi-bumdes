@extends('dashboard.main.main')

@section('container')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="text-center justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Form Ubah Data Barang</h1>
      <form action="/barang/{{ $barang->kode_barang }}/edit" method="GET" >
        <div class="input-group mb-1 w-50 m-auto">
          <input type="text" class="form-control bg-light border border-dark" placeholder="Cari berdasarkan nama supplier..." name="search" value="{{ request('search') }}" autofocus>
          <button class="btn btn-danger text-white btn-outline-primary" type="submit" id="button-addon2">Search</button>
        </div>
      </form>
      @if (session()->has('success_mail'))
      <div class="alert alert-success alert-dismissible fade show w-25" role="alert">
      {{ session('success_mail') }}
       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>
      @endif
    </div>  
  </main>

  <div class="row w-100 mt-4">
    <div class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
        <form action="/barang/{{ $barang->kode_barang }}" method="POST"  class="needs-validation" novalidate enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="row g-3">
                <div class="row g-3">
                    <div class="col-sm-10">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror" id="nama_barang" placeholder=""   required value="{{ old('nama_barang', $barang->nama_barang) }}">
                        @if (old('nama_barang'))
                        @error('nama_barang')
                        <div class="invalid-feedback">
                        {{ $message }}
                        </div>
                        @enderror
                        @else
                        <div class="invalid-feedback">
                        Nama Barang Wajib Dilengkapi
                        </div>
                        @endif
                    </div>
    
                    <div class="col-sm-5">
                        <label for="harga_beli" class="form-label">Harga Beli</label>
                        <div class="input-group has-validation">
                            @php
                               $string = $barang->harga_beli;
                               $cut = explode(' ', $string);
                               $data = end($cut);
                            
                            @endphp
                          <span class="input-group-text">Rp</span>
                          <input type="text" class="form-control  @error('harga_beli') is-invalid @enderror" id="pay" placeholder="10.000" name="harga_beli" value="{{ old('harga_beli', $data ) }}" required>
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
    
                    <div class="col-sm-5">
                        <label for="harga_jual" class="form-label">Harga Jual</label>
                        <div class="input-group has-validation">
                            @php
                            $string2 = $barang->harga_jual;
                            $cut2 = explode(' ', $string2);
                            $data2 = end($cut2);
                          
                         @endphp
                          <span class="input-group-text">Rp</span>
                          <input type="text" class="form-control  @error('harga_jual') is-invalid @enderror" id="pay2" placeholder="15.000" name="harga_jual" value="{{ old('harga_jual', $data2 ) }}" required>
                          @if (old('harga_jual'))
                          @error('harga_jual')
                          <div class="invalid-feedback">
                          {{ $message }}
                          </div>
                          @enderror
                          @else
                          <div class="invalid-feedback">
                          Harga Jual Wajib Dilengkapi
                          </div>
                          @endif
                        </div>

                        <script>
                          $('#pay2').keyup(function(event) {
    
                          // skip for arrow keys
                          if(event.which >= 37 && event.which <= 40) return;
    
                          // format number
                          $(this).val(function(index, value) {
                            return value
                            .replace(/\D/g, "")
                            .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                            ;
                          });
                          });
    
                          const pay2 =  document.querySelector("#pay2")
                          pay2.addEventListener("keypress", function (evt) {
                          if (evt.which < 48 || evt.which > 57)
                          {
                              evt.preventDefault();
                          }
                          });
                        </script>
                    </div>
    
                    <div class="col-sm-5">
                        <label for="jumlah" class="form-label">Jumlah Stok</label>
                        <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" placeholder="20"   required @if(request('jumlah')) value="{{ request('jumlah') }}"  @else value="{{ old('jumlah', $barang->jumlah) }}" @endif data-toggle="tooltip" data-placement="bottom" title="Restok bulan ini (tambah jumlah barang yang lama dengan yang terbaru), Restok bulan berikutnya (masukan kembali jumlah barang terbaru)">
                        @if (old('jumlah'))
                        @error('jumlah')
                        <div class="invalid-feedback">
                        {{ $message }}
                        </div>
                        @enderror
                        @else
                        <div class="invalid-feedback">
                        Jumlah Stok Wajib Dilengkapi
                        </div>
                        @endif
                    </div>
                    
                    
                    <div class="col-sm-5">
                        <label for="sisa" class="form-label">Sisa Stok</label>
                        <input type="number" name="sisa" class="form-control @error('sisa') is-invalid @enderror" id="sisa" placeholder="19"   required @if(request('sisa')) value="{{ request('sisa') }}"  @else value="{{ old('sisa', $barang->sisa) }}" @endif data-toggle="tooltip" data-placement="bottom" title="Restok bulan ini (tambah sisa barang yang lama dengan yang terbaru), Restok bulan berikutnya (masukan kembali sisa barang terbaru)">
                        @if (old('sisa'))
                        @error('sisa')
                        <div class="invalid-feedback">
                        {{ $message }}
                        </div>
                        @enderror
                        @else
                        <div class="invalid-feedback">
                        Sisa Stok Wajib Dilengkapi
                        </div>
                        @endif
                    </div>

                    <script>
                      $(document).ready(function(){
                          $('#jumlah').tooltip();
                          $('#sisa').tooltip();
                        });
                    </script>
                    <div class="col-sm-10">
                        <label for="supplier_id" class="form-label">Supplier <span class="text-muted">(Silahkan cari nama supplier terlebih dahulu)</span></label>
                        <div class="input-group has-validation">
                         <span class="input-group-text"><span data-feather="truck"></span></span>
                          <select name="supplier_id" id="supplier_id" class="form-select" required onmousedown="if(this.options.length>5){this.size=5;}" onchange='this.size=0;' onblur="this.size=0;">{{-- code js untuk membatasi jumlah value select dari http://jsfiddle.net/aTzc2/ --}}
                            @if ($supplier->count())
                            @if ($barang->supplier_id == 0 && !request('search'))
                            <option value="0" selected>Tidak Ada Supplier <span class="text-muted">(Silahkan pilih kembali supplier)</span></option>
                             @endif
                               @foreach ($supplier as $item)
                              @if ($item->id == $barang->supplier_id)
                              <option value="{{ $item->id }}" selected>{{ $item->nama_supplier }}</option>
                              @else
                              <option value="{{ $item->id }}">{{ $item->nama_supplier }}</option>
                              @endif
                               @endforeach
                               @else
                               <option value="none" disabled selected>Nama Supplier Tidak Ditemukan</option>
                               @endif
                          </select>
                          @if (old('supplier_id'))
                          @error('supplier_id')
                          <div class="invalid-feedback">
                          {{ $message }}
                          </div>
                          @enderror
                          @else
                          <div class="invalid-feedback">
                          Nama Supplier Wajib Dilengkapi
                          </div>
                          @endif
                        </div>
                    </div>

                    <div class="col-sm-10">
                      <label for="image" class="form-label">Foto Produk</label>
                      @if ($barang->image)
                          <img src="{{ asset('storage/' . $barang->image) }}" class="img-preview img-fluid d-block" style=" max-height: 250px; overflow:hidden">
                      @else
                      <img src="/images/kosong.jpg" class="img-preview img-fluid d-block" style=" max-height: 250px; overflow:hidden">
                      @endif
                      <input type="file" class="form-control mt-2  @error('image') is-invalid @enderror" name="image" id="image" onchange="previewImage()">
                      @error('image')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>
                    <p class="text-muted">( Data barang diperbarui {{ $barang->updated_at->diffForHumans() }} oleh {{ $barang->petugas }} )</p>
                    
                    @if (session('barang_!laku'))
                    <p class="text-muted">Barang sudah tidak terjual selama satu bulan belakangan, silahkan <a href="/retur/create">Retur</a> jika diperlukan</p>
                        
                    @endif
                    <script>
                      function previewImage()
                       {
                         const image = document.querySelector('#image');
                         const imgPreview = document.querySelector('.img-preview');
      
                         imgPreview.style.display = 'block';
                        
                       
                         const blob = URL.createObjectURL(image.files[0]);
                         imgPreview.src = blob;
                       }
                     </script>

                </div>
                
             
            </div>
            <input type="hidden" name="param_sisa" value="{{ $barang->sisa }}">
            <button class="col-md-2 btn btn-primary btn-md mt-4 mb-3" id="hoff" type="submit">Ubah Barang</button>
            <button class="col-md-2 btn btn-danger btn-md mt-4 mb-3" type="reset">Reset Form</button>
        </form>
    </div>
  </div>
@endsection