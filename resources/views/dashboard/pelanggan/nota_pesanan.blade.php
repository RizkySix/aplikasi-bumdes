<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    
    <style>
        #customers {
          font-family: Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }
        
        #customers td, #customers th {
          border: 0px solid #ddd;
          padding: 8px;
        }
        
        #customers tr:nth-child(even){background-color: ghostwhite;}
        
        #customers tr:hover {background-color: #ddd;}
        
        #customers th {
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: left;
          background-color: #1c11e7;
          color: white;
        }
        </style>
</head>
<body>
   <main>
    <div style="text-align: center">
        <h1 class="h2">Nota Pesanan</h1>
        @foreach($penjualans as $penjualan)
      <img src="{{ asset('/images/logo.png') }}" style="width:150px; height:150px">
        <h1>Bumdes Sad Mertha Nadi</h1>
      <h3 style="">Kode Pesanan : {{ $penjualan->kode_penjualan }}</h3>
    </div>
    <hr>
   </main>
   <h3 style="text-align: center">Detail Pesanan</h3>

<table id="customers">
  <tr>
    <th>Tanggal Transaksi :</th>
    <th>Nama Pelanggan :</th>
    <th>Nama Produk :</th>
  </tr>
 
  <tr>
    <td>
        {{ date('d-M-Y', strtotime($penjualan->tanggal_transaksi)) }}
    </td>
    <td>
        @if ($penjualan->user_id != 0)
        {{ $penjualan->user->nama }}
        @else
        {{ $penjualan->pembeli }}
        @endif
    </td>
    <td>
        @if ($penjualan->barang_id != 0)
        {{ $penjualan->barang->nama_barang }}
        @else
        {{ $penjualan->nama_barang }}
        @endif
    </td>
  </tr>

  <tr>
    <th>Note :</th>
    <th>Qty :</th>
    <th>Petugas :</th>
  </tr>

  <tr>
    <td>
        @if ($penjualan->note == 1)
        Satuan
        @else
       Grosir
    @endif
    </td>
    <td>
        {{ $penjualan->qty }} Pcs
    </td>
    <td>
        @if ($penjualan->petugas)
        <span>
          {{ $penjualan->petugas }} 
           </span>
           @else
           <span>Belum Diproses</span>
        @endif
    </td>
  </tr>

  <tr>
    <th>Harga Satuan :</th>
    <th>Harga Total :</th>
    <th>Sisa Pembayaran :</th>
  </tr>

  <tr>
    <td>
        @php
        $string = $penjualan->harga_satuan;
        $cut = explode(' ', $string);
        $data = end($cut);
        $morp = explode('.', $data);
        $morps = implode('', $morp);
     @endphp
        <span>Rp {{ $data }}</span>
    </td>
    <td>
        @if ($penjualan->note == 1)
        @php
            $total = $morps * $penjualan->qty;
            $morl = number_format($total, 0);
            $morh = explode(',',$morl);
            $mors = implode('.',$morh);
        @endphp
          <span >Rp {{ $mors }}</span>
        @else
        @php
              $total = $morps * $penjualan->qty;
              $final = (5/100) * $total;
              $result = $total - $final;
              $resol =  number_format($result, 0);
              $rawr = explode(',',$resol);
              $rosh = implode('.', $rawr);
             
        @endphp
       <span >Rp {{ $rosh }}</span>
        @endif
    </td>
    <td>
        <span>
            @php
                        $findSisa = $penjualan->pembayaran;
                        $cutSisa = explode(' ', $findSisa);
                        $gotit = end($cutSisa);
                        $moreExp = explode('.' , $gotit);
                        $moreImp = implode('' , $moreExp);

                        $findTotal = $penjualan->total;
                        $cutTotal = explode(' ', $findTotal);
                        $gotit2 = end($cutTotal);
                        $moreExp2 = explode('.' , $gotit2);
                        $moreImp2 = implode('' , $moreExp2);

                        $sisa = $moreImp2 - $moreImp;
                        $soda = number_format($sisa, 0);
                        $shes = explode(',',$soda);
                        $slash = implode('.',$shes);
                @endphp
               @if ($penjualan->status == 1)
                   Rp 0.000
                   @else
                   Rp {{ $slash }}
               @endif
        </span>
    </td>
  </tr>

  <tr>
    <th>Pembayaran :</th>
    <th>Pengirim :</th>
    <th>Status :</th>
  </tr>

  <tr>
    <td>
        <span>{{ $penjualan->pembayaran }}</span>
    </td>
    <td>
        @if ($penjualan->pengirim)
        <span >{{ $penjualan->pengirim }}</span>
        @else
        <span >Pengirim Belum Diperbarui</span>
        @endif
    </td>
    <td>
        <span >
            @if ($penjualan->status == 1)
                Lunas
                @else
                Belum Lunas
            @endif
          </span>
    </td>
  </tr>

  <tr>
    <th>Lokasi Pengiriman :</th>
    <th>Detail Pesanan :</th>
    <th>No.Hp :</th>
  </tr>

  <tr>
    <td>
        <span >{{ $penjualan->tujuan }}</span>
    </td>
    <td>
        <span>{{ $penjualan->detail }}</span>
    </td>
    <td>
        @if ($penjualan->user_id !== 0)
        <span >{{ $penjualan->user->no_hp }}</span>
        @else
        No.Hp Tidak Tersedia
        @endif
    </td>
  </tr>

 

</table>
<h3 style="font-size: 14px; opacity:60%; font-style:italic"><p>Nota pesanan Bumdes Sad Mertha Nadi (simpan nota sebagai bukti pesanan)</p></h3>
    @endforeach
</body>
</html>