<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transaksi_sewas', function (Blueprint $table) {
            $table->integer('jumlah_satuan')->default(1)->after('jumlah_hari')->comment('Jumlah unit/satuan yang disewa');
        });
    }

    public function down()
    {
        Schema::table('transaksi_sewas', function (Blueprint $table) {
            $table->dropColumn('jumlah_satuan');
        });
    }
};
