<?php

namespace App\Http\Controllers\Fixture;

use App\Http\Controllers\Controller;
use App\Http\Resources\Fixture\FixtureGroupResource;
use App\Models\Fixture;
use App\Supports\Response;
use Illuminate\Http\JsonResponse;

class FixtureGroupController extends Controller
{
    /**
     * Display active fixture
     */
    public function index(Fixture $fixture): JsonResponse
    {
        $groups = $fixture
            ->groups()
            ->with(['teams'])
            ->get();

        return Response::success(
            FixtureGroupResource::collection($groups)
        );
    }
}
