<?php

namespace App\Services\Simulate\Strategies;

use App\Models\Fixture;
use App\Services\Simulate\AbstractSimulateStrategy;

class SimulateFinal extends AbstractSimulateStrategy
{
    public function handle(Fixture $fixture): void
    {
        $matches = $fixture->weeklyWaitingMatches()->get();
        foreach ($matches as $match) {
            $this->simulate($match);
        }
    }
}
