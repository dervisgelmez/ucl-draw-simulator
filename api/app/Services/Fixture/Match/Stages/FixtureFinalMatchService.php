<?php

namespace App\Services\Fixture\Match\Stages;

use App\Enums\StageEnum;
use App\Models\Stage;
use App\Services\Fixture\Match\AbstractFinalMatchService;

class FixtureFinalMatchService extends AbstractFinalMatchService
{
    protected function getReferenceStage(): Stage
    {
        return StageEnum::SEMI_FINAL->stage();
    }

    protected function isFinal(): bool
    {
        return true;
    }
}
