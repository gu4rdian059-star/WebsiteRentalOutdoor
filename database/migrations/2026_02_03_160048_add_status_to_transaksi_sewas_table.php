<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('transaksi_sewas', function (Blueprint $table) {
            $table->enum('status', ['disewa', 'selesai', 'terlambat'])
                  ->default('disewa')
                  ->after('tanggal_kembali');
        });
    }

    public function down(): void
    {
        Schema::table('transaksi_sewas', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
