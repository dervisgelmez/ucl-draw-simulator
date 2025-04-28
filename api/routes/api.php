<?php

use App\Enums\StageEnum;
use App\Http\Controllers\Fixture\FixtureController;
use App\Http\Controllers\Fixture\FixtureGroupController;
use App\Http\Controllers\Fixture\FixtureMatchesController;
use App\Http\Controllers\Simulate\SimulateController;
use App\Http\Controllers\Team\TeamController;
use App\Models\Fixture;
use Illuminate\Support\Facades\Route;

Route::apiResource('/teams', TeamController::class)->only(['index', 'show']);
Route::apiResource('/fixtures', FixtureController::class)->only(['index', 'store', 'destroy']);

Route::prefix('/fixtures/{fixture}')->group(function () {

    Route::get('/groups', [FixtureGroupController::class, 'index'])
        ->name('fixtures.groups.list');

    Route::get('/matches', [FixtureMatchesController::class, 'index'])
        ->name('fixtures.groups.list');

    Route::post('/simulate/{strategy}', [SimulateController::class, 'simulate'])
        ->name('fixtures.simulate');
});


Route::get('/test', function () {
    StageEnum::SEMI_FINAL->service()->generate(
        Fixture::findOneByActive()
    );
});
