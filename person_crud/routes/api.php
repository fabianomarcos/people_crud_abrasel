<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;

Route::apiResource('people', PersonController::class)->only(['index', 'store', 'show', "update", 'destroy']);
