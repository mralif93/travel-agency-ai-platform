<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['customer', 'vehicle'])->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = \App\Models\Customer::all();
        $vehicles = \App\Models\Vehicle::where('status', 'active')->get();
        return view('orders.create', compact('customers', 'vehicles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'pickup_address' => 'required|string',
            'pickup_latitude' => 'required|numeric',
            'pickup_longitude' => 'required|numeric',
            'dropoff_address' => 'required|string',
            'dropoff_latitude' => 'required|numeric',
            'dropoff_longitude' => 'required|numeric',
            'distance_km' => 'required|numeric|min:0',
        ]);

        $vehicle = \App\Models\Vehicle::findOrFail($validated['vehicle_id']);

        // Calculate Price
        $pricingService = new \App\Services\PricingService();
        $totalPrice = $pricingService->calculatePrice($validated['distance_km'], $vehicle->price_multiplier);

        Order::create([
            'customer_id' => $validated['customer_id'],
            'vehicle_id' => $validated['vehicle_id'],
            'pickup_address' => $validated['pickup_address'],
            'pickup_latitude' => $validated['pickup_latitude'],
            'pickup_longitude' => $validated['pickup_longitude'],
            'dropoff_address' => $validated['dropoff_address'],
            'dropoff_latitude' => $validated['dropoff_latitude'],
            'dropoff_longitude' => $validated['dropoff_longitude'],
            'distance_km' => $validated['distance_km'],
            'vehicle_multiplier' => $vehicle->price_multiplier,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'scheduled_at' => now(), // Default to now for MVP
        ]);

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['customer', 'vehicle']);
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $customers = \App\Models\Customer::all();
        $vehicles = \App\Models\Vehicle::where('status', 'active')->get();
        return view('orders.edit', compact('order', 'customers', 'vehicles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'pickup_address' => 'required|string',
            'pickup_latitude' => 'required|numeric',
            'pickup_longitude' => 'required|numeric',
            'dropoff_address' => 'required|string',
            'dropoff_latitude' => 'required|numeric',
            'dropoff_longitude' => 'required|numeric',
            'distance_km' => 'required|numeric|min:0',
        ]);

        $vehicle = \App\Models\Vehicle::findOrFail($validated['vehicle_id']);

        // Calculate Price
        $pricingService = new \App\Services\PricingService();
        $totalPrice = $pricingService->calculatePrice($validated['distance_km'], $vehicle->price_multiplier);

        $order->update([
            'customer_id' => $validated['customer_id'],
            'vehicle_id' => $validated['vehicle_id'],
            'pickup_address' => $validated['pickup_address'],
            'pickup_latitude' => $validated['pickup_latitude'],
            'pickup_longitude' => $validated['pickup_longitude'],
            'dropoff_address' => $validated['dropoff_address'],
            'dropoff_latitude' => $validated['dropoff_latitude'],
            'dropoff_longitude' => $validated['dropoff_longitude'],
            'distance_km' => $validated['distance_km'],
            'vehicle_multiplier' => $vehicle->price_multiplier,
            'total_price' => $totalPrice,
        ]);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
