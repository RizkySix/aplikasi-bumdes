<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pembelian>
 */
class PembelianFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        
        return [
            'supplier_id' => mt_rand(1,50),
            'kode_pembelian' => fake()->swiftBicNumber(),
            'status' => mt_rand(0,1),
            'big_total' => "Rp 0",
            'pembayaran' => "Rp 0",
            'sisa_bayar' => "Rp 0",

        ];
    }
}
