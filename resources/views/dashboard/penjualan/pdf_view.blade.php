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

    <h2>Laporan Penjualan</h2>
    @if (session()->has('src1') && session()->has('src2') )
       <h3 style="font-weight: lighter;  opacity: 0.5;">
        {{ date('d-M-Y', strtotime(session('src1'))) }} s/d {{ date('d-M-Y', strtotime(session('src2'))) }}
       </h3>
    @endif

    @if (session()->has('src1') && !session()->has('src2') )
       <h3 style="font-weight: lighter;  opacity: 0.5;">
        {{ date('d-M-Y', strtotime(session('src1'))) }}
       </h3>
    @endif

    @if (session()->has('src2') && !session()->has('src1') )
       <h3 style="font-weight: lighter;  opacity: 0.5;">
        {{ date('d-M-Y', strtotime(session('src2'))) }}
       </h3>
    @endif
</div>
<table id="customers">
    <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Tanggal Transaksi</th>
          <th scope="col">Kode Penjualan</th>
          <th scope="col">Pelanggan</th>
          <th scope="col">Note</th>
          <th scope="col">Produk</th>
          <th scope="col">Qty</th>
          <th scope="col">Total</th>
          <th scope="col">Jumlah Dibayar</th>
          <th scope="col">Sisa Bayar</th>
          <th scope="col">Status</th>
          <th scope="col">Detail</th>
        </tr>
      </thead>
      @if ($penjualan->count())
      <tbody>
        @php
         $i = 1;
         $total_jual = 0;
         $sisa_bayar = 0;
         @endphp

         @foreach ($penjualan as $item)
           <tr>
            <td>{{ $i++ }}</td>
            <td>{{ date('d-M-Y', strtotime($item->tanggal_transaksi)) }}</td>
            <td>{{ $item->kode_penjualan }}</td>
            <td>
              @if ($item->user_id != 0)
              {{ $item->user->nama }}
              @else
              {{ $item->pembeli }}
              @endif
            </td>
            <td>
                @if ($item->note == 1)
                    Satuan
                @else
                    Grosir
                @endif
            </td>
            <td>
              @if ($item->barang_id != 0)
              {{ $item->barang->nama_barang }}
              @else
              {{ $item->nama_barang }}
              @endif
            </td>
            <td>{{ $item->qty }}</td>
            <td>{{ $item->total }}</td>
            <td>{{ $item->pembayaran }}</td>
            <td>{{ $item->sisa_bayar }}</td>

            @php
                $exp = explode(' ', $item->pembayaran);
                $end = end($exp);
                $exp2 = explode('.' , $end);
                $imp = implode('' , $exp2);

                $total_jual += $imp;

                $sis = explode(' ', $item->sisa_bayar);
                $endtd = end($sis);
                $sis2 = explode('.' , $endtd);
                $imps = implode('' , $sis2);

                $sisa_bayar += $imps
            @endphp

            @if ($item->status == 1)
            <td>
                Lunas
            </td>
            @else
            <td class="table-warning">
                Belum Lunas
            </td>
            @endif
            @if ($item->detail == "Selesai")
                <td class="table-success">
                  {{ $item->detail }}
                </td>
            @endif
            @if ($item->detail == "Dipesan")
                <td class="table-dark">
                  {{ $item->detail }}
                </td>
            @endif
            @if ($item->detail == "Dikirim")
                <td class="table-light">
                  {{ $item->detail }}
                </td>
            @endif
         </tr>
         @endforeach
        <tr>
            <td colspan="8" style="font-size: 21px; font-weight: bold">Total Penjualan (Kotor)</td>
            <td colspan="4" style="font-size: 21px; font-weight: bold">
              @php
                  $format = number_format($total_jual , 0);
                  $format = explode(',' , $format);
                  $format = implode('.' , $format);
              @endphp
              Rp {{ $format }}
            </td>
        </tr>
        <tr>
          <td colspan="9" style="font-size: 21px; font-weight: bold">Total Tunggakan</td>
          <td colspan="3" style="font-size: 21px; font-weight: bold">
            @php
                $format2 = number_format($sisa_bayar , 0);
                $format2 = explode(',' , $format2);
                $format2 = implode('.' , $format2);
            @endphp
            Rp {{ $format2 }}
          </td>
      </tr>
         @else
         <tr>
         <td class="h5">🤖</td>
          @if (request('search') && request('search2'))
          <td colspan="8" class="h5">Penjualan pada tanggal <strong>{{ date('d-M-Y', strtotime(request('search'))) }}</strong> sampai <strong>{{ date('d-M-Y', strtotime(request('search2'))) }}</strong> tidak ditemukan 😥</td>
          @endif

          @if (request('search') && !request('search2'))
          <td colspan="8" class="h5">Penjualan pada tanggal <strong>{{ date('d-M-Y', strtotime(request('search'))) }}</strong> tidak ditemukan 😥</td>
          @endif

          @if (request('search2') && !request('search'))
          <td colspan="8" class="h5">Penjualan pada tanggal <strong>{{ date('d-M-Y', strtotime(request('search2'))) }}</strong> tidak ditemukan 😥</td>
          @endif
         </tr>
      </tbody>
  @endif
</table>
<h3 style="font-weight :lighter;">
  @if ($konten)
      Note : {!! $konten !!}
   @else
       Note : Informasi Belum Tersedia.
  @endif
 </h3>

 
</body>
</html>


