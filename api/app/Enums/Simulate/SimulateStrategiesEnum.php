<?php

namespace App\Enums\Simulate;

use App\Services\Simulate\Strategies\SimulateGroupStage;
use App\Services\Simulate\Strategies\SimulateWeekly;
use App\Supports\Enum;

enum SimulateStrategiesEnum: string
{
    case WEEKLY = 'weekly';
    case GROUPS = 'groups';

    public static function values(): array
    {
        return Enum::values(SimulateStrategiesEnum::class);
    }

    public function strategy(): string
    {
        return match ($this) {
            self::WEEKLY => SimulateWeekly::class,
            self::GROUPS => SimulateGroupStage::class,
        };
    }
}
