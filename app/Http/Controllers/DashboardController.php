<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function superadmin()
    {
        $totalUsers = User::count();
        $totalCustomers = Customer::count();
        $newSignups24h = User::where('created_at', '>=', now()->subDay())->count() +
                         Customer::where('created_at', '>=', now()->subDay())->count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_price');

        $recentActivity = Order::with(['customer', 'vehicle.driver'])
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($order) {
                $action = match($order->status) {
                    'pending' => 'New booking created',
                    'active' => 'Trip in progress',
                    'completed' => 'Completed trip',
                    'cancelled' => 'Cancelled booking',
                    default => 'Order updated',
                };
                return (object)[
                    'id' => $order->id,
                    'user' => $order->customer?->name ?? 'Guest',
                    'action' => $action,
                    'time' => $order->updated_at->diffForHumans(),
                    'order' => $order,
                ];
            });

        return view('dashboard.superadmin', compact(
            'totalUsers',
            'totalCustomers',
            'newSignups24h',
            'totalOrders',
            'totalRevenue',
            'recentActivity'
        ));
    }

    public function admin()
    {
        $totalBookings = Order::count();
        $revenueToday = Order::where('status', 'completed')
            ->whereDate('updated_at', today())
            ->sum('total_price');
        $totalDrivers = User::where('role', 'driver')->count();
        $activeDrivers = Vehicle::where('status', 'available')
            ->whereHas('driver', fn($q) => $q->where('role', 'driver'))
            ->count();
        $pendingReview = Order::where('status', 'pending')->count();

        $recentBookings = Order::with(['customer', 'vehicle'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.admin', compact(
            'totalBookings',
            'revenueToday',
            'totalDrivers',
            'activeDrivers',
            'pendingReview',
            'recentBookings'
        ));
    }
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

        $rating = $user->rating ?? 5.0;

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

    public function trips(Request $request)
    {
        $user = Auth::guard('customer')->user();

        $query = Order::where('customer_id', $user->id)
            ->with(['vehicle', 'invoice']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $trips = $query->orderBy('scheduled_at', 'desc')
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

        $order->load(['vehicle.driver', 'invoice', 'customer']);

        // Generate QR for PDF (Same as BookingController)
        $qrCode = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(100)->generate(route('booking.confirmation', $order->id)));

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.invoice', compact('order', 'qrCode'));

        return $pdf->stream('trip-details-' . $order->id . '.pdf');
    }
}
