<?php

namespace App\Services\Fixture;

use Carbon\Carbon;
use App\Models\Fixture;
use App\Enums\StageEnum;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Fixture\FixtureResource;

class FixtureService
{
    public function getActiveFixture(): ?FixtureResource
    {
        $fixture = Fixture::findOneByActive();
        if (!$fixture) {
            return null;
        }

        return FixtureResource::make($fixture);
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function generateFixture(): void
    {
        retry(5, function () {
            DB::transaction(function () {
                // Delete old fixtures
                Fixture::query()->delete();

                $date = Carbon::now();
                $stageEnum = StageEnum::first();

                $fixture = Fixture::query()
                    ->create([
                        'name' => "Season {$date->format('Y')}",
                        'stage_id' => $stageEnum->stage()->id,
                        'week' => 1
                    ]);

                // Generate fixture groups
                FixtureGroupService::generateFixtureGroups($fixture);

                // Fill fixture groups with teams
                FixtureGroupService::assignTeamsToFixtureGroups($fixture);

                // Generate all matches for group teams
                $stageEnum->service()->generate($fixture);
            });
        });
    }

    public function simulateFixture(Fixture $fixture): void
    {
        $enum = StageEnum::tryFrom($fixture->stage->name);

        $nextStageEnum = $enum->next();
        if (!$nextStageEnum) {
            return;
        }

        $fixture->stage_id = $nextStageEnum->stage()->id;
        $fixture->save();

        $nextStageEnum->service()->generate($fixture);
    }
}
