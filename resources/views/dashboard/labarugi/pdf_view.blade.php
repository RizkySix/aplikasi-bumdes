<!DOCTYPE html>
<html>
<head>
<style>
    @page { size: 20cm 35cm landscape; }
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
</style>
</head>
<body>

<div style="text-align: center">
    <h1>BUMDES</h1>
    <h1>Sad Mertha Nadi</h1>
    <h3 style="font-weight: lighter;  opacity: 0.5;">Jl.Jurusan Baturiti-Meliling, Kerambitan, Tabanan, Bali</h3>
<hr>

    <h2>Laporan Laba Rugi</h2>
    @if (request('search') && request('search2') )
       <h3 style="font-weight: lighter;  opacity: 0.5;">
        {{ date('d-M-Y', strtotime(request('search'))) }} s/d {{ date('d-M-Y', strtotime(request('search2'))) }}
       </h3>
    @endif

</div>
<table id="customers">
      <tbody>
        <tr>
            <th scope="col" style="width: 10%">#</th>
            <th scope="col">Pendapatan Usaha</th>
            <th scope="col">Nilai</th>
           
          </tr>
        <tr>
            <td>
            #
            </td>
            <td>
                Pendapatan Penjualan (Bersih)
            </td>
            <td>
                @php
                $untung = number_format($keuntungan , 0);
                $untung = explode(',' , $untung);
                $untung = implode('.' , $untung);
            @endphp
           Rp {{ $untung }}
            </td>
        </tr>
        <tr>
            <th scope="col" style="width: 10%">#</th>
            <th scope="col">Tunggakan Penjualan</th>
            <th scope="col">Nilai</th>
        </tr>
        <tr>
            <td>#</td>
            <td>
                Total Tunggakan Pembayaran (Kotor)
            </td>
            <td>
                @php
                     $sisa_bayar = number_format($sisa_bayar , 0);
                    $sisa_bayar = explode(',' , $sisa_bayar);
                    $sisa_bayar = implode('.' , $sisa_bayar);
                @endphp
               Rp {{ $sisa_bayar }}
            </td>
        </tr>
        <tr>
            <td>#</td>
            <td>
                Total Tunggakan Pembayaran (Bersih)
            </td>
            <td>
                @php
                     $tunggakan = number_format($tunggakan , 0);
                    $tunggakan = explode(',' , $tunggakan);
                    $tunggakan = implode('.' , $tunggakan);
                @endphp
               Rp {{ $tunggakan }}
            </td>
        </tr>
        <tr>
            <td>#</td>
            <td>
                Modal Pokok Tidak Tercapai (Pembayaran lebih rendah dari total penjualan harga beli barang)
            </td>
            <td>
                @php
                     $modal = number_format($modal , 0);
                    $modal = explode(',' , $modal);
                    $forLaba = implode('' , $modal);
                    $modal = implode('.' , $modal);
                @endphp
               Rp {{ $modal }}
            </td>
        </tr>
        <thead>
            <tr>
                <th scope="col" style="width: 10%">#</th>
                <th scope="col">Beban Usaha</th>
                <th scope="col">Nilai</th>
            </tr>
        </thead>
        <tr>
            <td>#</td>
            <td>
                Beban Gaji
            </td>
            <td>
               Rp {{ request('beban_gaji') }}
            </td>
        </tr>
        <tr>
            <td>#</td>
            <td>
                Beban Kendaraan
            </td>
            <td>
               Rp {{ request('beban_kendaraan') }}
            </td>
        </tr>
        <tr>
            <td>#</td>
            <td>
                Beban Lain
            </td>
            <td>
               Rp {{ request('beban_lain') }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="font-size: 21px; font-weight: bold">Jumlah Beban</td>
            <td  style="font-size: 21px; font-weight: bold">
                @php
                   $beban_gaji = explode('.' , request('beban_gaji')); 
                   $beban_gaji = implode('' , $beban_gaji); 

                   $beban_kendaraan = explode('.' , request('beban_kendaraan')); 
                   $beban_kendaraan = implode('' ,  $beban_kendaraan); 

                   $beban_lain = explode('.' , request('beban_lain')); 
                   $beban_lain = implode('' , $beban_lain); 

                   $nilai_beban = $beban_gaji + $beban_kendaraan + $beban_lain;

                   $jumlah_beban = number_format($nilai_beban , 0);
                   $jumlah_beban = explode(',',$jumlah_beban );
                   $jumlah_beban = implode('.',$jumlah_beban );


                @endphp
                Rp {{ $jumlah_beban }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="font-size: 21px; font-weight: bold">Laba Usaha</td>
            <td  style="font-size: 21px; font-weight: bold">
                @php
                    
                $laba = $keuntungan - $nilai_beban - $forLaba;
                $laba = number_format($laba , 0);
                $laba = explode(',' , $laba);
                $laba = implode('.' , $laba);

                @endphp
                Rp {{ $laba }}
            </td>
        </tr>
       
      </tbody>
      
</table>
<h3 style="font-weight :lighter">
   @if ($konten)
       Note : {!! $konten !!}
    @else
        Note : Informasi Belum Tersedia.
   @endif
  </h3>
  
</body>
</html>


