<?php

namespace App\Services\Simulate\Deciders;

use App\Models\TeamStat;

class GoalDecider
{
    public function decideScoringTeam(TeamStat $homeStats, TeamStat $awayStats): string
    {
        $homeChance = ($homeStats->attack * 0.4) +
            ($homeStats->midfield * 0.2) +
            ($homeStats->pass * 0.2) +
            ($homeStats->shot * 0.2) +
            ($homeStats->home_advantage * 0.5);

        $awayChance = ($awayStats->attack * 0.4) +
            ($awayStats->midfield * 0.2) +
            ($awayStats->pass * 0.2) +
            ($awayStats->shot * 0.2);

        $homeChance += 5;
        $awayChance += 5;

        $total = $homeChance + $awayChance;
        $random = rand(1, $total);

        return $random <= $homeChance ? 'home' : 'away';
    }
}
