<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    // List all vehicles with driver
    public function index()
    {
        return Vehicle::with('driver')->get();
    }

    // Show single vehicle with driver
    public function show($id)
    {
        return Vehicle::with('driver')->findOrFail($id);
    }

    // Create a vehicle
    public function store(Request $request)
    {
        $request->validate([
            'plate_number' => 'required|string|max:20|unique:vehicles,plate_number',
            'model' => 'required|string|max:255',
            'driver_id' => 'nullable|exists:drivers,id',
        ]);

        $vehicle = Vehicle::create($request->only(['plate_number', 'model', 'driver_id']));
        return response()->json($vehicle);
    }

    // Update a vehicle
    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $request->validate([
            'plate_number' => 'sometimes|string|max:20|unique:vehicles,plate_number,' . $vehicle->id,
            'model' => 'sometimes|string|max:255',
            'driver_id' => 'nullable|exists:drivers,id',
        ]);

        $vehicle->update($request->only(['plate_number', 'model', 'driver_id']));
        return response()->json($vehicle);
    }

    // Delete a vehicle
    public function destroy($id)
    {
        Vehicle::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }

    // 🔥 Assign / Change Driver
    public function assignDriver(Request $request, $id)
    {
        $request->validate([
            'driver_id' => 'nullable|exists:drivers,id',
        ]);

        $vehicle = Vehicle::findOrFail($id);
        $vehicle->driver_id = $request->driver_id;
        $vehicle->save();

        return response()->json(['message' => 'Driver assigned']);
    }
}