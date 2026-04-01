<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\AuthController;

// ✅ Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ✅ Protected routes
Route::middleware('auth:sanctum')->group(function () {

    // Current user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // ✅ Logout (ONLY ONE)
    Route::post('/logout', [AuthController::class, 'logout']);

    // 🔹 Drivers CRUD
    Route::get('/drivers', [DriverController::class, 'index']);
    Route::get('/drivers/{id}', [DriverController::class, 'show']);
    Route::post('/drivers', [DriverController::class, 'store']);
    Route::put('/drivers/{id}', [DriverController::class, 'update']);
    Route::delete('/drivers/{id}', [DriverController::class, 'destroy']);

    // 🔹 Vehicles CRUD
    Route::get('/vehicles', [VehicleController::class, 'index']);
    Route::get('/vehicles/{id}', [VehicleController::class, 'show']);
    Route::post('/vehicles', [VehicleController::class, 'store']);
    Route::put('/vehicles/{id}', [VehicleController::class, 'update']);
    Route::delete('/vehicles/{id}', [VehicleController::class, 'destroy']);

    // 🔹 Assign driver
    Route::post('/vehicles/{id}/assign-driver', [VehicleController::class, 'assignDriver']);
});