<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id');
            $table->dateTime('tanggal_transaksi')->default(Carbon::now());
            $table->string('kode_pembelian')->unique();
            $table->boolean('status')->nullable();
            $table->string('nota')->nullable();
            $table->string('big_total')->nullable();
            $table->string('pembayaran')->nullable();
            $table->string('sisa_bayar')->nullable();
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
        Schema::dropIfExists('pembelians');
    }
};
