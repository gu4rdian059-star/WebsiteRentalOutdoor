<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dendas', function (Blueprint $table) {
            $table->id('id_denda'); // auto increment
            $table->unsignedBigInteger('id_sewa');
            $table->date('tanggal_denda');
            $table->string('jenis_denda');
            $table->date('batas_waktu');
            $table->integer('total_denda');
            $table->timestamps();

            $table->foreign('id_sewa')
                  ->references('id_sewa')
                  ->on('transaksi_sewas')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dendas');
    }
};
