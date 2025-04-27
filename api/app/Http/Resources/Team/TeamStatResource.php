<?php

namespace App\Http\Resources\Team;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamStatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'attack' => $this->attack,
            'midfield' => $this->midfield,
            'defense' => $this->defense,
            'speed' => $this->speed,
            'pass' => $this->pass,
            'shot' => $this->shot,
            'squadDepth' => $this->squad_depth,
            'injuryRisk' => $this->injury_risk,
            'homeAdvantage' => $this->home_advantage,
            'minTempPerformance' => $this->min_temp_performance,
            'maxTempPerformance' => $this->max_temp_performance,
            'winnerMentality' => $this->winner_mentality,
            'loserMentality' => $this->loser_mentality,
            'starPlayersCount' => $this->star_players_count,
            'managerInfluence' => $this->manager_influence,
        ];
    }
}
