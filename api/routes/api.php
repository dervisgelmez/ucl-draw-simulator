<?php

use App\Http\Controllers\FixtureController;
use App\Http\Controllers\FixtureGroupController;
use App\Http\Controllers\FixtureMatchesController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/teams', TeamController::class)->only(['index', 'show']);
Route::apiResource('/fixtures', FixtureController::class)->only(['index', 'store', 'destroy']);

Route::prefix('/fixtures/{fixture}')->group(function () {
    Route::get('/groups', [FixtureGroupController::class, 'index'])->name('fixtures.groups.list');
    Route::get('/matches', [FixtureMatchesController::class, 'index'])->name('fixtures.groups.list');
});
