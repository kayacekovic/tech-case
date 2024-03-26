<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/tasks', \App\Http\Controllers\Api\V1\GetTaskListAction::class);
});
