<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Supports\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Team\TeamResource;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $teams = Team::getActiveTeams();

        return Response::success(
            TeamResource::collection($teams)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team): JsonResponse
    {
        $team->load(['stats']);

        return Response::success(
            TeamResource::make($team)
        );
    }
}
