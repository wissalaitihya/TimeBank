<?php

namespace Database\Seeders;

use Database\Seeders\SkillSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            \Database\Seeders\SkillSeeder::class,
            \Database\Seeders\UserSeeder::class,
        ]);
    }
}
