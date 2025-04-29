<?php

namespace App\Http\Resources\Fixture;

use App\Http\Resources\StageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Team\TeamResource;

class FixtureMatchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'week' => $this->week,
            'awayTeamScore' => $this->away_score,
            'homeTeamScore' => $this->home_score,
            'date' => $this->match_date,
            'completedAt' => $this->completed_at,
            'stage' => $this->whenLoaded('stage', function () {
                return $this->stage ? StageResource::make($this->stage) : null;
            }),
            'homeTeam' => $this->whenLoaded('homeTeam', function () {
                return $this->homeTeam ? TeamResource::make($this->homeTeam) : null;
            }),
            'awayTeam' => $this->whenLoaded('awayTeam', function () {
                return $this->awayTeam ? TeamResource::make($this->awayTeam) : null;
            }),
            'logs' => $this->whenLoaded('logs', function () {
                return $this->logs ?? null;
            }),
        ];
    }
}
