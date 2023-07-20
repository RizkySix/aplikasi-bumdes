<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Penjualan>
 */
class PenjualanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $angka =  rand(200000, 500000);
        $angka = number_format($angka , 0);
        $angka = explode(',' , $angka);
        $angka = implode('.' , $angka);

        $angka2 =  rand(500000, 700000);
        $angka2 = number_format($angka2 , 0);
        $angka2 = explode(',' , $angka2);
        $angka2 = implode('.' , $angka2);
        return [
            'user_id' => mt_rand(1,50),
            'barang_id' => mt_rand(1,50),
            'tanggal_transaksi' => Carbon::now(),
            'kode_penjualan' => fake()->swiftBicNumber(),
            'status' => mt_rand(0,1),
            'note' => mt_rand(1,2),
            'qty' => mt_rand(1,50),
            'harga_satuan' => "Rp " . $angka2,
            'harga_beli' => "Rp " . $angka,
            'total' => "Rp " . $angka2,
            'pembayaran' => "Rp " . $angka,
            'sisa_bayar' => "Rp " . $angka,
            'pengirim' => fake()->name(),
            'petugas' => fake()->name(),
            'detail' => "Selesai"



        ];
    }
}
