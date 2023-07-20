@extends('dashboard.main.main')

@section('container')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="text-center justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Form Tambah Data Supplier</h1>
    </div>  
  </main>

  <div class="row w-100 mt-4">
    <div class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
        <form action="/suppliers" method="POST"  class="needs-validation" novalidate>
            @csrf
            <div class="row g-3">
                <div class="col-sm-10">
                    <label for="nama_supplier" class="form-label">Nama Supplier</label>
                    <input type="text" name="nama_supplier" class="form-control @error('nama_supplier') is-invalid @enderror" id="nama_supplier" placeholder=""   required value="{{ old('nama_supplier') }}">
                    @if (old('nama_supplier'))
                    @error('nama_supplier')
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

                <div class="col-sm-10">
                    <label for="pemilik" class="form-label">Pemilik</label>
                    <div class="input-group has-validation">
                      <span class="input-group-text"><span data-feather ="user"></span></span>
                      <input type="text" class="form-control  @error('pemilik') is-invalid @enderror" id="pemilik" placeholder="" name="pemilik" value="{{ old('pemilik') }}" required>
                      @if (old('pemilik'))
                      @error('pemilik')
                      <div class="invalid-feedback">
                      {{ $message }}
                      </div>
                      @enderror
                      @else
                      <div class="invalid-feedback">
                      Nama Pemilik Wajib Dilengkapi
                      </div>
                      @endif
                    </div>
                </div>

                <div class="col-sm-10">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" id="alamat" placeholder=""   required value="{{ old('alamat') }}">
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

                <div class="col-sm-10">
                    <label for="no_hp" class="form-label">No.Tlp</label>
                    <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" placeholder=""   required value="{{ old('no_hp') }}" minlength="8">
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
            </div>
            <button class="col-md-2 btn btn-primary btn-md mt-4" type="submit">Tambah Supplier</button>
            <button class="col-md-2 btn btn-danger btn-md mt-4" type="reset">Reset Form</button>
        </form>
    </div>

  </div>
@endsection