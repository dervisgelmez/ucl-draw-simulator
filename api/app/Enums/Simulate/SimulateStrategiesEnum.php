<?php

namespace App\Enums\Simulate;

use App\Services\Simulate\Strategies\SimulateFinal;
use App\Services\Simulate\Strategies\SimulateGroup;
use App\Services\Simulate\Strategies\SimulateQuarter;
use App\Services\Simulate\Strategies\SimulateQuarterLeg;
use App\Services\Simulate\Strategies\SimulateRound;
use App\Services\Simulate\Strategies\SimulateRoundLeg;
use App\Services\Simulate\Strategies\SimulateSemi;
use App\Services\Simulate\Strategies\SimulateSemiLeg;
use App\Services\Simulate\Strategies\SimulateWeekly;
use App\Supports\Enum;

enum SimulateStrategiesEnum: string
{
    case WEEKLY = 'weekly';
    case GROUPS = 'groups';
    case ROUND_LEG = 'round-legs';
    case ROUND = 'rounds';
    case QUARTER_LEG = 'quarter-legs';
    case QUARTER = 'quarters';
    case SEMI_LEG = 'semi-legs';
    case SEMI = 'semi';
    case FINAL = 'final';

    public static function values(): array
    {
        return Enum::values(SimulateStrategiesEnum::class);
    }

    public function strategy(): string
    {
        return match ($this) {
            self::WEEKLY => SimulateWeekly::class,
            self::GROUPS => SimulateGroup::class,
            self::ROUND_LEG => SimulateRoundLeg::class,
            self::ROUND => SimulateRound::class,
            self::QUARTER_LEG => SimulateQuarterLeg::class,
            self::QUARTER => SimulateQuarter::class,
            self::SEMI_LEG => SimulateSemiLeg::class,
            self::SEMI => SimulateSemi::class,
            self::FINAL => SimulateFinal::class
        };
    }
}
