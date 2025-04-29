<?php

namespace App\Http\Controllers\Fixture;

use App\Http\Controllers\Controller;
use App\Http\Resources\Fixture\FixtureMatchResource;
use App\Models\Fixture;
use App\Models\FixtureMatch;
use App\Supports\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FixtureMatchesController extends Controller
{
    /**
     * Display active fixture
     */
    public function index(Fixture $fixture, Request $request): JsonResponse
    {
        $matches = FixtureMatch::findByStage(
            $fixture,
            $request->query->get('stage')
        );

        return Response::success(
            FixtureMatchResource::collection($matches)
        );
    }

    public function show(FixtureMatch $match): JsonResponse
    {
        $match->load([
            'stage',
            'homeTeam',
            'awayTeam',
            'logs' => function ($query) {
                $query->orderBy('minute');
            },
        ]);

        return Response::success(
            FixtureMatchResource::make($match)
        );
    }
}
