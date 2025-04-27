<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Team;
use App\Models\Fixture;
use Carbon\CarbonInterface;
use App\Models\FixtureMatch;

class FixtureMatchService
{
    public static function generateGroupMatches(Fixture $fixture): void
    {
        $startDate = Carbon::now()->addDays(7);

        $groups = $fixture
            ->groups()
            ->with('teams')
            ->get();

        $groupSchedules = [];
        foreach ($groups as $group) {
            $groupSchedules[$group->id] = FixtureMatchService::generateGroupMatchSchedule($group->teams);
        }

        for ($week = 1; $week <= 6; $week++) {
            foreach ($groups as $group) {
                $matches = $groupSchedules[$group->id][$week - 1];
                foreach ($matches as $match) {
                    FixtureMatchService::createFixtureMatch($fixture, $match['home'], $match['away'], $startDate, $week);
                }
            }

            $startDate->addWeek();
        }
    }

    private static function generateGroupMatchSchedule($teams): array
    {
        $schedule = [
            [
                ['home' => $teams[0], 'away' => $teams[1]],
                ['home' => $teams[2], 'away' => $teams[3]],
            ],
            [
                ['home' => $teams[0], 'away' => $teams[2]],
                ['home' => $teams[1], 'away' => $teams[3]],
            ],
            [
                ['home' => $teams[0], 'away' => $teams[3]],
                ['home' => $teams[1], 'away' => $teams[2]],
            ],
        ];

        $rematches = [];
        foreach ($schedule as $weekMatches) {
            $reverseWeek = [];
            foreach ($weekMatches as $match) {
                $reverseWeek[] = [
                    'home' => $match['away'],
                    'away' => $match['home'],
                ];
            }
            $rematches[] = $reverseWeek;
        }

        return array_merge($schedule, $rematches);
    }

    private static function createFixtureMatch(Fixture $fixture, Team $homeTeam, Team $awayTeam, Carbon $date, int $week): void
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
