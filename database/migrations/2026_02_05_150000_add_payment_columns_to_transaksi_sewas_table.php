<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transaksi_sewas', function (Blueprint $table) {
            // Tambah kolom payment status
            $table->string('payment_status')->default('pending')->after('status'); // pending, confirmed
            // Tambah kolom payment method
            $table->string('payment_method')->nullable()->after('payment_status'); // transfer_bank, e_wallet
            // Tambah kolom untuk tracking konfirmasi admin
            $table->timestamp('payment_confirmed_at')->nullable()->after('payment_method');
            $table->unsignedBigInteger('confirmed_by')->nullable()->after('payment_confirmed_at'); // admin user_id
        });
    }

    public function down()
    {
        Schema::table('transaksi_sewas', function (Blueprint $table) {
            $table->dropColumn(['payment_status', 'payment_method', 'payment_confirmed_at', 'confirmed_by']);
        });
    }
};
