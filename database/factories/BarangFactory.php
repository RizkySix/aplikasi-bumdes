<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
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
            'nama_barang' => fake()->streetName(),
            'kode_barang' => fake()->swiftBicNumber(),
            'harga_beli' =>"Rp " . $angka,
            'harga_jual' =>"Rp " . $angka2,
            'jumlah' => fake()->randomDigitNot(0),
            'sisa' => fake()->randomDigitNot(0),
            'terjual' => fake()->randomDigitNot(0),
            'supplier_id' => mt_rand(1,50),
        ];
    }
}
