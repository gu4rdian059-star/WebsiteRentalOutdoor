<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transaksi_sewas', function (Blueprint $table) {
            if (!Schema::hasColumn('transaksi_sewas', 'order_group_id')) {
                $table->string('order_group_id')->nullable()->after('user_id');
                $table->index('order_group_id');
            }
        });
    }

    public function down()
    {
        Schema::table('transaksi_sewas', function (Blueprint $table) {
            if (Schema::hasColumn('transaksi_sewas', 'order_group_id')) {
                $table->dropIndex(['order_group_id']);
                $table->dropColumn('order_group_id');
            }
        });
    }
};
