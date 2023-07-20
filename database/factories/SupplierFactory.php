<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nama_supplier' => fake()->company(),
            'pemilik' => fake()->name(),
            'alamat' => fake()->address(),
            'no_hp' => fake()->phoneNumber(),
         

        ];
    }
}
