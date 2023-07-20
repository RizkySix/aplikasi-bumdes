<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="/style/login.css">
</head>

<body>

    <section class="h-100 gradient-form" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3 text-black">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">

                                    <div class="text-center">
                                        <img src="/images/logo.png" style="width: 185px;" alt="logo">
                                        <h4 class="mt-1 mb-5 pb-1">Bumdes Sad Mertha Nadi</h4>
                                    </div>

                                    <form action="/login" method="POST" novalidate class="needs-validation">
                                        @csrf
                                        <p>Silahkan login ke akun anda</p>

                                        @if (session()->has('success'))
                                        <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                                            {{ session('success') }}<span style="font-size: 1.5rem">🤪</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                        @endif

                                        @if (session()->has('failLogin'))
                                        <div class="alert alert-danger alert-dismissible fade show w-100" role="alert">
                                            {{ session('failLogin') }}<span style="font-size: 1.5rem">🤨</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                        @endif

                                        <div class="form-outline mb-4">
                                            <div class="form-floating">
                                                <input type="email" name="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    id="floatingInput" placeholder="name@example.com" required
                                                    value="{{ old(('email')) }}" autofocus>
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

                                        <div class="form-outline mb-4">
                                            <div class="form-floating mb-1">
                                                <input type="password" name="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    id="password" placeholder="name@example.com" required>
                                                <label for="floatingPassword">Password</label>
                                                <div class="invalid-feedback">
                                                    Password Harus Dilengkapi
                                                </div>

                                            </div>
                                            <input type="checkbox" class="form-check-input" onclick="showPass()"
                                                style="margin-right:5px "><span class="text-muted">Show Password</span>

                                            <script>
                                                function showPass() {
                                                    var hideshow = document.getElementById("password");
                                                    if (hideshow.type === "password") {
                                                        hideshow.type = "text";
                                                    } else {
                                                        hideshow.type = "password";
                                                    }
                                                }

                                            </script>
                                        </div>

                                        <div class="text-center mb-5 pb-1 d-block">
                                            <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3 w-100"
                                                type="submit" style="height: 40px">Log in</button>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-center pb-4">
                                            <p class="mb-0 me-2">Belum memiliki akun?</p>
                                            <a href="/register" class="btn btn-outline-danger">Buat baru</a>
                                        </div>

                                    </form>

                                </div>
                            </div>
                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                    <h4 class="mb-4">Aplikasi Bumdes Sad Mertha Nadi</h4>
                                    @if ($konten)
                                   <div style="text-align: justify;">
                                    <p class="small mb-0">{!! $konten !!}</p>
                                   </div>
                                    @else
                                    <p class="small mb-0" style="text-align: justify">Lorem, ipsum dolor sit amet
                                        consectetur adipisicing elit. Ipsam fuga, ullam minima natus possimus dolorum
                                        qui repellendus perferendis, quod, cumque quia nam provident eius unde aliquid
                                        quidem minus atque maxime veniam cupiditate! Odit deleniti eos mollitia dicta
                                        expedita ipsum non dolorem officiis ipsam. Cupiditate ipsum nesciunt qui rem
                                        esse nulla, architecto corrupti incidunt explicabo quibusdam suscipit molestiae
                                        quo, distinctio deleniti. Est dignissimos omnis deserunt. Quis aperiam,
                                        blanditiis repudiandae numquam hic aut quae itaque assumenda et minus sed
                                        reprehenderit sunt, ipsum similique at iusto reiciendis dicta. Commodi nam unde
                                        doloribus repellat, quo sed nobis recusandae quos, dolor vel, amet fuga ab.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="/js/form-validation.js"></script>
</body>

</html>
