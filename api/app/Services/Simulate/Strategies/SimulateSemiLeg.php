<?php

namespace App\Services\Simulate\Strategies;

use App\Models\Fixture;
use App\Services\Simulate\AbstractSimulateStrategy;

class SimulateSemiLeg extends AbstractSimulateStrategy
{
    public function handle(Fixture $fixture): void
    {
        $matches = $fixture->weeklyWaitingMatches()->get();
        foreach ($matches as $match) {
            $this->simulate($match);
        }

        $fixture->week++;
        $fixture->save();

        if ($fixture->week === 13) {
            $this->next($fixture);
        }
    }
}
