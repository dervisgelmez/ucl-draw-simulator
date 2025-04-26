<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('seeders/data/teams.json'));

        $data = json_decode($json, true);
        foreach ($data as $t) {
            $team = Team::query()->updateOrCreate(
                [
                    'name' => $t['team_name'],
                ],
                [
                    'name' => $t['team_name'],
                    'main_color' => $t['main_color'],
                    'country' => $t['country'],
                    'logo' => $t['team_logo'],
                ]
            );

            $team->stats()->updateOrCreate(
                [
                    'team_id' => $team->id,
                ],
                [
                    'attack' => $t['attack'],
                    'midfield' => $t['midfield'],
                    'defense' => $t['defense'],
                    'speed' => $t['speed'],
                    'pass' => $t['pass'],
                    'shot' => $t['shot'],
                    'squad_depth' => $t['squad_depth'],
                    'injury_risk' => $t['injury_risk'],
                    'home_advantage' => $t['home_advantage'],
                    'min_temp_performance' => $t['min_temp_performance'],
                    'max_temp_performance' => $t['max_temp_performance'],
                    'winner_mentality' => $t['winner_mentality'],
                    'loser_mentality' => $t['loser_mentality'],
                    'star_players_count' => $t['star_players_count'],
                    'manager_influence' => $t['manager_influence'],
                ]);
        }
    }
}
