<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dendas', function (Blueprint $table) {
            // Kolom untuk pengurangan/potongan denda
            $table->integer('potongan_denda')->default(0)->after('total_denda')->comment('Jumlah pengurangan denda');
            $table->text('alasan_potongan')->nullable()->after('potongan_denda')->comment('Alasan diberikan potongan');
            $table->unsignedBigInteger('diputuskan_oleh')->nullable()->after('alasan_potongan')->comment('ID user admin yang memberikan potongan');
            $table->timestamp('tanggal_potongan')->nullable()->after('diputuskan_oleh')->comment('Tanggal potongan diberikan');
            
            // Foreign key untuk admin yang memberikan potongan
            $table->foreign('diputuskan_oleh')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('dendas', function (Blueprint $table) {
            $table->dropForeign(['diputuskan_oleh']);
            $table->dropColumn(['potongan_denda', 'alasan_potongan', 'diputuskan_oleh', 'tanggal_potongan']);
        });
    }
};
