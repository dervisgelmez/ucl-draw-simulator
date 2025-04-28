<?php

namespace App\Http\Requests;

use App\Enums\SimulateStrategiesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SimulateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'stage' => [
                'required',
                Rule::in(SimulateStrategiesEnum::values())
            ],
        ];
    }

    public function getStrategy(): SimulateStrategiesEnum
    {
        return SimulateStrategiesEnum::from($this->route('stage'));
    }
}
