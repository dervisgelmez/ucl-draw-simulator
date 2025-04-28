<?php

namespace App\Services\Fixture\Match\Stages;

use App\Enums\StageEnum;
use App\Models\Stage;
use App\Services\Fixture\Match\AbstractFinalMatchService;

class FixtureSemiMatchService extends AbstractFinalMatchService
{
    protected function getReferenceStage(): Stage
    {
        return StageEnum::QUARTER_FINAL->stage();
    }
}
