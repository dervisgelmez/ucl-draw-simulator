<?php

namespace Database\Seeders;

use App\Services\FixtureService;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TeamSeeder::class,
            StageSeeder::class
        ]);

        (new FixtureService())->generate();

        exit();
    }
}
