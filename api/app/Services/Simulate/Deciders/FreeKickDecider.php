<?php

namespace App\Services\Simulate\Deciders;

use App\Models\TeamStat;

class FreeKickDecider
{
    public function isFreeKickScored(TeamStat $attackerStats, TeamStat $defenderStats): bool
    {
        $chance = ($attackerStats->shot * 0.5) + ($attackerStats->pass * 0.3) - ($defenderStats->defense * 0.3);
        $chance = max(5, min(70, $chance));

        return random_int(1, 100) <= $chance;
    }
}
