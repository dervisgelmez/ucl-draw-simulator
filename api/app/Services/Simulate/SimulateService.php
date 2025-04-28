<?php

namespace App\Services\Simulate;

use Carbon\Carbon;
use App\Models\FixtureMatch;
use App\Models\FixtureMatchLog;
use App\Enums\Simulate\SimulateEventTypeEnum;
use App\Services\Simulate\Deciders\CardDecider;
use App\Services\Simulate\Deciders\GoalDecider;
use App\Services\Simulate\Deciders\InjuryDecider;
use App\Services\Simulate\Deciders\PenaltyDecider;
use App\Services\Simulate\Deciders\FreeKickDecider;

class SimulateService
{
    protected GoalDecider $goalDecider;
    protected PenaltyDecider $penaltyDecider;
    protected FreeKickDecider $freeKickDecider;
    protected CardDecider $cardDecider;
    protected InjuryDecider $injuryDecider;
    protected bool $isLowTempoMatch = false;

    protected const NORMAL_EVENT_OCCURRENCE_CHANCE = 7;
    protected const LOW_TEMPO_EVENT_OCCURRENCE_CHANCE = 3;
    protected const LOW_TEMPO_MATCH_PROBABILITY = 10;

    public function __construct()
    {
        $this->goalDecider = new GoalDecider();
        $this->penaltyDecider = new PenaltyDecider();
        $this->freeKickDecider = new FreeKickDecider();
        $this->cardDecider = new CardDecider();
        $this->injuryDecider = new InjuryDecider();
    }

    public function simulateMatch(FixtureMatch $match): array
    {
        $this->isLowTempoMatch = random_int(1, 100) <= self::LOW_TEMPO_MATCH_PROBABILITY;

        $homeTeam = $match->homeTeam;
        $awayTeam = $match->awayTeam;
        $homeStats = $homeTeam->stats;
        $awayStats = $awayTeam->stats;

        $homeScore = 0;
        $awayScore = 0;

        for ($minute = 1; $minute <= 90; $minute++) {
            if ($this->isEventOccurring()) {
                $eventResult = $this->simulateEvent(
                    $this->determineEventType(),
                    $minute,
                    $match,
                    $homeTeam,
                    $awayTeam,
                    $homeStats,
                    $awayStats
                );

                if ($eventResult !== null) {
                    $homeScore += $eventResult['home'] ?? 0;
                    $awayScore += $eventResult['away'] ?? 0;
                }
            }
        }

        $match->update([
            'home_score' => $homeScore,
            'away_score' => $awayScore,
            'completed_at' => Carbon::now(),
        ]);

        return [
            'home_score' => $homeScore,
            'away_score' => $awayScore,
        ];
    }

    protected function isEventOccurring(): bool
    {
        $chance = $this->isLowTempoMatch
            ? self::LOW_TEMPO_EVENT_OCCURRENCE_CHANCE
            : self::NORMAL_EVENT_OCCURRENCE_CHANCE;

        return random_int(1, 100) <= $chance;
    }

    protected function determineEventType(): SimulateEventTypeEnum
    {
        $roll = random_int(1, 100);

        return match (true) {
            $roll <= 30 => SimulateEventTypeEnum::GOAL,
            $roll <= 40 => SimulateEventTypeEnum::PENALTY,
            $roll <= 75 => SimulateEventTypeEnum::PASS,
            $roll <= 85 => SimulateEventTypeEnum::FREE_KICK,
            $roll <= 90 => SimulateEventTypeEnum::CARD,
            default => SimulateEventTypeEnum::INJURY,
        };
    }


    protected function simulateEvent(
        SimulateEventTypeEnum $eventType,
        int                   $minute,
        FixtureMatch          $match,
                              $homeTeam,
                              $awayTeam,
                              $homeStats,
                              $awayStats
    ): ?array
    {
        return match ($eventType) {
            SimulateEventTypeEnum::GOAL => $this->simulateGoalEvent($minute, $match, $homeTeam, $awayTeam),
            SimulateEventTypeEnum::PENALTY => $this->simulatePenaltyEvent($minute, $match, $homeTeam, $awayTeam),
            SimulateEventTypeEnum::FREE_KICK => $this->simulateFreeKickEvent($minute, $match, $homeTeam, $awayTeam),
            SimulateEventTypeEnum::CARD => $this->simulateCardEvent($minute, $match, $homeTeam, $awayTeam, $homeStats, $awayStats),
            SimulateEventTypeEnum::INJURY => $this->simulateInjuryEvent($minute, $match, $homeTeam, $awayTeam, $homeStats, $awayStats),
            default => null,
        };
    }

