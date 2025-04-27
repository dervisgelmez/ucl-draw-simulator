<?php

namespace App\Http\Resources\Team;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
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
            'color' => $this->main_color,
            'stats' => $this->whenLoaded('stats', function () {
                return $this->stats ? TeamStatResource::make($this->stats) : null;
            }),
        ];
    }
}
