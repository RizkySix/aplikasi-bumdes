<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Retur>
 */
class ReturFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'barang_id' => mt_rand(1,50),
            'jumlah' => mt_rand(1,50),
            'tanggal_retur' => Carbon::now(),
            'keterangan' => "
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae in incidunt porro officiis ullam dignissimos repudiandae distinctio consequatur at minus.
            "
        ];
    }
}
