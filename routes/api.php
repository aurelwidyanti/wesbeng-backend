<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\Api\EducationContentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LocationController;
use App\Http\Controllers\API\ScheduleController;
use App\Http\Controllers\API\TransactionController;

Route::prefix('v1')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('user', [AuthController::class, 'user']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::apiResource('locations', LocationController::class);
        Route::apiResource('schedules', ScheduleController::class);

        Route::get('transaction-history', [TransactionController::class, 'transactionHistory']);
        Route::post('request-cashout', [TransactionController::class, 'requestCashout']);
    });
    Route::apiResource('education-contents', EducationContentController::class);
});