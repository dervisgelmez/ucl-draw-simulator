<?php

namespace App\Enums;

use App\Models\Stage;
use App\Services\Fixture\Match\AbstractFixtureMatchService;
use App\Services\Fixture\Match\Stages\FixtureFinalMatchService;
use App\Services\Fixture\Match\Stages\FixtureGroupMatchService;
use App\Services\Fixture\Match\Stages\FixtureQuarterMatchService;
use App\Services\Fixture\Match\Stages\FixtureRoundMatchService;
use App\Services\Fixture\Match\Stages\FixtureSemiMatchService;

enum StageEnum: string
{
    case GROUP_STAGE = 'group_stage';
    case ROUND_OF_16 = 'round_of_16';
    case QUARTER_FINAL = 'quarter_final';
    case SEMI_FINAL = 'semi_final';
    case FINAL = 'final';

    public static function first(): StageEnum
    {
        return self::GROUP_STAGE;
    }

    public function label(): string
    {
        return match ($this) {
            self::GROUP_STAGE => 'Group Stage',
            self::ROUND_OF_16 => 'Round of 16',
            self::QUARTER_FINAL => 'Quarter Finals',
            self::SEMI_FINAL => 'Semi Finals',
            self::FINAL => 'Final',
        };
    }

    public function order(): int
    {
        return match ($this) {
            self::GROUP_STAGE => 1,
            self::ROUND_OF_16 => 2,
            self::QUARTER_FINAL => 3,
            self::SEMI_FINAL => 4,
            self::FINAL => 5
        };
    }

    public function isKnockout(): bool
    {
        return match ($this) {
            self::GROUP_STAGE => false,
            self::ROUND_OF_16,
            self::QUARTER_FINAL,
            self::SEMI_FINAL,
            self::FINAL => true,
        };
    }

    public function isFinal(): bool
    {
        return $this === self::FINAL;
    }

    public function next(): ?StageEnum
    {
        return match ($this) {
            self::GROUP_STAGE => self::ROUND_OF_16,
            self::ROUND_OF_16 => self::QUARTER_FINAL,
            self::QUARTER_FINAL => self::SEMI_FINAL,
            self::SEMI_FINAL => self::FINAL,
            self::FINAL => null
        };
    }

    public function stage(): ?Stage
    {
        return Stage::findOneByEnum($this);
    }

    public function service(): AbstractFixtureMatchService
    {
        return match ($this) {
            self::GROUP_STAGE => app(FixtureGroupMatchService::class),
            self::ROUND_OF_16 => app(FixtureRoundMatchService::class),
            self::QUARTER_FINAL => app(FixtureQuarterMatchService::class),
            self::SEMI_FINAL => app(FixtureSemiMatchService::class),
            self::FINAL => app(FixtureFinalMatchService::class)
        };
    }
}
