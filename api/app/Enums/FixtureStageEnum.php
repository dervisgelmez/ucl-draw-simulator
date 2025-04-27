<?php

namespace App\Enums;

enum FixtureStageEnum: string
{
    case GROUP_STAGE = 'group_stage';
    case ROUND_OF_16 = 'round_of_16';
    case QUARTER_FINAL = 'quarter_final';
    case SEMI_FINAL = 'semi_final';
    case FINAL = 'final';

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

    public function order(): bool
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
}
