<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_sewas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_sewa');
            $table->unsignedBigInteger('id_alat');
            $table->integer('jumlah')->default(1);
            $table->integer('harga');
            $table->timestamps();

            $table->foreign('id_sewa')->references('id_sewa')->on('transaksi_sewas')->onDelete('cascade');
            $table->foreign('id_alat')->references('id_alat')->on('alats')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_sewas');
    }
};
