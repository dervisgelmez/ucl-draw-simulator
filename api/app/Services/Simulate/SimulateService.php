<?php

namespace App\Services\Simulate;

use App\Models\Fixture;
use App\Enums\SimulateStrategiesEnum;
use App\Services\Simulate\Strategies\SimulateGroupStage;
use App\Services\Simulate\Strategies\SimulateWeekly;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SimulateService
{
    protected array $strategies = [];

    public function __construct()
    {
        $this->strategies = [
            SimulateStrategiesEnum::WEEKLY->value => SimulateWeekly::class,
            SimulateStrategiesEnum::GROUPS->value => SimulateGroupStage::class,
        ];
    }

    public function simulate(Fixture $fixture, SimulateStrategiesEnum $enum): void
    {
        if (!isset($this->strategies[$enum->value])) {
            throw new NotFoundHttpException('errors.strategy.not_found');
        }

        /** @var AbstractSimulateStrategy $strategy */
        $strategy = app($this->strategies[$enum->value]);

        $strategy->handle($fixture);
    }
}
