<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alats', function (Blueprint $table) {
            $table->bigIncrements('id_alat'); // PK
            $table->string('nama_alat');
            $table->string('kategori');
            $table->string('merk')->nullable();
            $table->integer('stok')->default(0);
            $table->integer('harga_sewa'); // per hari
            $table->string('gambar')->nullable(); // nama file gambar
            $table->text('deskripsi')->nullable();
            $table->text('kegunaan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alats');
    }
};
