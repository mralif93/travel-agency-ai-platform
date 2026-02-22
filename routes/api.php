<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\ProfileController;

Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:customer')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/profile', [ProfileController::class, 'show']);
        Route::put('/profile', [ProfileController::class, 'update']);

        Route::get('/orders', [OrderController::class, 'index']);
        Route::post('/orders', [OrderController::class, 'store']);
        Route::get('/orders/{order}', [OrderController::class, 'show']);
        Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice']);
    });

    Route::middleware('auth')->group(function () {
        Route::post('/admin/logout', [AuthController::class, 'adminLogout']);

        Route::get('/admin/orders', [OrderController::class, 'adminIndex']);
        Route::patch('/admin/orders/{order}/status', [OrderController::class, 'updateStatus']);

        Route::get('/driver/orders', [OrderController::class, 'driverOrders']);
        Route::patch('/driver/orders/{order}/complete', [OrderController::class, 'complete']);
    });

    Route::get('/vehicles', [VehicleController::class, 'index']);
    Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show']);

    Route::post('/calculate-price', [OrderController::class, 'calculatePrice']);
});
