<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function company()
    {
        $companyId = Auth::user()->company_id;

        // Active Trips: Orders with status 'active' linked to this company's drivers
        $activeTrips = Order::where('status', 'active')
            ->whereHas('vehicle.driver', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            })
            ->count();

        // Total Spend (This Month): Sum of total_price for completed orders this month
        $totalSpend = Order::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->whereHas('vehicle.driver', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            })
            ->sum('total_price');

        // Pending Approvals: For now we can mock this or use 'pending' status if you have an approval flow
        // Assuming 'pending' status orders are awaiting approval/assignment
        $pendingApprovals = Order::where('status', 'pending')
            ->whereHas('vehicle.driver', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            })
            ->count();


        // Recent Trips: Fetch recent 5 orders
        $recentTrips = Order::with(['vehicle.driver', 'customer'])
            ->whereHas('vehicle.driver', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            })
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.company', compact('activeTrips', 'totalSpend', 'pendingApprovals', 'recentTrips'));
    }

    public function driver()
    {
        $user = Auth::user();

        // Ensure user is driver
        if ($user->role !== 'driver') {
            abort(403);
        }

        // Dashboard Stats
        $todayEarnings = 0; // In a real app, sum invoices or order prices for today
        // Simple calculation: Sum of completed orders assigned to this driver updated today
        // Note: Driver is linked via Vehicle. We need to find vehicles where user_id = user->id
        $driverVehicleIds = \App\Models\Vehicle::where('user_id', $user->id)->pluck('id');

        $todayEarnings = Order::whereIn('vehicle_id', $driverVehicleIds)
            ->where('status', 'completed')
            ->whereDate('updated_at', today())
            ->sum('total_price');

        $tripsCompleted = Order::whereIn('vehicle_id', $driverVehicleIds)
            ->where('status', 'completed')
            ->count();

        $totalOrders = Order::whereIn('vehicle_id', $driverVehicleIds)->count();

        // Rating: Mocked for now, or add rating column to users/orders later
        $rating = 4.9;

        // Schedule / Trips
        // Fetch Today's assignments, Active trips, and Pending (New)
        $todaysTrips = Order::with(['customer'])
            ->whereIn('vehicle_id', $driverVehicleIds)
            ->whereIn('status', ['pending', 'scheduled', 'active', 'completed'])
            ->whereDate('created_at', '>=', today()->subDays(1)) // Show recent
            ->orderByRaw("CASE status 
                WHEN 'active' THEN 1 
                WHEN 'scheduled' THEN 2 
                WHEN 'pending' THEN 3 
                WHEN 'completed' THEN 4 
                ELSE 5 END")
            ->orderBy('scheduled_at', 'asc')
            ->get();

        $vehicle = \App\Models\Vehicle::where('user_id', $user->id)->first();

        return view('dashboard.driver', compact('todayEarnings', 'tripsCompleted', 'totalOrders', 'rating', 'todaysTrips', 'vehicle'));
    }
    public function customer()
    {
        $user = Auth::guard('customer')->user();

        // Dashboard Stats
        $pendingOrders = Order::where('customer_id', $user->id)->where('status', 'pending')->count();
        $completedOrders = Order::where('customer_id', $user->id)->where('status', 'completed')->count();
        $totalSpent = Order::where('customer_id', $user->id)->where('status', 'completed')->sum('total_price');

        // Recent Orders
        $orders = Order::where('customer_id', $user->id)
            ->with(['vehicle', 'invoice'])
            ->latest()
            ->paginate(10);

        return view('dashboard.customer', compact('user', 'pendingOrders', 'completedOrders', 'totalSpent', 'orders'));
    }

    public function trips()
    {
        $user = Auth::guard('customer')->user();

        $trips = Order::where('customer_id', $user->id)
            ->with(['vehicle', 'invoice'])
            ->latest()
            ->paginate(10);

        return view('dashboard.trips', compact('user', 'trips'));
    }

    public function showTrip(Order $order)
    {
        $user = Auth::guard('customer')->user();

        // Ensure the order belongs to the authenticated customer
        if ($order->customer_id !== $user->id) {
            abort(403);
        }

        $order->load(['vehicle.driver', 'invoice']);

        return view('dashboard.trip-details', compact('user', 'order'));
    }

    public function printTrip(Order $order)
    {
        $user = Auth::guard('customer')->user();

        if ($order->customer_id !== $user->id) {
            abort(403);
        }

        $order->load(['vehicle.driver', 'invoice']);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.trip', compact('order', 'user'));

        return $pdf->stream('trip-details-' . $order->id . '.pdf');
    }
}
