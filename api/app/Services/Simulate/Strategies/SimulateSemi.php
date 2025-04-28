<?php

namespace App\Services\Simulate\Strategies;

use App\Models\Fixture;
use App\Services\Simulate\AbstractSimulateStrategy;

class SimulateSemi extends AbstractSimulateStrategy
{
    public function handle(Fixture $fixture): void
    {
        $matches = $fixture->waitingMatches()->get();
        foreach ($matches as $match) {
            $this->simulate($match);
        }

        $fixture->week = 13;
        $fixture->save();

        $this->next($fixture);
    }
}
