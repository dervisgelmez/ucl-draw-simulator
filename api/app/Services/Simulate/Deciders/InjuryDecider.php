<?php

namespace App\Services\Simulate\Deciders;

use App\Models\TeamStat;

class InjuryDecider
{
    public function decideInjuryTeam(TeamStat $homeStats, TeamStat $awayStats): string
    {
        $homeRisk = ($homeStats->injury_risk * 0.7) +
            ((100 - $homeStats->squad_depth) * 0.3);

        $awayRisk = ($awayStats->injury_risk * 0.7) +
            ((100 - $awayStats->squad_depth) * 0.3);

        $homeRisk += 5;
        $awayRisk += 5;

        $totalRisk = $homeRisk + $awayRisk;
        $random = random_int(1, $totalRisk);

        return $random <= $homeRisk ? 'home' : 'away';
    }
}
