<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi_sewas', function (Blueprint $table) {
            $table->foreign('id_alat')
                  ->references('id_alat')->on('alats')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('transaksi_sewas', function (Blueprint $table) {
            $table->dropForeign(['id_alat']);
        });
    }
};
