<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/sprints', \App\Http\Controllers\Api\V1\GetSprintListAction::class);

    Route::get('/developers', \App\Http\Controllers\Api\V1\GetDeveloperListAction::class);

    Route::prefix('tasks')->group(function () {
        Route::get('/', \App\Http\Controllers\Api\V1\GetTaskListAction::class);
        Route::get('/stats', \App\Http\Controllers\Api\V1\GetTasksStatsAction::class);
    });
});
