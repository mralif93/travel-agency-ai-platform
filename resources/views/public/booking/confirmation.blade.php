<x-public-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">

            <!-- Success Header -->
            <div class="text-center mb-12 animate-fade-in-up">
                <div
                    class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-green-100 dark:bg-green-900/30 mb-6 shadow-sm">
                    <i class='bx bx-check text-5xl text-green-600 dark:text-green-400'></i>
                </div>
                <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white tracking-tight mb-4">
                    Booking Confirmed
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Thank you, <span
                        class="font-bold text-gray-900 dark:text-white">{{ $order->customer->name }}</span>!
                    Your ride is scheduled. A confirmation email has been sent to {{ $order->customer->email }}.
                </p>
            </div>

            <!-- Main Ticket Card -->
            <div
                class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden print:shadow-none print:border print:border-gray-200">
                <!-- Top Status Bar -->
                <div
                    class="bg-black dark:bg-gray-950 text-white px-8 py-4 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="flex items-center gap-3">
                        <div
                            class="px-3 py-1 bg-green-500 rounded-full text-xs font-bold uppercase tracking-wider text-black">
                            {{ $order->status }}
                        </div>
                        <span class="font-mono text-gray-300">#{{ strtoupper(substr($order->id, 0, 8)) }}</span>
                    </div>
                    <div class="text-sm font-medium text-gray-300">
                        Booked on {{ $order->created_at->format('d M Y, h:i A') }}
                    </div>
                </div>

                <div class="flex flex-col lg:flex-row">
                    <!-- Left: Trip Details -->
                    <div class="flex-1 p-8 md:p-10 border-r border-gray-100 dark:border-gray-700 relative">
                        <!-- Header -->
                        <div class="flex items-start justify-between mb-10">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">Trip Itinerary</h2>
                                <p class="text-gray-500 text-sm">Review your travel details below.</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700 p-2 rounded-lg">
                                <i class='bx bxs-map-alt text-2xl text-gray-400'></i>
                            </div>
                        </div>

                        <!-- Route Visual -->
                        <div class="space-y-10 relative pl-4">
                            <!-- Connecting Line -->
                            <div
                                class="absolute left-[27px] top-3 bottom-8 w-0.5 bg-gradient-to-b from-black via-gray-300 to-black dark:from-white dark:via-gray-600 dark:to-white">
                            </div>

                            <!-- Pickup -->
                            <div class="relative flex gap-6 group">
                                <div
                                    class="relative z-10 w-6 h-6 rounded-full bg-black dark:bg-white shadow-[0_0_0_4px_white] dark:shadow-[0_0_0_4px_rgba(31,41,55,1)] flex items-center justify-center shrink-0">
                                    <div class="w-2 h-2 bg-white dark:bg-black rounded-full"></div>
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Pickup
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white leading-tight mb-1">
                                        {{ $order->pickup_address }}
                                    </h3>
                                    <div
                                        class="inline-flex items-center gap-2 text-sm text-gray-500 bg-gray-50 dark:bg-gray-700/50 px-3 py-1 rounded-lg">
                                        <i class='bx bx-time'></i>
                                        {{ $order->scheduled_at->format('d M Y, h:i A') }}
                                    </div>
                                    @if($order->flight_number)
                                        <div
                                            class="mt-2 text-sm text-indigo-600 dark:text-indigo-400 font-medium flex items-center gap-1">
                                            <i class='bx bxs-plane-alt'></i> Flight: {{ $order->flight_number }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Dropoff -->
                            <div class="relative flex gap-6 group">
                                <div
                                    class="relative z-10 w-6 h-6 rounded-sm bg-black dark:bg-white shadow-[0_0_0_4px_white] dark:shadow-[0_0_0_4px_rgba(31,41,55,1)] flex items-center justify-center shrink-0">
                                    <div class="w-2 h-2 bg-white dark:bg-black rounded-sm"></div>
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Dropoff
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white leading-tight">
                                        {{ $order->dropoff_address }}
                                    </h3>
                                    <div class="mt-2 text-sm text-gray-500">
                                        Distance: {{ number_format($order->distance_km, 1) }} km
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Vehicle Card Mini -->
                        <div
                            class="mt-12 bg-gray-50 dark:bg-gray-700/30 rounded-2xl p-6 flex flex-col sm:flex-row items-center gap-6 border border-gray-100 dark:border-gray-700">
                            <i class='bx bxs-car text-5xl text-gray-300 dark:text-gray-600'></i>
                            <div class="text-center sm:text-left">
                                <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Selected
                                    Vehicle</div>
                                <div class="font-bold text-xl text-gray-900 dark:text-white">{{ $order->vehicle->make }}
                                    {{ $order->vehicle->model }}
                                </div>
                                <div class="text-sm text-gray-500">{{ $order->vehicle->type }} &bull;
                                    {{ $order->vehicle->capacity }} Pax &bull;
                                    {{ max(1, floor($order->vehicle->capacity / 2)) }} Bags
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Invoice & QR -->
                    <div class="w-full lg:w-96 bg-gray-50 dark:bg-gray-800/50 p-8 md:p-10 flex flex-col">
                        <div class="mb-8 text-center">
                            <div
                                class="bg-white p-4 rounded-2xl shadow-sm inline-block mx-auto mb-4 border border-gray-100">
                                {!! $qrCode !!}
                            </div>
                            <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Scan to view order</p>
                        </div>

                        <div class="flex-1">
                            <h3
                                class="text-sm font-bold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3 mb-4">
                                Payment Summary</h3>

                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                    <span>Base Rate</span>
                                    <span>Included</span>
                                </div>
                                <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                    <span>Distance Charge ({{ number_format($order->distance_km, 1) }} km)</span>
                                    <span>Included</span>
                                </div>
                                <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                    <span>Vehicle Multiplier</span>
                                    <span>x{{ $order->vehicle_multiplier }}</span>
                                </div>
                            </div>

                            <div class="border-t-2 border-dashed border-gray-200 dark:border-gray-700 my-6"></div>

                            <div class="flex justify-between items-end">
                                <div class="text-sm font-medium text-gray-500">Total Paid</div>
                                <div class="text-3xl font-black text-gray-900 dark:text-white">RM
                                    {{ number_format($order->total_price, 2) }}
                                </div>
                            </div>

                            <div class="mt-2 text-right text-xs text-gray-400">
                                Includes all taxes and fees
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 print:hidden">
                            <a href="{{ route('booking.invoice', $order->id) }}" target="_blank"
                                class="w-full py-4 bg-black dark:bg-white text-white dark:text-black rounded-xl font-bold hover:scale-[1.02] transition-transform shadow-lg flex items-center justify-center gap-2 mb-3">
                                <i class='bx bx-file'></i> View Invoice (PDF)
                            </a>
                            <a href="{{ route('transport-rates') }}"
                                class="w-full py-4 bg-white dark:bg-gray-700 text-gray-900 dark:text-white border border-gray-200 dark:border-gray-600 rounded-xl font-bold hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors flex items-center justify-center gap-2">
                                Book Another
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Note -->
            <div class="text-center mt-12 text-gray-400 text-sm print:hidden">
                Need help? <a href="#" class="text-gray-900 dark:text-white underline font-medium">Contact Support</a>
                or call +60 12-345 6789
            </div>

        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .max-w-4xl,
            .max-w-4xl * {
                visibility: visible;
            }

            .max-w-4xl {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .print\:hidden {
                display: none !important;
            }

            .print\:shadow-none {
                box-shadow: none !important;
            }

            .print\:border {
                border: 1px solid #e5e7eb !important;
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</x-public-layout>