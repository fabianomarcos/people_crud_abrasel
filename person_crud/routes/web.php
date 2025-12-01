<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;

Route::get('/', function () {
    return view('welcome');
});

Route::apiResource('people', PersonController::class)->only(['index', 'store', 'show', 'destroy']);
