<?php

namespace App\Services\Simulate\Deciders;

use App\Models\TeamStat;

class PenaltyDecider
{
    public function isPenaltyScored(TeamStat $attackerStats): bool
    {
        $chance = ($attackerStats->shot * 0.7) - ($attackerStats->loser_mentality * 0.3);

        $chance = max(10, min(90, $chance));

        return random_int(1, 100) <= $chance;
    }
}
