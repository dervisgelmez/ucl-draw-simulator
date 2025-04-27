<?php

namespace App\Http\Controllers;

use App\Http\Resources\Fixture\FixtureMatchResource;
use App\Models\Fixture;
use App\Supports\Response;
use Illuminate\Http\JsonResponse;

class FixtureMatchesController extends Controller
{
    /**
     * Display active fixture
     */
    public function index(Fixture $fixture): JsonResponse
    {
        $matches = $fixture
            ->matches()
            ->with(['stage', 'homeTeam', 'awayTeam'])
            ->orderBy('match_date')
            ->get();

        return Response::success(
            FixtureMatchResource::collection($matches)
        );
    }
}
