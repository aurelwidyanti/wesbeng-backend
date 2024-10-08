<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// prefix v1 and middleware sanctum
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
});