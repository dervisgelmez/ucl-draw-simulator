<?php

namespace App\Services\Simulate;

use App\Models\FixtureMatch;
use App\Models\Fixture;

abstract class AbstractSimulateStrategy implements SimulateStrategy
{
    abstract public function handle(Fixture $fixture);

    protected function handleMatch(FixtureMatch $match): array
    {
        // TODO: Calculate match results
    }
}
