<x-customer-layout>
    <div class="space-y-8">
        <!-- Header & Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <nav class="flex items-center gap-x-3 text-sm text-gray-500 dark:text-gray-400 mb-2">
                    <a href="{{ route('customer.trips') }}"
                        class="hover:text-gray-900 dark:hover:text-white transition-colors">My Trips</a>
                    <i class='bx bx-chevron-right text-gray-400'></i>
                    <span class="font-medium text-gray-900 dark:text-gray-200">Order
                        #{{ substr($order->id, 0, 8) }}</span>
                </nav>
                <div class="flex items-center gap-x-3">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Trip Details</h1>
                    @php
                        $statusColors = [
                            'pending' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400 border-amber-200 dark:border-amber-700',
                            'active' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 border-blue-200 dark:border-blue-700',
                            'completed' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400 border-emerald-200 dark:border-emerald-700',
                            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 border-red-200 dark:border-red-700',
                        ];
                        $statusClass = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                    @endphp
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $statusClass }} uppercase tracking-wide">
                        {{ $order->status }}
                    </span>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button
                    onclick="window.open('{{ route('customer.trips.print', $order) }}', '_blank', 'width=800,height=600')"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl text-sm font-semibold text-gray-700 dark:text-gray-200 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all">
                    <i class='bx bx-printer text-lg'></i>
                    <span>Print Ticket</span>
                </button>
                @if($order->invoice)
                    <a href="#"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 border border-transparent rounded-xl text-sm font-semibold text-white shadow-sm hover:bg-primary-500 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-600 transition-all">
                        <i class='bx bxs-file-pdf text-lg'></i>
                        <span>Invoice</span>
                    </a>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Route & Driver -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Route Card -->
                <div
                    class="relative overflow-hidden bg-white dark:bg-gray-800 rounded-3xl shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700">
                    <div class="p-6 sm:p-8">
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex items-center gap-2 text-gray-900 dark:text-white">
                                <i class='bx bxs-map-alt text-xl text-primary-500'></i>
                                <h2 class="text-lg font-bold">Itinerary</h2>
                            </div>
                        </div>

                        <div class="relative mt-2">
                            <!-- Connecting Line -->
                            <div
                                class="absolute top-1/2 left-4 right-4 sm:left-10 sm:right-10 h-0.5 bg-gray-100 dark:bg-gray-700 -translate-y-1/2 z-0 hidden sm:block">
                            </div>

                            <div
                                class="flex flex-col sm:flex-row items-center justify-between gap-6 sm:gap-0 relative z-10 text-center sm:text-left">
                                <!-- Pickup Node -->
                                <div class="w-full sm:w-auto flex flex-row sm:flex-col items-center sm:gap-4 gap-4">
                                    <!-- Mobile Label & Icon Wrapper -->
                                    <div class="flex flex-col items-center gap-2 mx-auto sm:mx-0">
                                        <span
                                            class="text-xs font-bold text-gray-400 uppercase tracking-wider hidden sm:block">PICKUP</span>
                                        <div
                                            class="h-12 w-12 rounded-full bg-white dark:bg-gray-800 border-4 border-green-50 dark:border-green-900/20 shadow-sm flex items-center justify-center relative z-10">
                                            <div
                                                class="h-8 w-8 rounded-full bg-green-50 dark:bg-green-900/30 flex items-center justify-center border border-green-200 dark:border-green-800 text-green-600 dark:text-green-400">
                                                <i class='bx bxs-map text-lg'></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Mobile Address (Inline) -->
                                    <div class="text-left sm:hidden flex-1">
                                        <span
                                            class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">PICKUP</span>
                                        <p class="text-base font-bold text-gray-900 dark:text-white leading-tight">
                                            {{ $order->pickup_location }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $order->pickup_address }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Center Arrow -->
                                <div
                                    class="hidden sm:flex flex-none items-center justify-center bg-white dark:bg-gray-800 px-3 z-10">
                                    <div
                                        class="h-8 w-8 rounded-full bg-gray-50 dark:bg-gray-700/50 flex items-center justify-center text-gray-300 dark:text-gray-600">
                                        <i class='bx bxs-right-arrow text-sm'></i>
                                    </div>
                                </div>

                                <!-- Dropoff Node -->
                                <div
                                    class="w-full sm:w-auto flex flex-row sm:flex-col items-center sm:gap-4 gap-4 text-right">
                                    <!-- Mobile Address (Inline, Order First for visual) -->
                                    <div class="text-right sm:hidden flex-1">
                                        <span
                                            class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">DROPOFF</span>
                                        <p class="text-base font-bold text-gray-900 dark:text-white leading-tight">
                                            {{ $order->dropoff_location }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $order->dropoff_address }}
                                        </p>
                                    </div>

                                    <!-- Mobile Label & Icon Wrapper -->
                                    <div class="flex flex-col items-center gap-2 mx-auto sm:mx-0">
                                        <span
                                            class="text-xs font-bold text-gray-400 uppercase tracking-wider hidden sm:block">DROPOFF</span>
                                        <div
                                            class="h-12 w-12 rounded-full bg-white dark:bg-gray-800 border-4 border-red-50 dark:border-red-900/20 shadow-sm flex items-center justify-center relative z-10">
                                            <div
                                                class="h-8 w-8 rounded-full bg-red-50 dark:bg-red-900/30 flex items-center justify-center border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400">
                                                <i class='bx bxs-flag-alt text-lg'></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Desktop Addresses Row -->
                            <div class="hidden sm:flex justify-between items-start mt-4 pt-2">
                                <div class="text-left max-w-xs">
                                    <p class="text-lg font-bold text-gray-900 dark:text-white leading-tight">
                                        {{ $order->pickup_location }}
                                    </p>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $order->pickup_address }}
                                    </p>
                                </div>
                                <div class="text-right max-w-xs">
                                    <p class="text-lg font-bold text-gray-900 dark:text-white leading-tight">
                                        {{ $order->dropoff_location }}
                                    </p>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $order->dropoff_address }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Schedule Info -->
                        <div
                            class="mt-8 pt-8 border-t border-gray-100 dark:border-gray-700/50 grid grid-cols-1 sm:grid-cols-3 gap-8">
                            <div class="flex items-start gap-3">
                                <div
                                    class="h-10 w-10 flex items-center justify-center rounded-lg bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400">
                                    <i class='bx bx-calendar text-xl'></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Date</p>
                                    <p class="mt-0.5 text-base font-semibold text-gray-900 dark:text-white">
                                        {{ $order->scheduled_at ? $order->scheduled_at->format('D, M d, Y') : 'ASAP' }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div
                                    class="h-10 w-10 flex items-center justify-center rounded-lg bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400">
                                    <i class='bx bx-time-five text-xl'></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Time</p>
                                    <p class="mt-0.5 text-base font-semibold text-gray-900 dark:text-white">
                                        {{ $order->scheduled_at ? $order->scheduled_at->format('h:i A') : 'ASAP' }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div
                                    class="h-10 w-10 flex items-center justify-center rounded-lg bg-pink-50 dark:bg-pink-900/20 text-pink-600 dark:text-pink-400">
                                    <i class='bx bx-map-alt text-xl'></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Distance</p>
                                    <p class="mt-0.5 text-base font-semibold text-gray-900 dark:text-white">
                                        {{ $order->distance_km }} km
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Driver Card -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700 overflow-hidden">
                    <div class="p-6 sm:p-8">
                        <div class="flex items-center gap-2 mb-6 text-gray-900 dark:text-white">
                            <i class='bx bxs-car-garage text-xl text-primary-500'></i>
                            <h2 class="text-lg font-bold">Driver & Vehicle Details</h2>
                        </div>

                        @if($order->vehicle && $order->vehicle->driver)
                            <div class="flex flex-col">
                                <!-- Driver Section -->
                                <div class="flex flex-col gap-4 pb-8 border-b border-gray-100 dark:border-gray-700">
                                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Driver Details</h3>
                                    <div class="flex items-center gap-4">
                                        <div class="relative">
                                            <div
                                                class="h-16 w-16 rounded-2xl bg-gray-100 dark:bg-gray-700 overflow-hidden ring-4 ring-white dark:ring-gray-800 shadow-md">
                                                @if($order->vehicle->driver->profile_photo_url)
                                                    <img src="{{ $order->vehicle->driver->profile_photo_url }}"
                                                        alt="{{ $order->vehicle->driver->name }}"
                                                        class="h-full w-full object-cover">
                                                @else
                                                    <div
                                                        class="h-full w-full flex items-center justify-center text-gray-400 text-2xl font-bold">
                                                        {{ substr($order->vehicle->driver->name, 0, 1) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div
                                                class="absolute -bottom-2 -right-2 bg-yellow-400 text-yellow-900 text-[10px] font-bold px-1.5 py-0.5 rounded-full ring-2 ring-white dark:ring-gray-800 shadow-sm flex items-center gap-0.5">
                                                <i class='bx bxs-star text-xs'></i>
                                                {{ number_format($order->vehicle->driver->rating ?? 5.0, 1) }}
                                            </div>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                                {{ $order->vehicle->driver->name }}
                                            </h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Professional Driver</p>
                                            <div class="mt-2 flex flex-wrap gap-2">
                                                @if($order->vehicle->driver->email_verified_at)
                                                    <span
                                                        class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-green-50 dark:bg-green-900/20 text-[10px] font-bold text-green-700 dark:text-green-400 border border-green-100 dark:border-green-800 uppercase tracking-wide">
                                                        Verified
                                                    </span>
                                                @endif
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-blue-50 dark:bg-blue-900/20 text-[10px] font-bold text-blue-700 dark:text-blue-400 border border-blue-100 dark:border-blue-800 uppercase tracking-wide">
                                                    {{ $order->vehicle->orders()->where('status', 'completed')->count() }}
                                                    Trips
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Vehicle Section -->
                                <div class="flex flex-col gap-4 pt-8">
                                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Vehicle Details
                                    </h3>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div
                                            class="p-3 bg-gray-50 dark:bg-gray-700/20 rounded-xl border border-gray-100 dark:border-gray-700/50">
                                            <p
                                                class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-medium">
                                                Model</p>
                                            <p class="mt-1 font-bold text-gray-900 dark:text-white truncate">
                                                {{ $order->vehicle->model }}
                                            </p>
                                        </div>
                                        <div
                                            class="p-3 bg-gray-50 dark:bg-gray-700/20 rounded-xl border border-gray-100 dark:border-gray-700/50">
                                            <p
                                                class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-medium">
                                                License Plate</p>
                                            <p class="mt-1 font-bold text-gray-900 dark:text-white font-mono">
                                                {{ $order->vehicle->license_plate }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div
                                class="text-center py-8 px-4 rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                                <div
                                    class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-gray-100 dark:bg-gray-700 mb-3">
                                    <i class='bx bx-loader-alt animate-spin text-gray-400 text-xl'></i>
                                </div>
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Finding your driver...</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">We'll notify you as soon as a
                                    driver accepts your trip.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column: QR & Payment -->
            <div class="space-y-6">
                <!-- QR Code Card -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700 p-6 text-center">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Driver Scan</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 px-4">Show this QR code to the driver upon
                        pickup.</p>

                    <div
                        class="inline-block p-4 bg-white rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.1)] border border-gray-100 mx-auto">
                        {!! QrCode::size(160)->gradient(79, 70, 229, 67, 56, 202, 'diagonal')->generate($order->id) !!}
                    </div>
                </div>

                <!-- Payment Summary -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700 p-6">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Payment Summary</h2>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Base Fare</span>
                            <span
                                class="font-medium text-gray-900 dark:text-white">RM{{ number_format($order->base_price ?? $order->total_price * 0.8, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Service Tax</span>
                            <span
                                class="font-medium text-gray-900 dark:text-white">RM{{ number_format($order->tax ?? $order->total_price * 0.2, 2) }}</span>
                        </div>
                        @if(isset($order->service_fee))
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Platform Fee</span>
                                <span
                                    class="font-medium text-gray-900 dark:text-white">RM{{ number_format($order->service_fee, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Processing Fee</span>
                            <span class="font-medium text-gray-900 dark:text-white">RM0.00</span>
                        </div>
                    </div>

                    <div
                        class="mt-6 pt-4 border-t border-dashed border-gray-200 dark:border-gray-700 flex justify-between items-end">
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total Amount</span>
                        <span
                            class="text-2xl font-bold text-gray-900 dark:text-white">RM{{ number_format($order->total_price, 2) }}</span>
                    </div>

                    <div class="mt-6">
                        @php
                            $statusClasses = [
                                'pending' => 'bg-amber-50 text-amber-700 border-amber-100 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800',
                                'paid' => 'bg-emerald-50 text-emerald-700 border-emerald-100 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800',
                                'unpaid' => 'bg-red-50 text-red-700 border-red-100 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800',
                            ];
                            $status = $order->payment_status ?? 'unpaid';
                            $statusClass = $statusClasses[$status] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                        @endphp
                        <div
                            class="w-full py-3 px-4 rounded-xl text-center text-sm font-bold border {{ $statusClass }} flex items-center justify-center gap-2">
                            @if($status === 'paid')
                                <i class='bx bxs-check-circle text-lg'></i>
                            @elseif($status === 'unpaid')
                                <i class='bx bxs-error-circle text-lg'></i>
                            @else
                                <i class='bx bxs-time-five text-lg'></i>
                            @endif
                            {{ ucfirst($status) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-customer-layout>