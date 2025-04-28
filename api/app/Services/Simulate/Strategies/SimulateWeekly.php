<?php

namespace App\Services\Simulate\Strategies;

use App\Models\Fixture;
use App\Models\Stage;
use App\Services\Simulate\AbstractSimulateStrategy;

class SimulateWeekly extends AbstractSimulateStrategy
{
    public function handle(Fixture $fixture): void
    {
        $matches = $fixture->weeklyWaitingMatches()->get();
        foreach ($matches as $match) {
            $this->simulate($match);
        }

        if ($fixture->week === 6) {
            $fixture->stage_id = Stage::findNextStageId($fixture->stage);
            $fixture->save();
            return;
        }

        $fixture->week++;
        $fixture->save();
    }
}
