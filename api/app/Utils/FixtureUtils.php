<?php

namespace App\Utils;

use App\Models\FixtureMatch;
use App\Models\Team;

class FixtureUtils
{
    public static function generateFixtureGroupsPayloadByTeams(): array
    {
        $groups = [];
        $groupCount = ceil(Team::query()->count() / 4);
        for ($i = 0; $i < $groupCount; $i++) {
            $groups[] = [
                'name' => 'Group ' . chr(65 + $i)
            ];
        }

        return $groups;
    }

    public static function calculateTableStats(Team $team): array
    {
        $matches = FixtureMatch::query()
            ->where(function ($query) use ($team) {
                $query->where('home_team_id', $team->id)
                    ->orWhere('away_team_id', $team->id);
            })
            ->whereNotNull('home_score')
            ->whereNotNull('away_score')
            ->get();

        $points = 0;
        $win = 0;
        $lose = 0;
        $draw = 0;
        $scored = 0;
        $conceded = 0;

        foreach ($matches as $match) {
            $isHome = $match->home_team_id === $team->id;

            $teamScore = $isHome ? $match->home_score : $match->away_score;
            $opponentScore = $isHome ? $match->away_score : $match->home_score;

            $scored += $teamScore;
            $conceded += $opponentScore;

            if ($teamScore > $opponentScore) {
                $points += 3;
                $win += 1;
            } elseif ($teamScore === $opponentScore) {
                $points += 1;
                $draw += 1;
            } else {
                $lose += 1;
            }
        }

        return [
            'played' => $matches->count(),
            'win' => $win,
            'lose' => $lose,
            'draw' => $draw,
            'points' => $points,
            'scored' => $scored,
            'conceded' => $scored,
            'average' => ($scored - $conceded)
        ];
    }
}