    protected function simulateGoalEvent(int $minute, FixtureMatch $match, $homeTeam, $awayTeam): array
    {
        $scoringSide = $this->goalDecider->decideScoringTeam($homeTeam->stats, $awayTeam->stats);
        $team = $scoringSide === 'home' ? $homeTeam : $awayTeam;

        $this->logEvent($match, $minute, $team->id, SimulateEventTypeEnum::GOAL);

        return [
            'home' => $scoringSide === 'home' ? 1 : 0,
            'away' => $scoringSide === 'away' ? 1 : 0,
        ];
    }

    protected function simulatePenaltyEvent(int $minute, FixtureMatch $match, $homeTeam, $awayTeam): array
    {
        $scoringSide = $this->goalDecider->decideScoringTeam($homeTeam->stats, $awayTeam->stats);
        $team = $scoringSide === 'home' ? $homeTeam : $awayTeam;
        $teamStats = $scoringSide === 'home' ? $homeTeam->stats : $awayTeam->stats;

        if ($this->penaltyDecider->isPenaltyScored($teamStats)) {
            $this->logEvent($match, $minute, $team->id, SimulateEventTypeEnum::PENALTY_GOAL);

            return [
                'home' => $scoringSide === 'home' ? 1 : 0,
                'away' => $scoringSide === 'away' ? 1 : 0,
            ];
        }

        $this->logEvent($match, $minute, $team->id, SimulateEventTypeEnum::PENALTY_MISS);

        return [
            'home' => 0,
            'away' => 0,
        ];
    }

    protected function simulateFreeKickEvent(int $minute, FixtureMatch $match, $homeTeam, $awayTeam): array
    {
        $attackingTeam = random_int(0, 1) === 0 ? $homeTeam : $awayTeam;
        $defendingTeam = $attackingTeam->id === $homeTeam->id ? $awayTeam : $homeTeam;

        if ($this->freeKickDecider->isFreeKickScored($attackingTeam->stats, $defendingTeam->stats)) {
            $this->logEvent($match, $minute, $attackingTeam->id, SimulateEventTypeEnum::FREE_KICK_GOAL);

            return [
                'home' => $attackingTeam->id === $homeTeam->id ? 1 : 0,
                'away' => $attackingTeam->id === $awayTeam->id ? 1 : 0,
            ];
        }

        $this->logEvent($match, $minute, $attackingTeam->id, SimulateEventTypeEnum::FREE_KICK_MISS);

        return [
            'home' => 0,
            'away' => 0,
        ];
    }

    protected function simulateCardEvent(
        int          $minute,
        FixtureMatch $match,
                     $homeTeam,
                     $awayTeam,
                     $homeStats,
                     $awayStats
    ): null
    {
        $cardSide = $this->cardDecider->decideCardTeam($homeStats, $awayStats);
        $team = ($cardSide === 'home') ? $homeTeam : $awayTeam;
        $teamStats = $team->stats;

        $cardType = random_int(1, 100) <= 80
            ? SimulateEventTypeEnum::YELLOW_CARD
            : SimulateEventTypeEnum::RED_CARD;

        $this->logEvent($match, $minute, $team->id, $cardType);

        if ($cardType === SimulateEventTypeEnum::RED_CARD) {
            $this->applyRedCardPenalty($teamStats);
        }

        return null;
    }

    protected function applyRedCardPenalty($teamStats): void
    {
        $penaltyPercent = random_int(3, 5);

        $newMidfield = (int)round($teamStats->midfield * (1 - $penaltyPercent / 100));
        $teamStats->midfield = max(0, $newMidfield);

        $teamStats->save();
    }

    protected function simulateInjuryEvent(
        int          $minute,
        FixtureMatch $match,
                     $homeTeam,
                     $awayTeam,
                     $homeStats,
                     $awayStats
    ): null
    {
        $injurySide = $this->injuryDecider->decideInjuryTeam($homeStats, $awayStats);
        $team = ($injurySide === 'home') ? $homeTeam : $awayTeam;
        $teamStats = $team->stats;

        $this->logEvent($match, $minute, $team->id, SimulateEventTypeEnum::INJURY);

        $this->applyInjuryPenalty($teamStats);

        return null;
    }

    protected function applyInjuryPenalty($teamStats): void
    {
        $teamStats->squad_depth = max(0, $teamStats->squad_depth - 5);

        $teamStats->attack = (int)round($teamStats->attack * 0.98);
        $teamStats->midfield = (int)round($teamStats->midfield * 0.98);

        $teamStats->attack = max(0, $teamStats->attack);
        $teamStats->midfield = max(0, $teamStats->midfield);

        $teamStats->save();
    }


    protected function logEvent(FixtureMatch $match, int $minute, string $teamId, SimulateEventTypeEnum $type): void
    {
        FixtureMatchLog::query()->create([
            'fixture_match_id' => $match->id,
            'team_id' => $teamId,
            'minute' => $minute,
            'type' => $type->value,
        ]);
    }
}
