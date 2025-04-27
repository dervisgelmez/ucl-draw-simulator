<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Stage;
use App\Models\Fixture;
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
    public function generate(): void
    {
        retry(5, function () {
            DB::transaction(function () {
                // Delete old fixtures
                Fixture::query()->delete();

                $date = Carbon::now();
                $fixture = Fixture::query()
                    ->create([
                        'name' => "Season {$date->format('Y')}",
                        'stage_id' => Stage::findFirstStageId(),
                        'week' => 1
                    ]);

                // Generate fixture groups
                FixtureGroupService::generateFixtureGroups($fixture);

                // Fill fixture groups with teams
                FixtureGroupService::assignTeamsToFixtureGroups($fixture);

                // Generate all matches for group teams
                FixtureMatchService::generateGroupMatches($fixture);
            });
        });
    }
}
