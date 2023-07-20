
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">Aplikasi BUMDES</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <input class="form-control form-control-dark w-100 rounded-0 border-0" type="text" aria-label="Search" disabled>
  <div class="navbar-nav bg-dark">
    <div class="nav-item text-nowrap">
      
     <form action="/logout" method="POST">
      @csrf
      <button type="submit" class="btn btn-dark">
       Logout <span data-feather="log-out" class="align-text-bottom"></span>
      </button>
     </form>
    </div>
  </div>
</header>



<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3 sidebar-sticky">
        <div class="nav flex-column border-bottom">
          <li class="nav-item">
              <a class="nav-link" aria-current="page">
                <span data-feather="users" class="align-text-bottom"></span>
                 @if (auth()->user()->role === 1)
                 Petugas 
                 @endif

                 @if (auth()->user()->role === 2)
                 Pimpinan 
                 @endif

                 @if (auth()->user()->role === 3)
                 Pelanggan 
                 @endif
                 <p>
                 
                    <span class="align-text-bottom">🟢</span>
                   <span class="text-muted"> ( {{ auth()->user()->nama }} )</span>
                   
                 </p>
              </a>
            
             
            </li>
        </div>

        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard*') ? 'active' : '' }}" aria-current="page" href="/dashboard">
              <span data-feather="home" class="align-text-bottom"></span>
              Dashboard
            </a>
          </li>

          @can('petugas')
          <li class="nav-item ">
            <a class="nav-link dropdown-toggle {{ Request::is(['penjualan*' , 'pembelian*' , 'produk*']) ? 'active' : '' }} " id="transaksi" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <span data-feather="grid" class="align-text-bottom"></span>
              Transaksi
            </a>
            <div class="text-center" id="opsi" style="display: none;">
              <a href="/penjualan" class="nav-link {{ Request::is('penjualan*') ? 'active' : '' }}" style="margin-left: -3px;">
                  <span data-feather="package" class="align-text-bottom"></span>
                  Penjualan
              </a>
              <a href="/pembelian" class="nav-link {{ Request::is(['pembelian*' , 'produk*']) ? 'active' : '' }}">
                  <span data-feather="coffee" class="align-text-bottom"></span>
                  Pembelian
              </a>
          </div>

           <script>
              $(document).ready(function (){
                  $("#transaksi").click(function(){
                      $("#opsi").toggle("fast");
                  });
              });
           </script>

          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('barang*') ? 'active' : '' }}" href="/barang">
              <span data-feather="shopping-cart" class="align-text-bottom"></span>
              Laporan Persediaan
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('users*') ? 'active' : '' }}" href="/users">
              <span data-feather="users" class="align-text-bottom"></span>
              Users
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('suppliers*') ? 'active' : '' }}" href="/suppliers">
              <span data-feather="truck" class="align-text-bottom"></span>
              Suppliers
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('retur*') ? 'active' : '' }}" href="/retur">
              <span data-feather="delete" class="align-text-bottom"></span>
              Retur
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('konten*') ? 'active' : '' }}" href="/konten">
              <span data-feather="message-circle" class="align-text-bottom"></span>
              Konten
            </a>
          </li>
          @endcan

          @can('pimpinan')
          <li class="nav-item ">
            <a class="nav-link dropdown-toggle {{ Request::is(['totaljual*' , 'totalbeli*' , 'persediaan*' , 'labarugi' , 'grafikjual', 'grafikbeli' , 'grafikbarang']) ? 'active' : '' }}" id="laporan" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <span data-feather="grid" class="align-text-bottom"></span>
              Laporan
            </a>
            <div class="text-center" id="opsi2" style="display: none;">
              <a href="/totaljual" class="nav-link {{ Request::is(['totaljual*' , 'grafikjual']) ? 'active' : '' }}" style="margin-left: -3px;">
                  <span data-feather="package" class="align-text-bottom"></span>
                 Laporan Penjualan
              </a>
              <a href="/totalbeli" class="nav-link {{ Request::is(['totalbeli*' , 'grafikbeli']) ? 'active' : '' }}">
                  <span data-feather="coffee" class="align-text-bottom"></span>
                 Laporan Pembelian
              </a>
              <a href="/persediaan" class="nav-link {{ Request::is(['persediaan*' , 'grafikbarang']) ? 'active' : '' }}">
                  <span data-feather="database" class="align-text-bottom"></span>
                 Laporan Persediaan
              </a>
              <a href="/labarugi" class="nav-link {{ Request::is('labarugi*') ? 'active' : '' }}">
                <span data-feather="dollar-sign" class="align-text-bottom"></span>
                 Laporan Laba-Rugi
            </a>
          </div>

           <script>
              $(document).ready(function (){
                  $("#laporan").click(function(){
                      $("#opsi2").toggle("fast");
                  });
              });
           </script>

          </li>
          @endcan
    
          @can('pelanggan')
          <li class="nav-item">
            <a class="nav-link {{ Request::is(['pelanggan/totalpesan' , 'pelanggan/pesan']) ? 'active' : '' }}" href="/pelanggan/totalpesan">
              <span data-feather="shopping-cart" class="align-text-bottom"></span>
              Pesanan
            </a>
          </li>
          @endcan
        </ul>

      
      </div>
    </nav>
  </div>
</div>