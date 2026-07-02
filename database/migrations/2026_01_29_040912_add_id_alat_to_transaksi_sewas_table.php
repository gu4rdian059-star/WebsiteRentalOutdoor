<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // id_alat column is already in the create migration
        // This migration is now a no-op but kept for compatibility
    }

    public function down(): void
    {
        // No changes to revert
    }
};
