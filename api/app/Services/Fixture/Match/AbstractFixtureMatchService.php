<?php

namespace App\Services\Fixture\Match;

use App\Models\Fixture;
use App\Models\FixtureMatch;
use App\Models\Team;
use Carbon\Carbon;
use Carbon\CarbonInterface;

abstract class AbstractFixtureMatchService
{
    abstract public function generate(Fixture $fixture): void;

    protected function createMatch(Fixture $fixture, Team $homeTeam, Team $awayTeam, Carbon $date, int $week): void
    {
        $matchDate = $date->copy()->next(CarbonInterface::TUESDAY);
        if (rand(0, 1)) {
            $matchDate->addDay();
        }

        [$hour, $minute] = explode(':', collect(['21:45', '23:00'])->random());
        $matchDate->setTime($hour, $minute);

        FixtureMatch::query()->create([
            'fixture_id' => $fixture->id,
            'stage_id' => $fixture->stage_id,
            'week' => $week,
            'home_team_id' => $homeTeam->id,
            'away_team_id' => $awayTeam->id,
            'match_date' => $matchDate,
        ]);
    }
}
