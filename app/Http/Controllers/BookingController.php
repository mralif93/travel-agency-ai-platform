<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Vehicle;
use App\Services\NotificationService;
use App\Services\PricingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BookingController extends Controller
{
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
            'base_price' => 'required|numeric',
            'vehicle_id' => 'required|exists:vehicles,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'date' => 'required|date',
            'time' => 'required',
            'flight_number' => 'nullable|string|max:50',
            'remarks' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $customer = null;
            if (Auth::guard('customer')->check()) {
                $customer = Auth::guard('customer')->user();
            } elseif (Auth::check()) {
                $user = Auth::user();
                $customer = Customer::where('email', $user->email)->first();
                if (!$customer) {
                    $customer = Customer::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $validated['phone'],
                        'password' => Hash::make('P@ssw0rd123'),
                    ]);
                }
            } else {
                $customer = Customer::firstOrCreate(
                    ['email' => $validated['email']],
                    [
                        'name' => $validated['name'],
                        'phone' => $validated['phone'],
                        'password' => Hash::make('P@ssw0rd123'),
                    ]
                );
            }

            $vehicle = Vehicle::findOrFail($validated['vehicle_id']);
            $distanceKm = $validated['distance_km'];

            $finalPrice = $pricing->calculatePrice($distanceKm, $vehicle->price_multiplier);

            $scheduledAt = Carbon::parse($validated['date'] . ' ' . $validated['time']);

            $order = Order::create([
                'customer_id' => $customer->id,
                'vehicle_id' => $vehicle->id,
                'pickup_address' => $validated['pickup_address'],
                'pickup_latitude' => $validated['pickup_latitude'],
                'pickup_longitude' => $validated['pickup_longitude'],
                'dropoff_address' => $validated['dropoff_address'],
                'dropoff_latitude' => $validated['dropoff_latitude'],
                'dropoff_longitude' => $validated['dropoff_longitude'],
                'distance_km' => $distanceKm,
                'vehicle_multiplier' => $vehicle->price_multiplier,
                'total_price' => $finalPrice,
                'status' => 'pending',
                'scheduled_at' => $scheduledAt,
                'flight_number' => $validated['flight_number'] ?? null,
                'remarks' => $validated['remarks'] ?? null,
            ]);

            $order->load(['customer', 'vehicle.driver']);

            $notifications->sendBookingConfirmation($order);

            if ($order->vehicle && $order->vehicle->driver) {
                $notifications->sendDriverAssignment($order);
            }

            DB::commit();

            return redirect()->route('booking.confirmation', $order->id)->with('success', 'Booking submitted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Booking failed: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $order = Order::with(['vehicle', 'customer'])->findOrFail($id);

        // Generate QR Code content (e.g., URL to track order)
        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate(route('booking.confirmation', $order->id));

        return view('public.booking.confirmation', compact('order', 'qrCode'));
    }

    public function downloadInvoice($id)
    {
        $order = Order::with(['vehicle', 'customer'])->findOrFail($id);

        // Generate QR for PDF
        $qrCode = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(100)->generate(route('booking.confirmation', $order->id)));

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.invoice', compact('order', 'qrCode'));

        return $pdf->stream('invoice-' . $order->id . '.pdf');
    }
}
