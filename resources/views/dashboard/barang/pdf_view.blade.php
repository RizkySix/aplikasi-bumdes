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

<h1>Laporan Persediaan</h1>

<table id="customers">
    <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Nama Barang</th>
          <th scope="col">Kode Barang</th>
          <th scope="col">Harga Beli</th>
          <th scope="col">Harga Jual</th>
          <th scope="col">Jumlah</th>
          <th scope="col">Sisa</th>
          <th scope="col">Terjual</th>
          <th scope="col">Supplier</th>
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
        <td>
          Tidak Ada Supplier
        </td>
          @else
        <td>
          {{ $item->supplier->nama_supplier }}
        </td>
          @endif
      </tr>
       
       @endforeach
       @else
        <tr>
        <td >🤖</td>
        <td colspan="8" >Kode atau nama barang <strong>{{ request('search') }}</strong> tidak ditemukan 😥</td>
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


