<?php

namespace App\Services\Simulate\Deciders;

use App\Models\TeamStat;

class CardDecider
{
    public function decideCardTeam(TeamStat $homeStats, TeamStat $awayStats): string
    {
        $homeRisk = ($homeStats->loser_mentality * 0.5) +
            ((100 - $homeStats->defense) * 0.3) +
            ((100 - $homeStats->manager_influence) * 0.2);

        $awayRisk = ($awayStats->loser_mentality * 0.5) +
            ((100 - $awayStats->defense) * 0.3) +
            ((100 - $awayStats->manager_influence) * 0.2);

        // Ufak temel risk ekle (sürpriz kartlar için)
        $homeRisk += 5;
        $awayRisk += 5;

        $totalRisk = $homeRisk + $awayRisk;
        $random = random_int(1, $totalRisk);

        return $random <= $homeRisk ? 'home' : 'away';
    }
}
