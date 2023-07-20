@extends('dashboard.main.main')

@section('container')
       

  
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="text-center justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">BUMDES Sad Mertha Nadi</h1>
          <p class="text-muted">Jl.Jurusan Baturiti-Meliling, Kerambitan, Tabanan, Bali</p>
         
        <!-- Button trigger modal -->
<div class="position-relative">
  <button class="btn btn-success d-block position-absolute rounded-circle" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="top:-55px; left:10px;">
    <span data-feather="user"></span>
  </button>
</div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Update Profile</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            @foreach ($users as $user)
        <form action="/updateprofile/{{ $user->slug }}" method="POST" class="needs-validation" novalidate>
          @method('put')
          @csrf
          <div class="container">
            <div class="row">
              <div class="col-sm-12 mb-3">
                <label for="firstName" class="form-label h5">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control text-center  @error('nama') is-invalid @enderror" id="nama" placeholder=""   required value="{{ old('nama' , $user->nama ) }}" minlength="8">
               @if (old('nama'))
               @error('nama')
               <div class="invalid-feedback">
                {{ $message }}
               </div>
               @enderror
               @else
               <div class="invalid-feedback">
                Nama Lengkap Wajib Dilengkapi
              </div>
               @endif
               
              </div>
              <div class="col-sm-5 d-none">
                <label for="firstName" class="form-label h5">Slug</label>
                <input type="text" name="slug" class="form-control  @error('slug') is-invalid @enderror" id="slug" placeholder="" required value="{{ $user->slug }}">
               @if (old('slug'))
               @error('slug')
               <div class="invalid-feedback">
                {{ $message }}
               </div>
               @enderror
               @else
               <div class="invalid-feedback">
                slug Lengkap Wajib Dilengkapi
              </div>
               @endif
               
              </div>
      
              <div class="col-sm-12 mb-3 ">
                <label for="lastName" class="form-label h5">Email Aktif</label>
                <input type="email" name="email" class="form-control text-center  @error('email') is-invalid @enderror" id="email" placeholder=""  required value="{{ old('email' , $user->email) }}">
                @if (old('email'))
                @error('email')
                <div class="invalid-feedback">
                 {{ $message }}
                </div>
                @enderror
                @else
                <div class="invalid-feedback">
                 Email Lengkap Wajib Dilengkapi
               </div>
                @endif
              </div>
      
             
      
              <div class="col-sm-12  mb-3 ">
                <label for="lastName" class="form-label h5">Alamat</label>
                <input type="text" class="form-control text-center @error('alamat') is-invalid @enderror" id="lastName" placeholder=""  name="alamat" required value="{{ $user->alamat }}">
                @if (old('alamat'))
               @error('alamat')
               <div class="invalid-feedback">
                {{ $message }}
               </div>
               @enderror
               @else
               <div class="invalid-feedback">
                Alamat Lengkap Wajib Dilengkapi
              </div>
               @endif
              </div>
              <div class="col-sm-12 mb-3">
                <label for="no_hp" class="form-label h5">No.Tlp</label>
                <input type="text" class="form-control  text-center @error('no_hp') is-invalid @enderror" id="no_hp" placeholder=""  name="no_hp" required minlength="11" maxlength="16" value="{{ $user->no_hp }}">
                @if (old('no_hp'))
               @error('no_hp')
               <div class="invalid-feedback">
                {{ $message }}
               </div>
               @enderror
               @else
               <div class="invalid-feedback">
                No.Tlp Lengkap Wajib Dilengkapi
              </div>
               @endif
              </div>
      
              <script>
                 $('#no_hp').keyup(function(event) {
      
                // skip for arrow keys
                if(event.which >= 37 && event.which <= 40) return;
      
                // format number
                $(this).val(function(index, value) {
                  return value
                  .replace(/\D/g, "")
                  .replace(/\B(?=(\d{3})+(?!\d))/g, "-")
                  ;
                });
                });
      
                const no_hp =  document.querySelector("#no_hp")
                no_hp.addEventListener("keypress", function (evt) {
                if (evt.which < 48 || evt.which > 57)
                {
                    evt.preventDefault();
                }
                });
              </script>

              <a href="#" id="bpass" class="btn btn-success col-sm-12 text-center align-item-center">Click untuk menampilkan form ubah password</a>
              
              <div id="passTal" style="display: none">
                <div class="col-sm-12 mb-3">
                  <label for="username" class="form-label h5 mt-3">Password</label>
                  <div class="input-group has-validation">
                    <span class="input-group-text"><span data-feather="lock"></span></span>
                    <input type="password" class="form-control  @error('password') is-invalid @enderror" id="password" placeholder="Password" name="password">
                  
                        <div class="invalid-feedback">
                          Konfirmasi Password Tidak Sesuai
                          </div>
        
                  </div>
                </div>

                <div class="col-sm-12 mb-3">
                <label for="username" class="form-label h5">Konfirmasi Password</label>
                <div class="input-group has-validation mb-1">
                  <span class="input-group-text"><span data-feather="lock"></span></span>
                  <input type="password" class="form-control" id="password2" placeholder="Konfirmasi Password" name="password_confirmation">
                  <div class="invalid-feedback">
                  Konfirmasi Password Tidak Sesuai
                    </div>
                </div>
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" onclick="showPass()" style="margin-right:5px "><span class="text-muted" style="margin-left: -77%">Show Password</span>
                 </div>

                  <script>
                    function showPass() {
                      var hideshow = document.getElementById("password");
                      var hideshow2 = document.getElementById("password2");
                      if (hideshow.type === "password" && hideshow2.type === "password") {
                        hideshow.type = "text";
                        hideshow2.type = "text";
                      } else {
                        hideshow.type = "password";
                        hideshow2.type = "password";
                      }
                    }
                  </script>
                </div>
              </div>


              <script>
                $(document).ready(function (){
                    $("#bpass").click(function(){
                        $("#passTal").toggle("fast");
                    });
                });
             </script>
            </div>
          </div>

    </div>
  
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Perbarui</button>
          </div>
        </form>
        @endforeach
        </div>
      </div>
    </div>
   

          @can('pelanggan')
          <div class="col-md-6 ms-sm-auto col-lg-12 m-auto w-50 px-md-4 ">
            <form action="/dashboard" method="GET">
             <div class="input-group mb-1">
               <input type="text" class="form-control bg-light border border-dark" placeholder="Cari berdasarkan nama barang..." name="search" value="{{ request('search') }}">
               <button class="btn btn-danger text-white btn-outline-primary" type="submit" id="button-addon2">Search</button>
             </div>
           </form>
           </div>
           @endcan
           
          @if (session()->has('success'))
        <span class="alert alert-success alert-dismissible fade show w-25" role="alert">
        {{ session('success') }}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
       </span>
        @endif

        @error('email')
        <span class="alert alert-danger alert-dismissible fade show w-25" role="alert">
         Gagal Perbaharui, Pastikan Data Sudah Sesuai
           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </span>
        @enderror
        @error('password')
        <span class="alert alert-danger alert-dismissible fade show w-25" role="alert">
         Gagal Perbaharui, Pastikan Data Sudah Sesuai
           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </span>
        @enderror
        </div> 
      </main>
      
      <div class="container-fluid">
        <div class="row w-100">
       
          <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4 d-flex  justify-content-between ">
            @can('gas_pim')
              <div class="card" style="width: 18rem;">
                  <img id="logo" src="images/cart.jpg" class="card-img-top h-75" alt="...">
                  <div class="card-body">
                      <h4 class="card-title"><a href="/totaljual" class="text-decoration-none text-dark">Total Pejualan</a></h4>
                    <p class="card-text">Informasi pengelolaan total penjualan BUMDES.</p>
                  </div>
                </div>
                 <div class="card" style="width: 18rem;">
                  <img id="logo" src="images/buy.jpg" class="card-img-top h-75" alt="...">
                  <div class="card-body">
                     <h4 class="card-title"><a href="/totalbeli" class="text-decoration-none text-dark">Total Pembelian</a></h4>
                    <p class="card-text">Informasi pengelolaan total pembelian BUMDES.</p>
                  </div>
                </div>
                @endcan
  
                @can('petugas')
                 <div class="card" style="width: 18rem;">
                  <img id="logo" src="images/package.jpg" class="card-img-top h-75" alt="...">
                  <div class="card-body">
                     <h4 class="card-title"><a href="/pesanantotal" class="text-decoration-none text-dark">Total Pesanan</a></h4>
                    <p class="card-text">Informasi pengelolaan total pesanan BUMDES.</p>
                  </div>
                </div>
                @endcan
  
                @can('gas_pim')
                 <div class="card" style="width: 18rem;">
                  <img id="logo" src="images/customers.jpg" class="card-img-top h-75" alt="...">
                  <div class="card-body">
                     <h4 class="card-title"><a href="/users/pelanggan" class="text-decoration-none text-dark">Total Pelanggan</a></h4>
                    <p class="card-text">Informasi pengelolaan total pelanggan BUMDES.</p>
                  </div>
                </div>
                @endcan
  
              
              </div>
  
             
        </div>
      </div>
      @can('pelanggan')
      <div class="container">
        @if ($barangs->count())
      <div class="row" style="margin-left: 20%">
        @foreach ($barangs as $barang)
       <div class="col-md-4 ms-sm-auto px-md-4 text-center " >
        <form action="/pelanggan/pesan" method="GET">
         <div class="card mb-3" style="width: 18rem">
           @if ($barang->image)
           <img id="logo" src="{{ asset('storage/' . $barang->image) }}" class="card-img-top" alt="...">
           @else
           <img id="logo" src="images/kosong.jpg" class="card-img-top" alt="...">
           @endif
            <div class="card-body">
               <h4 class="card-title"><a href="#" class="text-decoration-none text-dark">{{ $barang->nama_barang }}</a></h4>
              <p class="card-text">Harga Satuan : {{ $barang->harga_jual }}</p>
              <p class="card-text">Sisa Stok : {{ $barang->sisa }}</p>
              <p class="text-muted">Diperbaharui {{ $barang->updated_at->diffForHumans() }} oleh ({{ $barang->petugas }})</p>
             <a href="/pelanggan/pesan">
              <input type="text" class="d-none" readonly name="id" value="{{ $barang->id }}">
              <button class="btn btn-info" type="submit">Pesan</button>
            </a>
            </div>
          </div>
        </form>
        </div>
        @endforeach

       </div>
       @else
       <h5 class="col-lg-10 ms-sm-auto px-md-4 text-center">Barang "{{ request('search') }}" Tidak Ada</h5>
       @endif
       <div class="row" style="margin-left: 20%">
        <div class="col-md-12 ms-sm-auto px-md-4 text-center">
      {{ $barangs->links() }}
        </div>
      </div>
     
      
      </div>
       @endcan
  
       <script>
        const nama  = document.querySelector("#nama");
        const slug  = document.querySelector("#slug");
      
        nama.addEventListener('keyup', function(){
          fetch('/users/checkSlug?nama=' + nama.value).then(response => response.json()).then(data => slug.value = data.slug)
        })
      </script>
@endsection