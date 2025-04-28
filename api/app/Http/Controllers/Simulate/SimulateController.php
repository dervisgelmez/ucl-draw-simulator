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
    public function simulate(Fixture $fixture, SimulateRequest $request, SimulateService $simulateService): JsonResponse
    {
        $simulateService->simulate($fixture, $request->getStrategy());

        return Response::success(
            status: ResponseStatusEnum::NO_CONTENT
        );
    }
}
