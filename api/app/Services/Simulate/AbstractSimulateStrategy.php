<?php

namespace App\Services\Simulate;

use App\Models\Fixture;
use App\Models\FixtureMatch;

abstract class AbstractSimulateStrategy implements SimulateStrategy
{
    protected SimulateService $simulateService;

    public function __construct()
    {
        $this->simulateService = new SimulateService();
    }

    protected function simulate(FixtureMatch $match): void
    {
        $this->simulateService->simulateMatch($match);
    }

    abstract public function handle(Fixture $fixture);
}
