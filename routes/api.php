<?php

use App\Http\Controllers\Api\V1\BookingController;
use App\Http\Controllers\Api\V1\CourtController;
use App\Http\Controllers\Api\V1\CourtScheduleController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/logout', [UserController::class, 'logout']);
        Route::apiResource('/schedules', CourtScheduleController::class)->only('index');
        Route::apiResource('/bookings', BookingController::class)->only(['index','store','show','destroy']);

        Route::middleware(['admin'])->group(function () {
            Route::apiResource('/courts', CourtController::class)->only(['index','store','update','destroy']);
            Route::apiResource('/schedules', CourtScheduleController::class)->only('index','store','update','destroy');
        });
    });
});
