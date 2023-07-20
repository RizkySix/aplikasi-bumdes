<?php

use Carbon\Carbon;
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
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('barang_id');
            $table->dateTime('tanggal_transaksi');
            $table->string('kode_penjualan')->unique();
            $table->boolean('status')->nullable();
            $table->integer('note');
            $table->integer('qty');
            $table->string('harga_satuan')->nullable();
            $table->string('harga_beli')->nullable();
            $table->string('total')->nullable()->default(0);
            $table->string('pembayaran')->nullable();
            $table->string('sisa_bayar')->nullable();
            $table->string('pengirim')->nullable();
            $table->string('petugas')->nullable();
            $table->string('detail')->nullable();
            $table->string('nama_barang')->nullable();
            $table->string('pembeli')->nullable();
            $table->string('tujuan')->nullable();
            $table->string('bukti_gambar')->nullable();
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
        Schema::dropIfExists('penjualans');
    }
};
