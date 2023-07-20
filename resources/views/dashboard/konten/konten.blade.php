@extends('dashboard.main.main')

@section('container')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="text-center justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Konten Webiste</h1>
    </div>

</main>

<div class="row w-100 mt-4">
    <div class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
        @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show w-25" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @foreach ($konten as $pesan)
        <form action="/konten/store" method="POST" class="needs-validation" novalidate id="form_barang"
            enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row g-3">
                <div class="col-sm-12">
                    <label for="pss1" class="form-label h6">Pesan Laporan Penjualan</label>
                    <input type="text" class="form-control" name="pesan_penjualan"
                        value="{!! $pesan->pesan_penjualan !!}">
                </div>
                <div class="col-sm-12">
                    <label for="pss1" class="form-label h6">Pesan Laporan Pembelian</label>
                    <input type="text" class="form-control" name="pesan_pembelian"
                        value="{!! $pesan->pesan_pembelian !!}">
                </div>
                <div class="col-sm-12">
                    <label for="pss1" class="form-label h6">Pesan Laporan Persediaan</label>
                    <input type="text" class="form-control" name="pesan_stok" value="{!! $pesan->pesan_stok !!}">
                </div>
                <div class="col-sm-12">
                    <label for="pss1" class="form-label h6">Pesan Laporan Laba-Rugi</label>
                    <input type="text" class="form-control" name="pesan_labarugi"
                        value="{!! $pesan->pesan_labarugi  !!}">
                </div>
                <div class="col-sm-12">
                    <label for="pss1" class="form-label h6">Pesan Halaman Tampil Login</label>
                    <input id="pesan_login" type="hidden" name="pesan_login" value="{!! $pesan->pesan_login !!}">
                    <trix-editor input="pesan_login"></trix-editor>
                </div>
            </div>

            <script>
                document.addEventListener('trix-file-accept', function (e) {
                    e.preventDefault();
                })

            </script>

            <button class="col-md-2 btn btn-primary btn-md mt-4 mb-4" type="submit">Buat Konten</button>

        </form>
        @endforeach
        @if (!$konten->count())
        <form action="/konten/store" method="POST" class="needs-validation" novalidate id="form_barang"
            enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row g-3">
                <div class="col-sm-12">
                    <label for="pss1" class="form-label h6">Pesan Laporan Penjualan</label>
                    <input type="text" class="form-control" name="pesan_penjualan">
                    @error('pesan_penjualan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="col-sm-12">
                    <label for="pss1" class="form-label h6">Pesan Laporan Pembelian</label>
                    <input type="text" class="form-control" name="pesan_pembelian">
                    @error('pesan_pembelian')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="col-sm-12">
                    <label for="pss1" class="form-label h6">Pesan Laporan Persediaan</label>
                    <input type="text" class="form-control" name="pesan_stok">
                    @error('pesan_stok')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="col-sm-12">
                    <label for="pss1" class="form-label h6">Pesan Laporan Laba-Rugi</label>
                    <input type="text" class="form-control" name="pesan_labarugi">
                    @error('pesan_labarugi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="col-sm-12">
                    <label for="pss1" class="form-label h6">Pesan Halaman Tampil Login</label>
                    <input id="pesan_login" type="hidden" name="pesan_login">
                    @error('pesan_login')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                    <trix-editor input="pesan_login"></trix-editor>
                </div>
            </div>

            <script>
                document.addEventListener('trix-file-accept', function (e) {
                    e.preventDefault();
                })

            </script>

            <button class="col-md-2 btn btn-primary btn-md mt-4 mb-4" type="submit">Buat Konten</button>

        </form>
        @endif
    </div>
</div>
@endsection
