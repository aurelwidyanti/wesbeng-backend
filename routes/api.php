<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\Api\EducationContentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\API\ScheduleController;

Route::prefix('v1')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('user', [AuthController::class, 'user']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::apiResource('locations', LocationController::class);
        Route::apiResource('schedules', ScheduleController::class);
    });
    Route::apiResource('education-contents', EducationContentController::class);
});