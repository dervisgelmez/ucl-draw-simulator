<?php

namespace App\Services\Simulate;

use App\Models\Fixture;
use App\Enums\SimulateStrategiesEnum;
use App\Http\Requests\SimulateRequest;
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

    public function simulate(Fixture $fixture, SimulateRequest $request): void
    {
        if (!isset($this->strategies[$request->getStrategy()])) {
            throw new NotFoundHttpException('errors.strategy.not_found');
        }

        /** @var AbstractSimulateStrategy $strategy */
        $strategy = app($this->strategies[$request->getStrategy()]);

        $strategy->handle($fixture);
    }
}
