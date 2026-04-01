<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    // List all drivers
    public function index()
    {
        return Driver::with('vehicles')->get();
    }

    // Show single driver
    public function show($id)
    {
        return Driver::with('vehicles')->findOrFail($id);
    }

    // Create a driver
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'license_number' => 'required|string|unique:drivers,license_number',
            'phone' => 'required|string|max:20',
        ]);

        $driver = Driver::create($request->only(['name', 'license_number', 'phone']));
        return response()->json($driver);
    }

    // Update a driver
    public function update(Request $request, $id)
    {
        $driver = Driver::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'license_number' => 'sometimes|string|unique:drivers,license_number,' . $driver->id,
            'phone' => 'sometimes|string|max:20',
        ]);

        $driver->update($request->only(['name', 'license_number', 'phone']));
        return response()->json($driver);
    }

    // Delete a driver
    public function destroy($id)
    {
        Driver::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}