<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(50)->create();
        \App\Models\Barang::factory(50)->create();
        \App\Models\Supplier::factory(50)->create();
        \App\Models\Penjualan::factory(5)->create();
        \App\Models\Pembelian::factory(20)->create();
        \App\Models\Produk::factory(50)->create();
        \App\Models\Retur::factory(20)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
