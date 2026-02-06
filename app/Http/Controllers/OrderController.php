<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'vehicle'])->latest();

        // Scope for Company Admin
        if (auth()->user()->role === 'company') {
            $query->whereHas('vehicle.driver', function ($q) {
                $q->where('company_id', auth()->user()->company_id);
            });
        }

        // Scope for Driver
        if (auth()->user()->role === 'driver') {
            $query->whereHas('vehicle', function ($q) {
                $q->where('user_id', auth()->id());
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(10);
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role === 'driver') {
            abort(403);
        }

        $customers = \App\Models\Customer::all();
        $vehicles = \App\Models\Vehicle::where('status', 'active')->get();
        return view('orders.create', compact('customers', 'vehicles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->role === 'driver') {
            abort(403);
        }
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
        if (auth()->user()->role === 'driver') {
            abort(403);
        }

        $customers = \App\Models\Customer::all();
        $vehicles = \App\Models\Vehicle::where('status', 'active')->get();
        return view('orders.edit', compact('order', 'customers', 'vehicles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        if (auth()->user()->role === 'driver') {
            abort(403);
        }
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
        if (auth()->user()->role === 'driver') {
            abort(403);
        }
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
    public function verify(Request $request, Order $order)
    {
        if ($order->vehicle->driver_id !== $request->user()->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized driver'], 403);
        }

        // Allow starting the trip if it's pending or scheduled
        if (in_array($order->status, ['pending', 'scheduled'])) {
            $order->update(['status' => 'active']); // 'active' means in_progress/started
            return response()->json(['success' => true, 'message' => 'Trip started!', 'status' => 'active']);

        } elseif ($order->status === 'active') {
            $order->update(['status' => 'completed']);

            // Auto-generate Invoice
            $driver = $order->vehicle->driver;
            // Check if driver belongs to a company (B2B invoice) or is independent/platform
            // For now, we assume current requirement is: invoice for every trip.

            \App\Models\Invoice::create([
                'order_id' => $order->id,
                'company_id' => $driver->company_id ?? null, // Nullable if driver has no company? Or assume company exists.
                // If company_id is required by schema, this might fail for independent drivers. 
                // Assuming for this project scope, all drivers belong to a company as per earlier context.
                'issue_date' => now(),
                'due_date' => now(), // Immediate due
                'description' => "Trip #TR-" . substr($order->id, 0, 8) . " - " . $order->pickup_address . " to " . $order->dropoff_address,
                'amount' => $order->total_price,
                'status' => 'paid',
            ]);

            return response()->json(['success' => true, 'message' => 'Trip completed & Invoice generated!', 'status' => 'completed']);
        }

        return response()->json(['success' => false, 'message' => 'Invalid order status'], 400);
    }
}
