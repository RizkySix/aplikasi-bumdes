@extends('dashboard.main.main')

@section('container')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="text-center justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Form Tambah Data User</h1>
    </div>  
  </main>

  <div class="row w-100 mt-4" >
    <div class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
      <form action="/users" method="POST"  class="needs-validation" novalidate>
        @csrf
       <div class="row g-3">

        <div class="col-sm-5">
          <label for="firstName" class="form-label">Nama Lengkap</label>
          <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" id="nama" placeholder=""   required value="{{ old('nama') }}" minlength="8">
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
          <label for="firstName" class="form-label">Slug</label>
          <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" id="slug" placeholder=""   required value="{{ old('slug') }}" >
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

        <div class="col-sm-5">
          <label for="lastName" class="form-label">Email Aktif</label>
          <input type="email" name="email" class="form-control  @error('email') is-invalid @enderror" id="lastName" placeholder=""  required value="{{ old('email') }}">
          @if (old('email'))
          @error('email')
          <div class="invalid-feedback">
           {{ $message }}
          </div>
          @enderror
          @else
          <div class="invalid-feedback">
           Email Aktif Wajib Dilengkapi
         </div>
          @endif
        </div>

        <div class="col-sm-5">
          <label for="lastName" class="form-label">Alamat</label>
          <input type="text" class="form-control  @error('alamat') is-invalid @enderror" id="lastName" placeholder=""  name="alamat" required value="{{ old('alamat') }}">
          @if (old('alamat'))
         @error('alamat')
         <div class="invalid-feedback">
          {{ $message }}
         </div>
         @enderror
         @else
         <div class="invalid-feedback">
          Alamat Wajib Dilengkapi
        </div>
         @endif
        </div>
        
        <div class="col-sm-5">
          <label for="no_hp" class="form-label">No.Tlp</label>
          <input type="text" class="form-control  @error('no_hp') is-invalid @enderror" id="no_hp" placeholder=""  name="no_hp" required minlength="11" maxlength="16" value="{{ old('no_hp') }}">
          @if (old('no_hp'))
         @error('no_hp')
         <div class="invalid-feedback">
          {{ $message }}
         </div>
         @enderror
         @else
         <div class="invalid-feedback">
          No.Tlp Wajib Dilengkapi
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

        <div class="col-10">
          <label for="username" class="form-label">Password</label>
          <div class="input-group has-validation">
            <span class="input-group-text"><span data-feather="lock"></span></span>
            <input type="password" class="form-control  @error('password') is-invalid @enderror" id="password" placeholder="Password" name="password" required>
          
                <div class="invalid-feedback">
                  Password Harus Dilengkapi
                  </div>

          </div>
        </div>
        <div class="col-10">
          <label for="username" class="form-label">Konfirmasi Password</label>
          <div class="input-group has-validation mb-1">
            <span class="input-group-text"><span data-feather="lock"></span></span>
            <input type="password" class="form-control" id="password2" placeholder="Konfirmasi Password" name="password_confirmation" required>
            <div class="invalid-feedback">
             Konfirmasi Password Tidak Sesuai
              </div>
          </div>
          <div class="form-check">
            <input type="checkbox" class="form-check-input" onclick="showPass()" style="margin-right:5px "><span class="text-muted">Show Password</span>
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

        <div class="col-md-5">
          <label for="country" class="form-label">Role</label>
          <div  class="input-group has-validation">
            <span class="input-group-text"><span data-feather="users"></span></span>
          <select class="form-select" id="country" name="role" required>
            <option value="3" {{ old('role') == 3 ? 'selected':''}}>Pelanggan</option>
            <option value="2" {{ old('role') == 2 ? 'selected':''}}>Pimpinan</option>
            <option value="1" {{ old('role') == 1 ? 'selected':''}}>Pegawai</option>
            
          </select>
          <div class="invalid-feedback">
           Pilih Posisi User
          </div>
          </div>
        </div>
        
       </div>
       <button class="col-md-2 btn btn-primary btn-md mt-4" type="submit">Tambah User</button>
       <button class="col-md-2 btn btn-danger btn-md mt-4" type="reset">Reset Form</button>
      </form>
    </div>
  </div>

{{-- Slug Service Auto --}}
<script>
  const nama  = document.querySelector("#nama");
  const slug  = document.querySelector("#slug");

  nama.addEventListener('change', function(){
    fetch('/users/checkSlug?nama=' + nama.value).then(response => response.json()).then(data => slug.value = data.slug)
  })
</script>

@endsection