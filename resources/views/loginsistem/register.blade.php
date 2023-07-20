
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>

</head>
<body>
    <section class="" style="background-color: #eee;">
        <div class="container h-100">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
              <div class="card text-black" style="border-radius: 25px;">
                <div class="card-body p-md-5">
                  <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
      
                      <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Daftar Akun</p>
      
                      <form class="mx-1 mx-md-4 needs-validation" action="/register" method="POST" novalidate>
                        @csrf

                        <div class="d-flex flex-row align-items-center mb-4">
                          <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                          <div class="flex-fill mb-0">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" placeholder="name@example.com" name="nama" required value="{{ old(('nama')) }}" autofocus>
                                <label for="floatingInput">Nama Lengkap</label>
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
                          </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4 d-none">
                          <label for="firstName" class="form-label">Slug</label>
                          <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" id="slug" placeholder=""   required value="{{ old('slug') }}">
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
                        
      
                        <div class="d-flex flex-row align-items-center mb-4">
                          <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                          <div class="form-outline flex-fill mb-0">
                            <div class="form-floating">
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="floatingInput" placeholder="name@example.com" required  value="{{ old(('email')) }}">
                                <label for="floatingInput">Email Aktif</label>
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
                          </div>
                        </div>
      
                        <div class="d-flex flex-row align-items-center mb-4">
                          <i class=" fa-solid fa-map me-3 fa-lg fa-fw"></i>
                          <div class="form-outline flex-fill mb-0">
                            <div class="form-floating">
                                <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" id="floatingInput" placeholder="name@example.com" required  value="{{ old(('alamat')) }}">
                                <label for="floatingInput">Alamat</label>
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
                          </div>
                        </div>
      
                        <div class="d-flex flex-row align-items-center mb-4">
                          <i class="fa-solid fa-phone fa-lg me-3 fa-fw"></i>
                          <div class="form-outline flex-fill mb-0">
                            <div class="form-floating">
                                <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" placeholder="name@example.com" required  value="{{ old(('no_hp')) }}">
                                <label for="floatingInput">No.Tlp</label>
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
                          </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                              <div class="form-floating">
                                  <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="name@example.com" required>
                                  <label for="floatingPassword">Password</label>
                                  <div class="invalid-feedback">
                                    Password Harus Dilengkapi
                                    </div>
                  
                                </div>
                            </div>
                          </div>

                          <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                              <div class="form-floating">
                                  <input type="password" class="form-control @error('password') is-invalid @enderror" id="password2" name="password_confirmation"  placeholder="name@example.com" required>
                                  <label for="floatingPassword">Konfirmasi Password</label>
                                  <div class="invalid-feedback">
                                    Konfirmasi Password Tidak Sesuai
                                     </div>
                                </div>
                            </div>
                          </div>
                          <div class="d-flex flex-row align-items-center mb-4" style="margin-left: 42px; margin-top: -20px">
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
                          
      
                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                          <button type="submit" class="btn btn-primary btn-lg">Buat Akun</button>
                        </div>
                      </form>
      
                    </div>
                    <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
      
                      <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
                        class="img-fluid" alt="Sample image">
      
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <script src="/js/form-validation.js"></script>
      {{-- Slug Service Auto --}}
      <script>
        const nama  = document.querySelector("#nama");
        const slug  = document.querySelector("#slug");

        nama.addEventListener('change', function(){
        fetch('/users/checkSlug?nama=' + nama.value).then(response => response.json()).then(data => slug.value = data.slug)
      });

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

      
</body>
</html>

