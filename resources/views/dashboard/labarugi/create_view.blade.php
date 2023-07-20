@extends('dashboard.main.main')

@section('container')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="text-center justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Buat Laporan Laba Rugi</h1>
    </div> 
  </main>

  <h6 class="text-muted col-md-9 ms-sm-auto col-lg-10 px-md-4">Lengkapi form dibawah</h6>
  <div class="row-100">
    <div class="col-md-6 ms-sm-auto col-lg-10 px-md-4">
        <form action="/labarugi/final" method="GET" class="needs-validation" novalidate>
        <label for="note" class="form-label text-center">Range Keuntungan Penjualan</label>
         <div class="input-group mb-1">
           <input type="date" class="form-control bg-light border border-dark" name="search" required autofocus value="{{ old('search') }}">
           <span class="input-group-text border border-dark"><span  data-feather="calendar"></span></span>
           <input type="date" class="form-control bg-light border border-dark" name="search2" required value="{{ old('search2') }} ">
         </div><br>

         <div class="row g-3">
            <div class="col-sm-4">
                <label for="pay" class="form-label h5">Beban Gaji :</label><br>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="text" id="pay" class="form-control" name="beban_gaji" required>
                    <div class="invalid-feedback">
                      Beban Gaji Wajib Dilengkapi
                      </div>
                   </div>
                  
              </div>
    
              <div class="col-sm-4">
                <label for="pay" class="form-label h5">Beban Kendaraan :</label><br>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="text" id="pay2" class="form-control" name="beban_kendaraan" required>
                    <div class="invalid-feedback">
                      Beban Kendaraan Wajib Dilengkapi
                      </div>
                   </div>
                  
              </div>

              <div class="col-sm-4">
                <label for="pay" class="form-label h5">Beban Lain-Lain :</label><br>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="text" id="pay3" class="form-control" name="beban_lain" required >
                    <div class="invalid-feedback">
                      Beban Lain-Lain Wajib Dilengkapi
                      </div>
                   </div>
                  
              </div>
    
         </div>
         <button class="col-md-2 btn btn-success btn-md mt-4" type="submit">Buat Laporan</button>
       </form>
       </div>

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
 ////////////////////////////////////////////////////////////////////

        $('#pay3').keyup(function(event) {

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

        const pay3 =  document.querySelector("#pay3")
        pay3.addEventListener("keypress", function (evt) {
        if (evt.which < 48 || evt.which > 57)
        {
            evt.preventDefault();
        }
        });






  </script>
@endsection