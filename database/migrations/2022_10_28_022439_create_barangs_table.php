<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id');
            $table->string('nama_barang');
            $table->string('kode_barang')->unique();
            $table->string('harga_beli');
            $table->string('harga_jual');
            $table->integer('jumlah');
            $table->integer('sisa');
            $table->integer('terjual');
            $table->string('image')->nullable();
            $table->string('petugas')->nullable();
            $table->date('terakhir_terjual')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barangs');
    }
};
