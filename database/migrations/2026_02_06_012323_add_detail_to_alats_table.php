<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('alats', function (Blueprint $table) {
        // Fields already added in main migration, so this is now a no-op
        // but keeping for backward compatibility
    });
}


public function down()
{
    Schema::table('alats', function (Blueprint $table) {
        // No changes to revert
    });
}
};
