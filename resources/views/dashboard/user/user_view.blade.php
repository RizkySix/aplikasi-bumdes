@extends('dashboard.main.main')

 

@section('container')

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class=" justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-2 border-bottom">
      <h1 class="h2">Daftar User</h1>
      
     <a href="/users/create" class="btn btn-primary mb-3">Tambah Data User Baru</a>
     @if (session()->has('success'))
     <div class="alert alert-success alert-dismissible fade show w-25" role="alert">
     {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
     @endif
    
    </div>  
  </main>

  <div class="w-100">
  
      <div class="col-md-6 ms-sm-auto col-lg-10 px-md-4">
       <form action="/users" method="GET">
        <div class="input-group mb-1">
          <input type="text" class="form-control bg-light border border-dark" placeholder="Cari berdasarkan nama..." name="search" value="{{ request('search') }}">
          <button class="btn btn-danger text-white btn-outline-primary" type="submit" id="button-addon2">Search</button>
        </div>
      </form>
      </div>
 
    

    <div class="col-md-10 ms-sm-auto col-lg-10 px-md-4 table-responsive">
      <table class="table table-striped table-primary table-bordered table-hover text-center" border="2px solid black">
        <thead>
          <tr class="table-secondary">
            <th scope="col">No</th>
            <th scope="col">Nama Lengkap</th>
            <th scope="col">Email Aktif</th>
            <th scope="col" style="width: 25%">Alamat</th>
            <th scope="col">No.Tlp</th>
            <th scope="col">Hak Akses</th>
            <th scope="col" style="width: 10%">Aksi</th>
          </tr>
        </thead>
       @if ($users->count())
       <tbody>
        @php
            $i = 1
        @endphp
        @foreach ($users as $user)
        <tr>
      
         <td>{{ $i++ }}</td>
         <td>{{ $user->nama }}</td>
         <td>{{ $user->email }}</td>
         <td>{{ $user->alamat }}</td>
         <td>{{ $user->no_hp }}</td>
         @if ($user->role === 2)
          <td>Pimpinan</td>
         @endif
         @if ($user->role === 1)
          <td>Pegawai</td>
         @endif
          <td>
            <a href="/users/{{ $user->slug }}/edit" class="badge bg-warning text-decoration-none "> <span data-feather="edit" ></span></a>
            <form action="/users/{{ $user->slug }}" method="POST" id="sumbitform" class="d-inline">
              @method('delete')
              @csrf
              <button id="del{{ $user->id }}" type="submit" class="badge bg-danger  border-0"><span data-feather="trash-2"></span></button>
              <script>
                $(document).ready(function (){
               
                    $("#del{{ $user->id }}").click(function(event){
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
          <td colspan="6" class="h5">User dengan nama <strong>{{ request('search') }}</strong> tidak ditemukan 😥</td>
        </tr>
      </tbody>

       @endif
      </table>
      {{ $users->links() }}
    </div>
  </div>
  
@endsection