<?php

namespace App\Http\Controllers\Simulate;

use App\Models\Fixture;
use App\Supports\Response;
use App\Enums\ResponseStatusEnum;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\SimulateRequest;

class SimulateController extends Controller
{
    public function simulate(SimulateRequest $request, Fixture $fixture): JsonResponse
    {
        $request->strategy()->handle($fixture);

        return Response::success(
            status: ResponseStatusEnum::NO_CONTENT
        );
    }
}
