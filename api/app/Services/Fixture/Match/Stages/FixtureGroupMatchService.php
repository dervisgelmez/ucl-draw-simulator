<?php

namespace App\Services\Fixture\Match\Stages;

use App\Models\Fixture;
use App\Services\Fixture\Match\AbstractFixtureMatchService;
use Carbon\Carbon;

class FixtureGroupMatchService extends AbstractFixtureMatchService
{
    public function generate(Fixture $fixture): void
    {
        $startDate = Carbon::now()->addDays(7);

        $groups = $fixture
            ->groups()
            ->with('teams')
            ->get();

        $groupSchedules = [];
        foreach ($groups as $group) {
            $groupSchedules[$group->id] = $this->generateGroupMatchSchedule($group->teams);
        }

        for ($week = 1; $week <= 6; $week++) {
            foreach ($groups as $group) {
                $matches = $groupSchedules[$group->id][$week - 1];
                foreach ($matches as $match) {
                    $this->createMatch($fixture, $match['home'], $match['away'], $startDate, $week);
                }
            }

            $startDate->addWeek();
        }
    }

    private function generateGroupMatchSchedule($teams): array
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
}
