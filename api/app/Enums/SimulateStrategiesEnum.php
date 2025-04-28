<?php

namespace App\Enums;

use App\Supports\Enum;

enum SimulateStrategiesEnum: string
{
    case WEEKLY = 'weekly';
    case GROUPS = 'groups';

    public static function values(): array
    {
        return Enum::values(SimulatePositionsEnum::class);
    }
}
