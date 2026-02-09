<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Trip Details
            'pickup_address' => 'required|string',
            'dropoff_address' => 'required|string',
            'pickup_latitude' => 'required|numeric',
            'pickup_longitude' => 'required|numeric',
            'dropoff_latitude' => 'required|numeric',
            'dropoff_longitude' => 'required|numeric',
            'distance_km' => 'required|numeric',
            'base_price' => 'required|numeric',

            // Vehicle
            'vehicle_id' => 'required|exists:vehicles,id',

            // Customer Details
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',

            // Schedule
            'date' => 'required|date',
            'time' => 'required',
            'flight_number' => 'nullable|string|max:50',
            'remarks' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            // 1. Handle Customer
            $customer = null;
            if (Auth::check()) {
                // If logged in, check if user has a customer profile, or find by email
                $user = Auth::user();
                $customer = Customer::where('email', $user->email)->first();

                if (!$customer) {
                    $customer = Customer::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $validated['phone'], // Use phone from form
                    ]);
                }
            } else {
                // Guest: Use provided email
                $customer = Customer::firstOrCreate(
                    ['email' => $validated['email']],
                    [
                        'name' => $validated['name'],
                        'phone' => $validated['phone'],
                    ]
                );
            }

            // 2. Calculate Final Price on Backend (Security)
            $vehicle = Vehicle::findOrFail($validated['vehicle_id']);
            $distanceKm = $validated['distance_km'];

            // Re-calculate base price to prevent tampering
            $serverBasePrice = 0;
            if ($distanceKm <= 60) {
                $serverBasePrice = $distanceKm * 2.50;
            } else {
                $serverBasePrice = (60 * 2.50) + (($distanceKm - 60) * 1.20);
            }

            $finalPrice = $serverBasePrice * $vehicle->price_multiplier;

            // 3. Create Order
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
                // We'll store flight/remarks in a metadata column if available, 
                // or add them to the migration if needed. For now let's assume standard fields.
                // If Order model doesn't have remarks, we might skip it or add column.
                // Checking previous Order model view... it didn't have remarks.
                // Let's add remarks and flight_number to schema later if needed.
            ]);

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
