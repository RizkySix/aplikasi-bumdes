@extends('dashboard.main.main')

@section('container')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="text-center justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Form Tambah Data Barang</h1>
      <form action="/barang/create" method="GET" >
        <div class="input-group mb-1 w-50 m-auto">
          <input type="text" class="form-control bg-light border border-dark" placeholder="Cari berdasarkan nama supplier..." name="search" value="{{ request('search') }}" autofocus>
          <button class="btn btn-danger text-white btn-outline-primary" type="submit" id="button-addon2">Search</button>
        </div>
      </form>
    </div>  

  </main>

  <div class="row w-100 mt-4">
    <div class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
        <form action="/barang" method="POST"  class="needs-validation" novalidate id="form_barang" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-sm-10">
                    <label for="produk_id" class="form-label">Nama Barang</label>
                    <select name="produk_id" id="produk_id" class="form-select" required onmousedown="if(this.options.length>5){this.size=5;}" onchange='this.size=0;' onblur="this.size=0;">
                      @if ($produks->count())
                    
                     
                      @foreach ($produks as $produk)
                     
                      <option value="{{ $produk->id }}" data-toggle="tooltip" data-placement="top" title="Stok tersedia {{ $produk->qty }} / Harga Beli {{ $produk->harga_beli }} / Supplier ({{ $produk->pembelian->supplier->nama_supplier }})" {{ old('produk_id') == $produk->id ? 'selected':''}}>{{ $produk->produk }}
                      </option>
                      @endforeach
                      @else
                      <option value="none" disabled selected>Tidak Ada Barang Baru</option>
                      @endif
                     </select>
                    @if (old('produk_id'))
                    @error('produk_id')
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
  
                <div class="col-sm-10 d-none">
                    <label for="kode_barang" class="form-label">Kode Barang</label>
                    <input type="text" name="kode_barang" class="form-control @error('kode_barang') is-invalid @enderror" id="kode_barang" placeholder=""  value="{{ old('kode_barang') }}" minlength="8">
                    @if (old('kode_barang'))
                    @error('kode_barang')
                    <div class="invalid-feedback">
                    {{ $message }}
                    </div>
                    @enderror
                    @else
                    <div class="invalid-feedback">
                    Kode Barang Wajib Dilengkapi
                    </div>
                    @endif
                </div>
  
                <div class="col-sm-5">
                    <label for="harga_beli" class="form-label">Harga Beli</label>
                    <div class="input-group has-validation">
                      <span class="input-group-text">Rp</span>
                      <input type="text" class="form-control  @error('harga_beli') is-invalid @enderror" id="pay" placeholder="10.000" name="harga_beli" value="{{ old('harga_beli') }}" required>
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
                      <span class="input-group-text">Rp</span>
                      <input type="text" class="form-control  @error('harga_jual') is-invalid @enderror" id="pay2" placeholder="15.000" name="harga_jual" value="{{ old('harga_jual') }}" required>
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
                    <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" placeholder="20"   required value="{{ old('jumlah') }}">
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
                    <input type="number" name="sisa" class="form-control @error('sisa') is-invalid @enderror" id="sisa" placeholder="19"   required value="{{ old('sisa') }}">
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
  
                <div class="col-sm-10">
                  <label for="supplier_id" class="form-label">Supplier <span class="text-muted">(Silahkan cari nama supplier terlebih dahulu)</span></label>
                  <div class="input-group has-validation">
                   <span class="input-group-text"><span data-feather="truck"></span></span>
                  
                   <select name="supplier_id" id="supplier_id" class="form-select" required onmousedown="if(this.options.length>5){this.size=5;}" onchange='this.size=0;' onblur="this.size=0;">
                    @if ($supplier->count())
                    @foreach ($supplier as $item)
                        <option value="{{ $item->id }}" {{ old('supplier_id') == $item->id ? 'selected':''}}>{{ $item->nama_supplier }}</option>
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
                <img class="img-preview img-fluid" style=" max-height: 250px; overflow:hidden">
                <input type="file" class="form-control mt-2  @error('image') is-invalid @enderror" name="image" id="image" onchange="previewImage()">
                @error('image')
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
               </script>
  
            </div>
            
            <button class="col-md-2 btn btn-primary btn-md mt-4" type="submit">Tambah Barang</button>
            <button class="col-md-2 btn btn-danger btn-md mt-4" type="reset">Reset Form</button>
            
        </form>
    </div>
  </div>
@endsection