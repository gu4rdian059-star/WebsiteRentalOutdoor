<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alats', function (Blueprint $table) {
            // gambar column already added in main migration
            // This is now a no-op but kept for backward compatibility
        });
    }

    public function down(): void
    {
        Schema::table('alats', function (Blueprint $table) {
            // No changes to revert
        });
    }
};
