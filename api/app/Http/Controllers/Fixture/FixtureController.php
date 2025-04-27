<?php

namespace App\Http\Controllers\Fixture;

use App\Enums\ResponseStatusEnum;
use App\Http\Controllers\Controller;
use App\Services\Fixture\FixtureService;
use App\Supports\Response;
use Illuminate\Http\JsonResponse;

class FixtureController extends Controller
{
    /**
     * Display active fixture
     */
    public function index(FixtureService $fixtureService): JsonResponse
    {
        $fixture = $fixtureService->getActiveFixture();

        return Response::success($fixture);
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Throwable
     */
    public function store(FixtureService $fixtureService): JsonResponse
    {
        $fixtureService->generate();

        return Response::success(
            status: ResponseStatusEnum::CREATED
        );
    }

    /**
     * Destroy active fixture
     */
    public function destroy(FixtureService $fixtureService): JsonResponse
    {
        $fixtureService->getActiveFixture()->delete();

        return Response::success(
            status: ResponseStatusEnum::NO_CONTENT
        );
    }
}
