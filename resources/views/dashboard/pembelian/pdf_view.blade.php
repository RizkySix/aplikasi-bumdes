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

    <h2>Laporan Pembelian</h2>
    @if (session()->has('beli1') && session()->has('beli2') )
       <h3 style="font-weight: lighter;  opacity: 0.5;">
        {{ date('d-M-Y', strtotime(session('beli1'))) }} s/d {{ date('d-M-Y', strtotime(session('beli2'))) }}
       </h3>
    @endif

    @if (session()->has('beli1') && !session()->has('beli2') )
       <h3 style="font-weight: lighter;  opacity: 0.5;">
        {{ date('d-M-Y', strtotime(session('beli1'))) }}
       </h3>
    @endif

    @if (session()->has('beli2') && !session()->has('beli1') )
       <h3 style="font-weight: lighter;  opacity: 0.5;">
        {{ date('d-M-Y', strtotime(session('beli2'))) }}
       </h3>
    @endif
</div>
<table id="customers">
    <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Tanggal Transaksi</th>
          <th scope="col">Kode Pembelian</th>
          <th scope="col">Supplier</th>
          <th scope="col">Produk</th>
          <th scope="col">Qty</th>
          <th scope="col">Total</th>
          <th scope="col">Jumlah Pembayaran</th>
          <th scope="col">Sisa Pembayaran</th>
          <th scope="col">Status</th>
        </tr>
      </thead>
      @if ($pembelian->count())
                  <tbody>
                    @php
                     $i = 1;
                     $total_beli = 0;
                     $pembayaran = 0;
                     $sisa_bayar = 0;
                     @endphp
                     @foreach ($pembelian as $item)
                     <tr>
                      <td>{{ $i++ }}</td>
                      <td>{{ date('d-M-Y', strtotime($item->tanggal_transaksi)) }}</td>
                      <td>{{ $item->kode_pembelian }}</td>
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
                        @foreach ($allPembelian as $produk)
                           @if ($produk->pembelian_id == $item->id)
                               {{ $produk->produk }} <br>
                           @endif
                        @endforeach
                      </td>

                      <td>
                        @foreach ($allPembelian as $produk)
                           @if ($produk->pembelian_id == $item->id)
                               {{ $produk->qty }} <br>
                           @endif
                        @endforeach
                      </td>

                      <td>
                        @foreach ($allPembelian as $produk)
                           @if ($produk->pembelian_id == $item->id)
                               {{ $produk->total_beli }} <br>


                               @php
                               $exp = explode(' ', $produk->total_beli);
                                $end = end($exp);
                                $exp2 = explode('.' , $end);
                                $imp = implode('' , $exp2);
    
                                $total_beli += $imp;
                          @endphp
                           @endif
                        @endforeach
                      </td>
                      <td>
                        {{ $item->pembayaran }}

                        @php
                        $enb = explode(' ', $item->pembayaran);
                         $endt = end($enb);
                         $enb2 = explode('.' , $endt);
                         $impss = implode('' , $enb2);

                         $pembayaran += $impss;
                   @endphp
                      </td>
                      <td>
                        {{ $item->sisa_bayar }}

                        @php
                        $env = explode(' ', $item->sisa_bayar);
                         $envx = end($env);
                         $env2 = explode('.' , $envx);
                         $impssh = implode('' , $env2);

                         $sisa_bayar += $impssh;
                   @endphp
                      </td>

                      @if ($item->status == 1)
                      <td>
                          Lunas
                      </td>
                      @else
                      <td>
                          Belum Lunas
                      </td>
                      @endif
                   </tr>
                     @endforeach
                     <tr>
                        <td colspan="6" style="font-size: 21px; font-weight: bold">Total Pembelian</td>
                        <td colspan="1" style="font-size: 21px; font-weight: bold">
                          @php
                              $format = number_format($total_beli , 0);
                              $format = explode(',' , $format);
                              $format = implode('.' , $format);
                          @endphp
                          Rp {{ $format }}
                        </td>
                        <td colspan="3" style="font-size: 21px; font-weight: bold">
                    </tr>
                    <tr>
                      <td colspan="7" style="font-size: 21px; font-weight: bold">Total Pembayaran</td>
                      <td colspan="1" style="font-size: 21px; font-weight: bold">
                        @php
                            $format2 = number_format($pembayaran , 0);
                            $format2 = explode(',' , $format2);
                            $format2 = implode('.' , $format2);
                        @endphp
                        Rp {{ $format2 }}
                      </td>
                      <td colspan="2" style="font-size: 21px; font-weight: bold">
                  </tr>
                  <tr>
                    <td colspan="8" style="font-size: 21px; font-weight: bold">Total Tunggakan</td>
                    <td colspan="2" style="font-size: 21px; font-weight: bold">
                      @php
                          $format3 = number_format($sisa_bayar , 0);
                          $format3 = explode(',' , $format3);
                          $format3 = implode('.' , $format3);
                      @endphp
                      Rp {{ $format3 }}
                    </td>
                   
                </tr>

                     @else
                     <tr>
                     <td class="h5">🤖</td>
                      @if (request('search') && request('search2'))
                      <td colspan="8" class="h5">Pembelian pada tanggal <strong>{{ date('d-M-Y', strtotime(request('search'))) }}</strong> sampai <strong>{{ date('d-M-Y', strtotime(request('search2'))) }}</strong> tidak ditemukan 😥</td>
                      @endif

                      @if (request('search') && !request('search2'))
                      <td colspan="8" class="h5">Pembelian pada tanggal <strong>{{ date('d-M-Y', strtotime(request('search'))) }}</strong> tidak ditemukan 😥</td>
                      @endif

                      @if (request('search2') && !request('search'))
                      <td colspan="8" class="h5">Pembelian pada tanggal <strong>{{ date('d-M-Y', strtotime(request('search2'))) }}</strong> tidak ditemukan 😥</td>
                      @endif
                     </tr>
                  </tbody>
              @endif
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


