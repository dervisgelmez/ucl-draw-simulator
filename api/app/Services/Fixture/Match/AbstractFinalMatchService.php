<?php

namespace App\Services\Fixture\Match;

use App\Models\Fixture;
use App\Models\FixtureMatch;
use App\Models\Stage;
use Carbon\Carbon;
use Illuminate\Support\Collection;

abstract class AbstractFinalMatchService extends AbstractFixtureMatchService
{
    abstract protected function getReferenceStage(): Stage;

    public function generate(Fixture $fixture): void
    {
        $matches = $this->generateMatches(
            $this->getWinners($fixture)
        );

        $startWeek = $fixture->week;
        $endWeek = $fixture->week + 1;

        $startDate = Carbon::now()->addWeeks($startWeek);
        foreach ($matches as $match) {
            $this->createMatch($fixture, $match['home'], $match['away'], $startDate, $startWeek);
            if (!$this->isFinal()) {
                $this->createMatch($fixture, $match['away'], $match['home'], $startDate->copy()->addWeek(), $endWeek);
            }
        }
    }

    protected function getWinners(Fixture $fixture): Collection
    {
        $matches = FixtureMatch::query()
            ->with(['homeTeam', 'awayTeam'])
            ->where('fixture_id', $fixture->id)
            ->where('stage_id', $this->getReferenceStage()->id)
            ->whereNotNull('completed_at')
            ->get();

        $groups = $matches->groupBy(function ($match) {
            return $this->generateGroupKey($match->home_team_id, $match->away_team_id);
        });

        $winners = collect();
        foreach ($groups as $matches) {
            /** @var FixtureMatch $firstMatch */
            $firstMatch = $matches->first();
            $homeTeam = $firstMatch->homeTeam;
            $awayTeam = $firstMatch->awayTeam;

            $homeGoals = 0;
            $awayGoals = 0;

            foreach ($matches as $match) {
                if ($match->home_team_id === $homeTeam->id) {
                    $homeGoals += $match->home_score ?? 0;
                    $awayGoals += $match->away_score ?? 0;
                } else {
                    $homeGoals += $match->away_score ?? 0;
                    $awayGoals += $match->home_score ?? 0;
                }
            }

            if ($homeGoals > $awayGoals) {
                $winners->push($homeTeam);
            } elseif ($awayGoals > $homeGoals) {
                $winners->push($awayTeam);
            } else {
                $winners->push(collect([$homeTeam, $awayTeam])->random());
            }
        }

        return $winners->shuffle();
    }

    private function generateGroupKey(string $homeTeamId, string $awayTeamId): string
    {
        $teams = [$homeTeamId, $awayTeamId];
        sort($teams);
        return implode('-', $teams);
    }

    private function generateMatches(Collection $teams): array
    {
        $matches = [];
        while ($teams->count() >= 2) {
            $homeTeamId = $teams->pop();
            $awayTeamId = $teams->pop();

            $matches[] = [
                'home' => $homeTeamId,
                'away' => $awayTeamId,
            ];
        }
        return $matches;
    }

    protected function isFinal(): bool
    {
        return false;
    }
}
