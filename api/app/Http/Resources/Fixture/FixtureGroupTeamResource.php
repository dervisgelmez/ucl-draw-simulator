<?php

namespace App\Http\Resources\Fixture;

use App\Utils\FixtureUtils;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FixtureGroupTeamResource extends JsonResource
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
            'logo' => $this->logo,
            'country' => $this->country,
            'name' => $this->name,
            'attributes' => FixtureUtils::calculateTableStats($this->resource)
        ];
    }
}
