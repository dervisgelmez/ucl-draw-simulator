<?php

namespace App\Services\Simulate;

use App\Models\Fixture;
use App\Models\FixtureMatch;
use App\Services\Fixture\FixtureService;

abstract class AbstractSimulateStrategy implements SimulateStrategy
{
    protected FixtureService $fixtureService;
    protected SimulateService $simulateService;

    public function __construct()
    {
        $this->fixtureService = new FixtureService();
        $this->simulateService = new SimulateService();
    }

    protected function simulate(FixtureMatch $match): void
    {
        $this->simulateService->simulateMatch($match);
    }

    protected function next(Fixture $fixture): void
    {
        $this->fixtureService->simulateFixture($fixture);
    }

    abstract public function handle(Fixture $fixture);
}
