<?php

namespace App\Services\Fixture\Match\Stages;

use App\Enums\StageEnum;
use App\Models\Stage;
use App\Services\Fixture\Match\AbstractFinalMatchService;

class FixtureQuarterMatchService extends AbstractFinalMatchService
{
    protected function getReferenceStage(): Stage
    {
        return StageEnum::ROUND_OF_16->stage();
    }
}
