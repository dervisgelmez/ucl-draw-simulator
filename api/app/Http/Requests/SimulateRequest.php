<?php

namespace App\Http\Requests;

use App\Enums\Simulate\SimulateStrategiesEnum;
use App\Services\Simulate\AbstractSimulateStrategy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SimulateRequest extends FormRequest
{
    protected array $strategies = [];

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

    public function strategy(): AbstractSimulateStrategy
    {
        $enum = SimulateStrategiesEnum::tryFrom(
            $this->validated('strategy')
        );

        return app($enum->strategy());
    }
}
