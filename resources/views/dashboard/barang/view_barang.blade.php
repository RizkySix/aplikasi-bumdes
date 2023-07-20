@extends('dashboard.main.main')

@section('container')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class=" justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-2 border-bottom">
      <h1 class="h2">Daftar Barang</h1>
      
      <div class="d-flex">
        <a href="/barang/create" class="btn btn-primary mb-3 " style="margin-right: 10px">Tambah Data Barang Baru</a>
        <form action="/barang" method="GET">
          <select name="filter_barang" id="filB" class="form-select bg-secondary" style="color: aliceblue">
            @if (request('filter_barang') == "default")
            <option value="default" selected>Barang terbaru</option>
            <option value="b_laris">Barang terlaris</option>
            <option value="b_!laris">Barang kurang laku</option>
            
            @elseif(request('filter_barang') == "b_laris")
            <option value="default">Barang terbaru</option>
            <option value="b_laris" selected>Barang terlaris</option>
            <option value="b_!laris">Barang kurang laku</option>

            @elseif(request('filter_barang') == "b_!laris")
            <option value="default">Barang terbaru</option>
            <option value="b_laris">Barang terlaris</option>
            <option value="b_!laris" selected>Barang kurang laku</option>

            @else
            <option value="default">Barang terbaru</option>
            <option value="b_laris">Barang terlaris</option>
            <option value="b_!laris">Barang kurang laku</option>
            @endif
          </select>

          <button type="submit" id="filBtn" class="d-none">Click</button>
        </form>

        <script>
          $(document).ready(function(){
            $('#filB').change(function(){
              $('#filBtn').trigger('click');
            });
          });
        </script>
      </div>
     @if (session()->has('success'))
     <div class="alert alert-success alert-dismissible fade show w-25" role="alert">
     {{ session('success') }}
      <button type="button" class="pemicu btn-close" data-bs-dismiss="alert" id="pemicu" aria-label="Close"></button>
    </div>
     @endif
     @if (session()->has('alert') && !session('success'))
     <div class="alert alert-success alert-dismissible fade show w-25" role="alert">
      Data Barang Berhasil Diubah
       <button type="button" class="pemicu btn-close" data-bs-dismiss="alert" id="pemicu" aria-label="Close"></button>
     </div>
     @endif
     <a href="/send_email" class="d-none" id="email_send"><span>EMAIL SEND</span></a>
     @if (session()->has('param_sisa') && session('new_sisa') != 0  || session()->has('alert'))

     <script>
      $(document).ready(function(){
        $('.pemicu').click(function(){
          $('#email_send').find('span').trigger('click'); // Works
        })
      })
    </script>
     @endif
    
    </div>  
  </main>

  <div class="row-100">
    <div class="col-md-6 ms-sm-auto col-lg-10 px-md-4">
        <form action="/barang" method="GET">
         <div class="input-group mb-1">
           <input type="text" class="form-control bg-light border border-dark" placeholder="Cari berdasarkan nama barang atau kode barang..." name="search" value="{{ request('search') }}">
           <button class="btn btn-danger text-white btn-outline-primary" type="submit" id="button-addon2">Search</button>
         </div>
       </form>
       </div>

       <div class="col-md-10 ms-sm-auto col-lg-10 px-md-4 table-responsive">
        <table class="table table-striped table-primary table-bordered table-hover text-center" border="2px solid black">
            <thead>
                <tr class="table-secondary">
                  <th scope="col">No</th>
                  <th scope="col">Nama Barang</th>
                  <th scope="col">Kode Barang</th>
                  <th scope="col">Harga Beli</th>
                  <th scope="col">Harga Jual</th>
                  <th scope="col">Jumlah</th>
                  <th scope="col">Sisa</th>
                  <th scope="col">Terjual</th>
                  <th scope="col">Supplier</th>
                  <th scope="col" style="width: 10%">Aksi</th>
                </tr>
              </thead>
              @if ($barang->count())
                  
              <tbody>
              
               @foreach ($barang as $item)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama_barang }}</td>
                <td>{{ $item->kode_barang }}</td>
                <td>
                  @php
                       $string = $item->harga_beli;
                       $cut = explode(' ', $string);
                       $data = end($cut);
                  @endphp
                  Rp {{ $data }}
                </td>
                <td>
                  @php
                      $string2 = $item->harga_jual;
                      $cut2 = explode(' ', $string2);
                      $data2 = end($cut2);
                  @endphp
                   Rp {{ $data2 }}
                </td>
                <td>{{ $item->jumlah }}</td>
                <td>{{ $item->sisa }}</td>
                <td>{{ $item->terjual }}</td>
                @if ($item->supplier_id == 0)
                <td class="text-danger table-warning">
                  Tidak Ada Supplier
                </td>
                  @else
                <td>
                  {{ $item->supplier->nama_supplier }}
                </td>
                  @endif
                
                <td>
                    <a href="/barang/{{ $item->kode_barang }}/edit" class="badge bg-warning text-decoration-none "> <span data-feather="edit" ></span></a>
                    <form action="/barang/{{ $item->kode_barang }}" method="POST" id="sumbitform" class="d-inline">
                    @method('delete')
                    @csrf
                    <button id="del{{ $item->kode_barang }}" type="submit" class="badge bg-danger  border-0"><span data-feather="trash-2"></span></button>
                        <script>
                    $(document).ready(function (){
                
                        $("#del{{ $item->kode_barang }}").click(function(event){
                        event.preventDefault();
                        Swal.fire({
                        title: 'Yakin hapus data?',
                        text: "Data akan terhapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!'
                        }).then((result) => {
                        if (result.isConfirmed) {
                            $(event.target).closest('form').submit();//from stack overflow
                        }
                        })
                        });
                    });
                </script>
                </form>
                </td>
              </tr>
               
               @endforeach
               @else
                <tr>
                <td class="h5">🤖</td>
                <td colspan="8" class="h5">Kode atau nama barang <strong>{{ request('search') }}</strong> tidak ditemukan 😥</td>
                </tr>
              </tbody>
              @endif
        </table>
        {{ $barang->links() }}
       </div>
  </div>
@endsection