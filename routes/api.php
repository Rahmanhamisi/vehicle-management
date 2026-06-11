<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\AuthController;

// PUBLIC ROUTES
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// PROTECTED ROUTES
Route::middleware('auth:sanctum')->group(function () {

    // logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // current user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // update user
    Route::put('/user', function (Request $request) {
        $user = $request->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return response()->json($user);
    });

    // stats
    Route::get('/stats', function () {
        return [
            'drivers' => \App\Models\Driver::count(),
            'vehicles' => \App\Models\Vehicle::count(),
        ];
    });

    // drivers
    Route::apiResource('drivers', DriverController::class);

    // vehicles
    Route::apiResource('vehicles', VehicleController::class);

    // assign driver
    Route::post('/vehicles/{vehicle}/assign-driver', [VehicleController::class, 'assignDriver']);
});