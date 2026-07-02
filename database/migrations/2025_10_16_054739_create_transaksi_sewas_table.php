<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('transaksi_sewas', function (Blueprint $table) {
        $table->id('id_sewa');
        $table->unsignedBigInteger('id_pelanggan');
        $table->unsignedBigInteger('id_alat')->nullable();
        $table->date('tanggal_sewa');
        $table->date('tanggal_kembali');
        $table->integer('total_harga');
        $table->timestamps();

        $table->foreign('id_pelanggan')
              ->references('id_pelanggan')->on('pelanggans')
              ->onDelete('cascade');
        // Foreign key for id_alat will be added in a later migration
        // after alats table is created
    });
}
};
