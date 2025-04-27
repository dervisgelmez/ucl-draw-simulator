<?php

namespace App\Http\Resources;

use App\Enums\StageEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $enum = StageEnum::tryFrom($this->name);

        return [
            'name' => $this->name,
            'label' => $enum->label(),
            'isKnockout' => $enum->isKnockout(),
            'isFinal' => $enum->isFinal()
        ];
    }
}
