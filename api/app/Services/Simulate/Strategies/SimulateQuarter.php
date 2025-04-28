<?php

namespace App\Services\Simulate\Strategies;

use App\Models\Fixture;
use App\Services\Simulate\AbstractSimulateStrategy;

class SimulateQuarter extends AbstractSimulateStrategy
{
    public function handle(Fixture $fixture): void
    {
        $matches = $fixture->waitingMatches()->get();
        foreach ($matches as $match) {
            $this->simulate($match);
        }

        $fixture->week = 11;
        $fixture->save();

        $this->next($fixture);
    }
}
