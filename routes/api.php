<?php

use App\Http\Controllers\Api\StudentController;
use Illuminate\Support\Facades\Route;

Route::name('api.')
    ->middleware('throttle:60,1')
    ->group(function () {
        Route::apiResource('students', StudentController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy']);
    });
