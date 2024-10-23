<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\Api\EducationContentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('user', [AuthController::class, 'user']);
        Route::post('logout', [AuthController::class, 'logout']);

        Route::apiResource('education-contents', EducationContentController::class);
    });
});