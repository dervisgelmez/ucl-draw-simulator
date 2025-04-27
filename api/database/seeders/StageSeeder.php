<?php

namespace Database\Seeders;

use App\Enums\StageEnum;
use App\Models\Stage;
use Illuminate\Database\Seeder;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stages = StageEnum::cases();

        foreach ($stages as $stage) {
            Stage::query()->updateOrCreate(
                ['name' => $stage->value],
                [
                    'name' => $stage->value,
                    'order' => $stage->order()
                ]
            );
        }
    }
}
