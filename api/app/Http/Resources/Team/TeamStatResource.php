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
            'squad_depth' => $this->squad_depth,
            'injury_risk' => $this->injury_risk,
            'home_advantage' => $this->home_advantage,
            'min_temp_performance' => $this->min_temp_performance,
            'max_temp_performance' => $this->max_temp_performance,
            'winner_mentality' => $this->winner_mentality,
            'loser_mentality' => $this->loser_mentality,
            'star_players_count' => $this->star_players_count,
            'manager_influence' => $this->manager_influence,
        ];
    }
}
