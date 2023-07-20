<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produk>
 */
class ProdukFactory extends Factory
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
            'pembelian_id' => mt_rand(1,20),
            'produk' => fake()->streetName(),
            'qty' => mt_rand(1,50),
            'harga_beli' => "Rp " . $angka,
            'total_beli' => "Rp ". $angka2,
        ];
    }
}
