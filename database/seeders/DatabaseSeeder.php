<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            SettingSeeder::class,
            CohortSeeder::class,
            ProgramSeeder::class,
            ServiceSeeder::class,
            TeamSeeder::class,
            StartupSeeder::class,
            NewsSeeder::class,
        ]);
    }
}
