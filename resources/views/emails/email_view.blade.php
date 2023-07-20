<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body{
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        }
      @media (max-width: 480px) {
  .pesan {
    font-size: 12px;
  }
}
    </style>
</head>
<body>
    <div class="pesan">
     <h3>Halo Selamat {{ $data['waktu'] }}</h3>
     <p>{{ $data['body'] }}  <span style="font-weight:bold;">{{ session('data_barang')[0] }}</span> dengan supplier  <span style="font-weight:bold;">{{ $data['supplier'][0] }}</span>. <br><br>Klik <a href="http://aplikasi-bumdes.test/pelanggan/pesan">link</a> untuk berbelanja.</p>
    <br><br><br>
   <p>Terima kasih.</p>
   <p>Hubungi Admin ({{ auth()->user()->nama }}) di : {{ auth()->user()->no_hp }}</p>
    </div>

</body>
</html>