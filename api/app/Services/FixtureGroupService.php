<?php

namespace App\Services;

use App\Models\Team;
use App\Models\Fixture;
use App\Utils\FixtureUtils;
use Illuminate\Support\Facades\DB;

class FixtureGroupService
{
    /**
     * @param Fixture $fixture
     * @return void
     */
    public static function generateFixtureGroups(Fixture $fixture): void
    {
        $fixture
            ->groups()
            ->createMany(
                FixtureUtils::generateFixtureGroupsPayloadByTeams()
            );
    }

    /**
     * @param Fixture $fixture
     * @return void
     * @throws \Exception
     */
    public static function assignTeamsToFixtureGroups(Fixture $fixture): void
    {
        $teamsByPot = Team::all()->groupBy('pot');

        $fixtureGroups = $fixture->groups()->get();
        foreach ($fixtureGroups as $group) {
            self::assignTeamsToGroup($group, $teamsByPot);
        }
    }

    /**
     * @throws \Exception
     */
    private static function assignTeamsToGroup($group, &$teamsByPot): void
    {
        $assignedCountries = [];

        foreach (range(1, 4) as $pot) {
            $team = self::selectTeamForPot($teamsByPot[$pot] ?? [], $assignedCountries, $pot);

            DB::table('fixture_group_teams')
                ->insert([
                    'team_id' => $team->id,
                    'fixture_group_id' => $group->id,
                ]);

            $assignedCountries[] = $team->country;
            $teamsByPot[$pot] = $teamsByPot[$pot]->reject(fn($t) => $t->id === $team->id);
        }
    }

    /**
     * @throws \Exception
     */
    private static function selectTeamForPot($teams, array $assignedCountries, int $pot)
    {
        $availableTeams = $teams->filter(
            fn($team) => !in_array($team->country, $assignedCountries)
        );

        if ($availableTeams->isEmpty()) {
            throw new \Exception("No available teams for pot {$pot} without country conflict.");
        }

        return $availableTeams->random();
    }
}
