<?php

namespace App\Http\Requests;

use App\Enums\SimulateStrategiesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SimulateRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'strategy' => $this->route('strategy')
        ]);
    }

    public function rules(): array
    {
        return [
            'strategy' => [
                'required',
                Rule::enum(SimulateStrategiesEnum::class)
            ],
        ];
    }

    public function getStrategy(): string
    {
        return $this->validated('strategy');
    }
}
