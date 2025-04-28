<?php

namespace App\Http\Controllers\Simulate;

use App\Http\Requests\SimulateRequest;
use App\Models\Fixture;
use App\Supports\Response;
use App\Enums\ResponseStatusEnum;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Simulate\SimulateService;

class SimulateController extends Controller
{
    public function simulate(SimulateRequest $request, Fixture $fixture, SimulateService $simulateService): JsonResponse
    {
        $simulateService->simulate($fixture, $request);

        return Response::success(
            status: ResponseStatusEnum::NO_CONTENT
        );
    }
}
