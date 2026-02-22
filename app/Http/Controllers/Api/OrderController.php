<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Vehicle;
use App\Services\NotificationService;
use App\Services\PricingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $orders = Order::where('customer_id', $customer->id)
            ->with(['vehicle'])
            ->when($request->status, fn($q, $status) => $q->where('status', $status))
            ->latest()
            ->paginate($request->per_page ?? 15);

        return response()->json($orders);
    }

    public function store(Request $request, PricingService $pricing, NotificationService $notifications)
    {
        $validated = $request->validate([
            'pickup_address' => 'required|string',
            'dropoff_address' => 'required|string',
            'pickup_latitude' => 'required|numeric',
            'pickup_longitude' => 'required|numeric',
            'dropoff_latitude' => 'required|numeric',
            'dropoff_longitude' => 'required|numeric',
            'distance_km' => 'required|numeric',
            'vehicle_id' => 'required|exists:vehicles,id',
            'scheduled_at' => 'required|date|after:now',
            'flight_number' => 'nullable|string|max:50',
            'remarks' => 'nullable|string|max:500',
        ]);

        $customer = Auth::guard('customer')->user();
        $vehicle = Vehicle::findOrFail($validated['vehicle_id']);

        $totalPrice = $pricing->calculatePrice(
            $validated['distance_km'],
            $vehicle->price_multiplier
        );

        $order = Order::create([
            'customer_id' => $customer->id,
            'vehicle_id' => $vehicle->id,
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
            'scheduled_at' => Carbon::parse($validated['scheduled_at']),
            'flight_number' => $validated['flight_number'] ?? null,
            'remarks' => $validated['remarks'] ?? null,
        ]);

        $order->load(['customer', 'vehicle.driver']);

        $notifications->sendBookingConfirmation($order);

        if ($order->vehicle && $order->vehicle->driver) {
            $notifications->sendDriverAssignment($order);
        }

        return response()->json([
            'message' => 'Booking created successfully',
            'order' => $order,
        ], 201);
    }

    public function show(Order $order)
    {
        $customer = Auth::guard('customer')->user();

        if ($order->customer_id !== $customer->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json([
            'order' => $order->load(['vehicle.driver', 'customer']),
        ]);
    }

    public function invoice(Order $order)
    {
        $customer = Auth::guard('customer')->user();

        if ($order->customer_id !== $customer->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $qrCode = base64_encode(
            \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(100)
                ->generate(route('booking.confirmation', $order->id))
        );

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.invoice', compact('order', 'qrCode'));

        return $pdf->download('invoice-' . $order->id . '.pdf');
    }

    public function calculatePrice(Request $request, PricingService $pricing)
    {
        $validated = $request->validate([
            'distance_km' => 'required|numeric|min:0',
            'vehicle_id' => 'sometimes|exists:vehicles,id',
            'vehicle_multiplier' => 'sometimes|numeric|min:0.5|max:5',
        ]);

        $multiplier = $validated['vehicle_multiplier'] ?? 1.0;

        if (isset($validated['vehicle_id'])) {
            $vehicle = Vehicle::find($validated['vehicle_id']);
            $multiplier = $vehicle->price_multiplier;
        }

        $price = $pricing->calculatePrice($validated['distance_km'], $multiplier);

        return response()->json([
            'distance_km' => $validated['distance_km'],
            'vehicle_multiplier' => $multiplier,
            'total_price' => $price,
            'currency' => 'MYR',
        ]);
    }

    public function adminIndex(Request $request)
    {
        $orders = Order::with(['customer', 'vehicle.driver'])
            ->when($request->status, fn($q, $status) => $q->where('status', $status))
            ->when($request->search, function ($q, $search) {
                $q->whereHas('customer', fn($q) => $q->where('name', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate($request->per_page ?? 15);

        return response()->json($orders);
    }

    public function updateStatus(Request $request, Order $order, NotificationService $notifications)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,active,completed,cancelled',
        ]);

        $previousStatus = $order->status;
        $order->update(['status' => $validated['status']]);

        $order->load(['customer', 'vehicle.driver']);
        $notifications->sendOrderStatusUpdate($order, $previousStatus);

        return response()->json([
            'message' => 'Order status updated',
            'order' => $order,
        ]);
    }

    public function driverOrders(Request $request)
    {
        $user = Auth::user();
        $vehicleIds = Vehicle::where('user_id', $user->id)->pluck('id');

        $orders = Order::whereIn('vehicle_id', $vehicleIds)
            ->with(['customer'])
            ->when($request->status, fn($q, $status) => $q->where('status', $status))
            ->orderByRaw("CASE status 
                WHEN 'active' THEN 1 
                WHEN 'pending' THEN 2 
                WHEN 'confirmed' THEN 3 
                ELSE 4 END")
            ->latest()
            ->paginate($request->per_page ?? 15);

        return response()->json($orders);
    }

    public function complete(Order $order, NotificationService $notifications)
    {
        $user = Auth::user();
        $vehicleIds = Vehicle::where('user_id', $user->id)->pluck('id');

        if (!in_array($order->vehicle_id, $vehicleIds->toArray())) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $previousStatus = $order->status;
        $order->update(['status' => 'completed']);

        $order->load(['customer', 'vehicle.driver']);
        $notifications->sendOrderStatusUpdate($order, $previousStatus);

        return response()->json([
            'message' => 'Order marked as completed',
            'order' => $order,
        ]);
    }
}
