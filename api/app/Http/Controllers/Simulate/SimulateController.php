<?php

namespace App\Http\Controllers\Simulate;

use App\Models\Fixture;
use App\Supports\Response;
use App\Enums\ResponseStatusEnum;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Simulate\SimulateService;

class SimulateController extends Controller
{
    /**
     * Simulate all fixture
     */
    public function fixture(Fixture $fixture, SimulateService $simulateService): JsonResponse
    {
        $simulateService->fixture($fixture);

        return Response::success(
            status: ResponseStatusEnum::NO_CONTENT
        );
    }

    /**
     * Simulate current week
     */
    public function week(Fixture $fixture, SimulateService $simulateService): JsonResponse
    {
        $simulateService->week($fixture);

        return Response::success(
            status: ResponseStatusEnum::NO_CONTENT
        );
    }
}
