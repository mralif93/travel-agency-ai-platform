<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Vehicle::with('driver')->latest();

        // Redirect Driver to their own vehicle
        if (auth()->check() && auth()->user()->role === 'driver') {
            $myVehicle = Vehicle::where('user_id', auth()->id())->first();
            if ($myVehicle) {
                return redirect()->route('vehicles.show', $myVehicle);
            }
            // If no vehicle assigned, show empty list or special view. 
            // For now, let query filter for empty result.
            $query->where('user_id', auth()->id());
        }

        if (auth()->check() && auth()->user()->role === 'company') {
            $query->whereHas('driver', function ($q) {
                $q->where('company_id', auth()->user()->company_id);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('make', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('license_plate', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $vehicles = $query->paginate(10);
        return view('vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $drivers = User::where('role', 'driver')->get();
        return view('vehicles.create', compact('drivers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|string|max:4',
            'license_plate' => 'required|string|max:20|unique:vehicles',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:active,maintenance,inactive',
            'user_id' => 'nullable|exists:users,id',
        ]);

        Vehicle::create($validated);

        return redirect()->route('vehicles.index')->with('success', 'Vehicle created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        // Authorization for Driver
        if (auth()->user()->role === 'driver' && $vehicle->user_id !== auth()->id()) {
            abort(403);
        }

        $vehicle->load('driver');
        return view('vehicles.show', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        // Authorization for Driver
        if (auth()->user()->role === 'driver' && $vehicle->user_id !== auth()->id()) {
            abort(403);
        }

        $drivers = User::where('role', 'driver')->get();
        return view('vehicles.edit', compact('vehicle', 'drivers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        // Authorization for Driver
        if (auth()->user()->role === 'driver' && $vehicle->user_id !== auth()->id()) {
            abort(403);
        }

        $isDriver = auth()->user()->role === 'driver';

        $rules = [
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|string|max:4',
            'license_plate' => ['required', 'string', 'max:20', Rule::unique('vehicles')->ignore($vehicle->id)],
            'capacity' => 'required|integer|min:1',
        ];

        // Only allow status/driver updates if NOT a driver
        if (!$isDriver) {
            $rules['status'] = 'required|in:active,maintenance,inactive';
            $rules['user_id'] = 'nullable|exists:users,id';
        }

        $validated = $request->validate($rules);

        // If driver, we don't update status or user_id, so filter them out just in case
        if ($isDriver) {
            // ensure these are not in validated array or manually exclude
            // validate() returns only validated fields.
            // Since we didn't validate status/user_id for driver, they are not in $validated.
            // However, Update expects all fields? No, specific fields.
        }

        $vehicle->update($validated);

        return redirect()->route('vehicles.index')->with('success', 'Vehicle updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('vehicles.index')->with('success', 'Vehicle deleted successfully.');
    }
}
