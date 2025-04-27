<?php

namespace App\Http\Resources\Fixture;

use Illuminate\Http\Request;
use App\Http\Resources\StageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FixtureResource extends JsonResource
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
            'created_at' => $this->created_at,
            'stage' => $this->whenLoaded('stage', function () {
                return $this->stage ? StageResource::make($this->stage) : null;
            })
        ];
    }
}
