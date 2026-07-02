<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder admin
        $this->call(AdminSeeder::class);

        // Panggil seeder alat
        $this->call(AlatSeeder::class);
    }
}
