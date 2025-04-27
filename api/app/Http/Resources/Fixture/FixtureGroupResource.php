<?php

namespace App\Http\Resources\Fixture;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FixtureGroupResource extends JsonResource
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
            'name' => $this->name,
            'teams' => $this->whenLoaded('teams', function () {
                return $this->teams ? FixtureGroupTeamResource::collection($this->teams) : null;
            }),
        ];
    }
}
