<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('tasks')->group(function () {
        Route::get('/', \App\Http\Controllers\Api\V1\GetTaskListAction::class);
        Route::get('/stats', \App\Http\Controllers\Api\V1\GetTasksStatsAction::class);
    });
});
