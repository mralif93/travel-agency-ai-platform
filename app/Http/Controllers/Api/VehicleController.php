<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $vehicles = Vehicle::with(['driver'])
            ->where('status', '!=', 'maintenance')
            ->when($request->type, fn($q, $type) => $q->where('type', $type))
            ->when($request->status, fn($q, $status) => $q->where('status', $status))
            ->get()
            ->map(fn($v) => [
                'id' => $v->id,
                'type' => $v->type,
                'make' => $v->make,
                'model' => $v->model,
                'year' => $v->year,
                'license_plate' => $v->license_plate,
                'capacity' => $v->capacity,
                'price_multiplier' => $v->price_multiplier,
                'status' => $v->status,
                'driver_name' => $v->driver?->name,
            ]);

        return response()->json([
            'vehicles' => $vehicles,
        ]);
    }

    public function show(Vehicle $vehicle)
    {
        return response()->json([
            'vehicle' => [
                'id' => $vehicle->id,
                'type' => $vehicle->type,
                'make' => $vehicle->make,
                'model' => $vehicle->model,
                'year' => $vehicle->year,
                'license_plate' => $vehicle->license_plate,
                'capacity' => $vehicle->capacity,
                'price_multiplier' => $vehicle->price_multiplier,
                'status' => $vehicle->status,
                'driver' => $vehicle->driver ? [
                    'name' => $vehicle->driver->name,
                    'rating' => $vehicle->driver->rating,
                ] : null,
            ],
        ]);
    }
}
