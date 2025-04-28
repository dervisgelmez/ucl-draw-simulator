<?php

namespace App\Enums\Simulate;

use App\Supports\Enum;

enum SimulateEventTypeEnum: string
{
    case GOAL = 'goal';
    case PENALTY = 'penalty';
    case PENALTY_GOAL = 'penalty_goal';
    case PENALTY_MISS = 'penalty_miss';
    case FREE_KICK = 'free_kick';
    case FREE_KICK_GOAL = 'free_kick_goal';
    case FREE_KICK_MISS = 'free_kick_miss';
    case YELLOW_CARD = 'yellow_card';
    case RED_CARD = 'red_card';
    case CARD = 'card';
    case INJURY = 'injury';
    case PASS = 'pass';

    public static function values(): array
    {
        return Enum::values(SimulateEventTypeEnum::class);
    }
}
