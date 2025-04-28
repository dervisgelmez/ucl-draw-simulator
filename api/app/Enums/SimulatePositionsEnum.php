<?php

namespace App\Enums;

use App\Supports\Enum;

enum SimulatePositionsEnum: string
{
    case GOAL = 'goal';
    case YELLOW_CARD = 'yellow_card';
    case RED_CARD = 'red_card';
    case INJURY = 'injury';
    case PENALTY_GOAL = 'penalty_goal';
    case PENALTY_MISS = 'penalty_miss';
    case FREE_KICK_GOAL = 'free_kick_goal';
    case FREE_KICK_MISS = 'free_kick_miss';

    public static function values(): array
    {
        return Enum::values(SimulatePositionsEnum::class);
    }
}
