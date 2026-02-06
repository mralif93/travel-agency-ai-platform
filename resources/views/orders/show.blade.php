<x-app-layout>
    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <div class="max-w-5xl mx-auto space-y-8">
        <!-- Form Section -->
        <div class="bg-white dark:bg-gray-800 shadow-lg ring-1 ring-gray-900/5 sm:rounded-2xl">
            <!-- Header -->
            <div
                class="border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 px-6 py-4 rounded-t-2xl flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i class='bx bx-file text-primary-600 bg-primary-50 dark:bg-primary-900/30 p-1.5 rounded-lg'></i>
                    Order #{{ substr($order->id, 0, 8) }} Details
                </h2>
                <span
                    class="px-2.5 py-1 text-xs font-semibold rounded-full bg-yellow-50 text-yellow-700 border border-yellow-200 uppercase tracking-wide">
                    {{ ucfirst($order->status) }}
                </span>
            </div>

            <div class="px-6 py-8">
                <div class="space-y-10">
                    <!-- Section 1: Trip Route (Top) -->
                    <div class="relative z-20">
                        <h3
                            class="text-sm font-bold uppercase tracking-wider text-gray-500 mb-6 flex items-center gap-2">
                            <i class='bx bx-map-alt text-lg'></i>
                            <span>Navigation Details</span>
                            <span
                                class="ml-auto text-[10px] font-normal normal-case text-gray-400 bg-gray-100 dark:bg-gray-800 px-2 py-0.5 rounded-full">Powered
                                by OpenStreetMap</span>
                        </h3>

                        <div class="flex flex-col">
                            <!-- Pickup Row -->
                            <div class="flex gap-4">
                                <div class="flex flex-col items-center w-8 shrink-0 relative">
                                    <div
                                        class="w-4 h-4 rounded-full bg-blue-600 ring-4 ring-blue-50 dark:ring-blue-900/20 z-10 mt-[0.5rem]">
                                    </div>
                                    <div class="w-0.5 bg-gray-200 dark:bg-gray-700 absolute top-[1.5rem] bottom-0">
                                    </div>
                                </div>

                                <div class="grow pb-8">
                                    <label
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Pickup
                                        Location</label>
                                    <div class="text-gray-900 dark:text-white text-base">{{ $order->pickup_address }}
                                    </div>
                                </div>
                            </div>

                            <!-- Dropoff Row -->
                            <div class="flex gap-4">
                                <div class="flex flex-col items-center w-8 shrink-0 relative">
                                    <div class="w-0.5 bg-gray-200 dark:bg-gray-700 absolute top-0 h-[0.5rem]"></div>
                                    <div
                                        class="w-4 h-4 rounded-full bg-red-600 ring-4 ring-red-50 dark:ring-red-900/20 z-10 mt-[0.5rem]">
                                    </div>
                                </div>

                                <div class="grow">
                                    <label
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Dropoff
                                        Location</label>
                                    <div class="text-gray-900 dark:text-white text-base">{{ $order->dropoff_address }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Map Section -->
                    <div id="map_container"
                        class="rounded-xl overflow-hidden shadow-lg border border-gray-100 dark:border-gray-700">
                        <div id="map" class="h-80 w-full z-0"></div>
                    </div>

                    <!-- Section 2: Verification (QR) -->
                    <div
                        class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-6 border border-gray-100 dark:border-gray-700 flex flex-col items-center justify-center text-center">
                        <h3
                            class="text-sm font-bold uppercase tracking-wider text-gray-500 mb-4 flex items-center gap-2">
                            <i class='bx bx-qr-scan text-lg'></i> Verification Code
                        </h3>
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                            <!-- Generate QR Code on the fly -->
                            <!-- Size 150px, Color Black -->
                            {!! QrCode::size(150)->generate($order->id) !!}
                        </div>
                        <p class="text-xs text-gray-400 mt-4">Show this code to your driver to start the trip.</p>
                    </div>

                    <!-- Section 3: Assignment (Middle) -->
                    <div>
                        <h3
                            class="text-sm font-bold uppercase tracking-wider text-gray-500 mb-6 flex items-center gap-2">
                            <i class='bx bx-user-pin text-lg'></i> Assignment
                        </h3>

                        <div
                            class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 dark:bg-gray-900/50 rounded-xl p-6 border border-gray-100 dark:border-gray-700">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Customer</label>
                                <div class="font-medium text-gray-900 dark:text-white text-lg">
                                    {{ $order->customer->name }}
                                </div>
                                <div class="text-sm text-gray-500">{{ $order->customer->phone }}</div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Vehicle</label>
                                <div class="font-medium text-gray-900 dark:text-white text-lg">
                                    {{ $order->vehicle->make }} {{ $order->vehicle->model }}
                                </div>
                                <div class="text-sm text-gray-500">{{ $order->vehicle->license_plate }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Summary (Bottom) -->
                    <div
                        class="rounded-xl bg-gray-50 dark:bg-gray-800/50 p-8 border border-gray-100 dark:border-gray-700 relative overflow-hidden z-0">
                        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                            <div>
                                <div
                                    class="text-gray-500 dark:text-gray-400 text-sm font-bold uppercase tracking-wider mb-1">
                                    Total Distance</div>
                                <div class="text-3xl font-mono font-bold text-gray-900 dark:text-white">
                                    {{ number_format($order->distance_km, 2) }} km
                                </div>
                                <div class="text-xs text-gray-400 mt-2">Calculated via OSRM</div>
                            </div>

                            <div class="hidden md:block w-px h-16 bg-gray-200 dark:bg-gray-700"></div>
                            <div class="md:hidden w-full h-px bg-gray-200 dark:bg-gray-700"></div>

                            <div class="text-right">
                                <div
                                    class="text-primary-600 dark:text-primary-400 text-sm font-bold uppercase tracking-wider mb-1">
                                    Total Fare</div>
                                <div class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white">RM
                                    {{ number_format($order->total_price, 2) }}
                                </div>
                                <div class="text-xs text-gray-400 mt-2">Includes base fare & distance multiplier</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div
                    class="mt-8 flex items-center justify-end gap-3 pt-6 border-t border-gray-100 dark:border-gray-700">
                    <a href="{{ route('orders.index') }}"
                        class="px-5 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">Back
                        to List</a>

                    @if(auth()->user()->role !== 'driver')
                        <a href="{{ route('orders.edit', $order->id) }}"
                            class="px-6 py-2.5 rounded-lg bg-black dark:bg-white text-white dark:text-black font-semibold shadow-sm hover:opacity-90 transition-opacity flex items-center gap-2">
                            <i class='bx bx-edit text-lg'></i>
                            <span>Edit Order</span>
                        </a>
                    @endif

                    @if($order->invoice)
                        <a href="{{ route('invoices.show', $order->invoice->id) }}"
                            class="px-6 py-2.5 rounded-lg bg-green-600 text-white font-semibold shadow-sm hover:opacity-90 transition-opacity flex items-center gap-2">
                            <i class='bx bx-receipt text-lg'></i>
                            <span>View Invoice</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize Map with saved coordinates
            const map = L.map('map').setView([{{ $order->pickup_latitude }}, {{ $order->pickup_longitude }}], 13);
            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; OpenStreetMap contributors &copy; CARTO'
            }).addTo(map);

            // Add Markers
            const blueIcon = L.divIcon({ className: 'bg-transparent', html: `<div class="w-4 h-4 rounded-full bg-blue-600 ring-4 ring-white shadow-lg"></div>` });
            const redIcon = L.divIcon({ className: 'bg-transparent', html: `<div class="w-4 h-4 rounded-full bg-red-600 ring-4 ring-white shadow-lg"></div>` });

            L.marker([{{ $order->pickup_latitude }}, {{ $order->pickup_longitude }}], { icon: blueIcon }).addTo(map);
            L.marker([{{ $order->dropoff_latitude }}, {{ $order->dropoff_longitude }}], { icon: redIcon }).addTo(map);

            // Draw Route (Simple Line for View - Full route needs API call or stored geometry, using flyTo/fitBounds for now)
            const group = new L.featureGroup([
                L.marker([{{ $order->pickup_latitude }}, {{ $order->pickup_longitude }}]),
                L.marker([{{ $order->dropoff_latitude }}, {{ $order->dropoff_longitude }}])
            ]);
            map.fitBounds(group.getBounds(), { padding: [50, 50] });

            // To properly draw the route we'd need to re-fetch from OSRM or store the geometry. 
            // For MVP View, we can just fetch it again quickly.
            fetch(`https://router.project-osrm.org/route/v1/driving/{{ $order->pickup_longitude }},{{ $order->pickup_latitude }};{{ $order->dropoff_longitude }},{{ $order->dropoff_latitude }}?overview=full&geometries=geojson`)
                .then(res => res.json())
                .then(data => {
                    if (data.routes && data.routes.length > 0) {
                        L.geoJSON(data.routes[0].geometry, {
                            style: { color: '#3b82f6', weight: 5, opacity: 0.7 }
                        }).addTo(map);
                    }
                });
        });
    </script>
</x-app-layout>