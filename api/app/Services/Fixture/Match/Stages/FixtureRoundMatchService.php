<?php

namespace App\Services\Fixture\Match\Stages;

use App\Enums\StageEnum;
use App\Models\Fixture;
use App\Models\FixtureGroup;
use App\Models\FixtureMatch;
use App\Services\Fixture\Match\AbstractFixtureMatchService;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class FixtureRoundMatchService extends AbstractFixtureMatchService
{
    public function generate(Fixture $fixture): void
    {
        [$pot1, $pot2] = $this->getQualifiedTeams($fixture);

        $matches = $this->drawMatches($pot1, $pot2);

        $startDate = Carbon::now()->addWeeks(8);
        foreach ($matches as $match) {
            $this->createMatch($fixture, $match['home'], $match['away'], $startDate, 7);
            $this->createMatch($fixture, $match['away'], $match['home'], $startDate->copy()->addWeek(), 8);
        }
    }

    private function getQualifiedTeams(Fixture $fixture): array
    {
        $groups = $fixture
            ->groups()
            ->with('teams')
            ->get();

        $pot1 = collect();
        $pot2 = collect();

        foreach ($groups as $group) {
            $teamStats = $this->calculateGroupStandings($fixture, $group);

            if ($teamStats->count() >= 2) {
                $pot1->push($teamStats[0]['team']);
                $pot2->push($teamStats[1]['team']);
            }
        }

        return [$pot1, $pot2];
    }

    private function calculateGroupStandings(Fixture $fixture, FixtureGroup $group): Collection
    {
        $teams = $group->teams;

        $stats = collect();

        foreach ($teams as $team) {
            $matches = FixtureMatch::query()
                ->where('fixture_id', $fixture->id)
                ->where('stage_id', StageEnum::GROUP_STAGE->stage()->id)
                ->where(function ($query) use ($team) {
                    $query->where('home_team_id', $team->id)
                        ->orWhere('away_team_id', $team->id);
                })
                ->whereNotNull('completed_at')
                ->get();

            $points = 0;
            $goalsFor = 0;
            $goalsAgainst = 0;

            foreach ($matches as $match) {
                if ($match->home_team_id === $team->id) {
                    $goalsFor += $match->home_score ?? 0;
                    $goalsAgainst += $match->away_score ?? 0;

                    if (($match->home_score ?? 0) > ($match->away_score ?? 0)) {
                        $points += 3;
                    } elseif (($match->home_score ?? 0) === ($match->away_score ?? 0)) {
                        $points += 1;
                    }
                } elseif ($match->away_team_id === $team->id) {
                    $goalsFor += $match->away_score ?? 0;
                    $goalsAgainst += $match->home_score ?? 0;

                    if (($match->away_score ?? 0) > ($match->home_score ?? 0)) {
                        $points += 3;
                    } elseif (($match->away_score ?? 0) === ($match->home_score ?? 0)) {
                        $points += 1;
                    }
                }
            }

            $stats->push([
                'team' => $team,
                'points' => $points,
                'goal_difference' => $goalsFor - $goalsAgainst,
                'goals_for' => $goalsFor,
            ]);
        }

        return $stats->sortByDesc(fn($t) => [
            $t['points'],
            $t['goal_difference'],
            $t['goals_for'],
        ])->values();
    }

    private function drawMatches(Collection $pot1, Collection $pot2): array
    {
        $matches = [];
        $pot2 = $pot2->shuffle();
        foreach ($pot1 as $homeTeam) {
            $awayTeam = $pot2->shift();

            $matches[] = [
                'home' => $homeTeam,
                'away' => $awayTeam,
            ];
        }

        return $matches;
    }
}
