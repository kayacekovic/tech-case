<?php

use Illuminate\Support\Facades\Route;

Route::get('/todos', \App\Http\Controllers\Api\V1\GetTaskListAction::class);
