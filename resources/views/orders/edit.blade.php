<x-app-layout>
    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Custom Styles for Trip Connector -->
    <style>
        .trip-connector {
            position: absolute;
            left: 2rem;
            top: 3.5rem;
            bottom: 3.5rem;
            width: 2px;
            background: repeating-linear-gradient(to bottom, #cbd5e1 0, #cbd5e1 6px, transparent 6px, transparent 12px);
            z-index: 0;
        }

        /* Dark mode adjustment */
        @media (prefers-color-scheme: dark) {
            .trip-connector {
                background: repeating-linear-gradient(to bottom, #475569 0, #475569 6px, transparent 6px, transparent 12px);
            }
        }
    </style>

    <div class="max-w-5xl mx-auto space-y-8">
        <!-- Form Section -->
        <div class="bg-white dark:bg-gray-800 shadow-lg ring-1 ring-gray-900/5 sm:rounded-2xl">
            <!-- Header -->
            <div
                class="border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 px-6 py-4 rounded-t-2xl">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i class='bx bx-edit text-primary-600 bg-primary-50 dark:bg-primary-900/30 p-1.5 rounded-lg'></i>
                    Edit Order #{{ substr($order->id, 0, 8) }}
                </h2>
            </div>

            <div class="px-6 py-8">
                <form action="{{ route('orders.update', $order->id) }}" method="POST" id="order_form">
                    @csrf
                    @method('PUT')

                    <!-- Error Handling -->
                    @if ($errors->any())
                        <div
                            class="mb-6 rounded-lg bg-red-50 dark:bg-red-900/30 p-4 text-sm text-red-800 dark:text-red-200">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Hidden Lat/Lng Inputs -->
                    <input type="hidden" id="pickup_latitude" name="pickup_latitude"
                        value="{{ old('pickup_latitude', $order->pickup_latitude) }}">
                    <input type="hidden" id="pickup_longitude" name="pickup_longitude"
                        value="{{ old('pickup_longitude', $order->pickup_longitude) }}">
                    <input type="hidden" id="dropoff_latitude" name="dropoff_latitude"
                        value="{{ old('dropoff_latitude', $order->dropoff_latitude) }}">
                    <input type="hidden" id="dropoff_longitude" name="dropoff_longitude"
                        value="{{ old('dropoff_longitude', $order->dropoff_longitude) }}">
                    <input type="hidden" id="distance_km" name="distance_km"
                        value="{{ old('distance_km', $order->distance_km) }}">

                    <div class="space-y-10">
                        <!-- Section 1: Trip Route (Top) -->
                        <div class="relative z-20"> <!-- Increased z-index for dropdowns -->
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
                                    <!-- Timeline Column -->
                                    <div class="flex flex-col items-center w-8 shrink-0 relative">
                                        <!-- Top Icon -->
                                        <div
                                            class="w-4 h-4 rounded-full bg-blue-600 ring-4 ring-blue-50 dark:ring-blue-900/20 z-10 mt-[2.1rem]">
                                        </div>
                                        <!-- Connecting Line -->
                                        <div class="w-0.5 bg-gray-200 dark:bg-gray-700 absolute top-[2.5rem] bottom-0">
                                        </div>
                                    </div>

                                    <!-- Input Column -->
                                    <div class="grow pb-8">
                                        <div class="relative group">
                                            <label
                                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Pickup
                                                Location</label>
                                            <div class="relative">
                                                <input type="text" id="pickup_address" name="pickup_address"
                                                    value="{{ old('pickup_address', $order->pickup_address) }}"
                                                    placeholder="Where are they leaving from?"
                                                    class="block w-full rounded-xl border-gray-200 dark:border-gray-700 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm py-3 px-4 pr-10 dark:bg-gray-900 dark:text-white transition-shadow hover:shadow-md"
                                                    autocomplete="off">

                                                <!-- Clear Button -->
                                                <div id="pickup_clear"
                                                    class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hidden">
                                                    <i class='bx bx-x text-xl'></i>
                                                </div>

                                                <!-- Suggestions Box -->
                                                <div id="pickup_suggestions"
                                                    class="absolute z-50 mt-2 w-full max-h-[350px] overflow-y-auto rounded-xl bg-white dark:bg-gray-800 shadow-xl border border-gray-100 dark:border-gray-700 focus:outline-none hidden scrollbar-hide">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dropoff Row -->
                                <div class="flex gap-4">
                                    <!-- Timeline Column -->
                                    <div class="flex flex-col items-center w-8 shrink-0 relative">
                                        <!-- Connecting Line (from above) -->
                                        <div class="w-0.5 bg-gray-200 dark:bg-gray-700 absolute top-0 h-[2.1rem]"></div>
                                        <!-- Bottom Icon -->
                                        <div
                                            class="w-4 h-4 rounded-full bg-red-600 ring-4 ring-red-50 dark:ring-red-900/20 z-10 mt-[2.1rem]">
                                        </div>
                                    </div>

                                    <!-- Input Column -->
                                    <div class="grow">
                                        <div class="relative group">
                                            <label
                                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Dropoff
                                                Location</label>
                                            <div class="relative">
                                                <input type="text" id="dropoff_address" name="dropoff_address"
                                                    value="{{ old('dropoff_address', $order->dropoff_address) }}"
                                                    placeholder="Where are they going?"
                                                    class="block w-full rounded-xl border-gray-200 dark:border-gray-700 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm py-3 px-4 pr-10 dark:bg-gray-900 dark:text-white transition-shadow hover:shadow-md"
                                                    autocomplete="off">

                                                <!-- Clear Button -->
                                                <div id="dropoff_clear"
                                                    class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hidden">
                                                    <i class='bx bx-x text-xl'></i>
                                                </div>

                                                <!-- Suggestions Box -->
                                                <div id="dropoff_suggestions"
                                                    class="absolute z-50 mt-2 w-full max-h-[350px] overflow-y-auto rounded-xl bg-white dark:bg-gray-800 shadow-xl border border-gray-100 dark:border-gray-700 focus:outline-none hidden scrollbar-hide">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Map Section -->
                        <div id="map_container"
                            class="rounded-xl overflow-hidden shadow-lg border border-gray-100 dark:border-gray-700 hidden">
                            <div id="map" class="h-80 w-full z-0"></div>
                        </div>

                        <!-- Section 2: Assignment (Middle) -->
                        <div class="relative z-10">
                            <h3
                                class="text-sm font-bold uppercase tracking-wider text-gray-500 mb-6 flex items-center gap-2">
                                <i class='bx bx-user-pin text-lg'></i> Assignment
                            </h3>

                            <div
                                class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 dark:bg-gray-900/50 rounded-xl p-6 border border-gray-100 dark:border-gray-700">
                                <!-- Customer Searchable Select -->
                                <div class="relative group">
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Customer</label>
                                    <div class="relative">
                                        <input type="hidden" id="customer_id" name="customer_id"
                                            value="{{ old('customer_id', $order->customer_id) }}">
                                        <input type="text" id="customer_search"
                                            value="{{ $order->customer->name ?? '' }}"
                                            class="block w-full rounded-lg border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 py-3 pl-4 pr-10 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:text-white cursor-pointer"
                                            placeholder="Select or Search Customer..." autocomplete="off">
                                        <div
                                            class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <i class='bx bx-chevron-down text-gray-400 text-xl'></i>
                                        </div>
                                    </div>

                                    <!-- Customer Dropdown -->
                                    <div id="customer_dropdown"
                                        class="absolute z-20 mt-1 w-full max-h-60 overflow-y-auto rounded-xl bg-white dark:bg-gray-800 shadow-lg border border-gray-100 dark:border-gray-700 hidden scrollbar-hide">
                                        @foreach($customers as $customer)
                                            <div class="cursor-pointer px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 last:border-0 transition-colors customer-option"
                                                data-id="{{ $customer->id }}" data-name="{{ $customer->name }}">
                                                <div class="font-medium">{{ $customer->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $customer->phone ?? 'No Phone' }}
                                                </div>
                                            </div>
                                        @endforeach
                                        <div id="no_customer_found"
                                            class="px-4 py-3 text-sm text-gray-500 text-center hidden">No customer found
                                        </div>
                                    </div>
                                </div>

                                <!-- Vehicle Searchable Select -->
                                <div class="relative group">
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Vehicle</label>
                                    <div class="relative">
                                        <input type="hidden" id="vehicle_id" name="vehicle_id"
                                            value="{{ old('vehicle_id', $order->vehicle_id) }}">
                                        <input type="text" id="vehicle_search"
                                            value="{{ $order->vehicle ? $order->vehicle->make . ' ' . $order->vehicle->model : '' }}"
                                            class="block w-full rounded-lg border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 py-3 pl-4 pr-10 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:text-white cursor-pointer"
                                            placeholder="Select or Search Vehicle..." autocomplete="off">
                                        <div
                                            class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <i class='bx bx-chevron-down text-gray-400 text-xl'></i>
                                        </div>
                                    </div>

                                    <!-- Vehicle Dropdown -->
                                    <div id="vehicle_dropdown"
                                        class="absolute z-20 mt-1 w-full max-h-60 overflow-y-auto rounded-xl bg-white dark:bg-gray-800 shadow-lg border border-gray-100 dark:border-gray-700 hidden scrollbar-hide">
                                        @foreach($vehicles as $vehicle)
                                            <div class="cursor-pointer px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 last:border-0 transition-colors vehicle-option"
                                                data-id="{{ $vehicle->id }}"
                                                data-name="{{ $vehicle->make }} {{ $vehicle->model }}">
                                                <div class="font-medium">{{ $vehicle->make }} {{ $vehicle->model }}</div>
                                                <div class="text-xs text-gray-500">{{ $vehicle->license_plate }}</div>
                                            </div>
                                        @endforeach
                                        <div id="no_vehicle_found"
                                            class="px-4 py-3 text-sm text-gray-500 text-center hidden">No vehicle found
                                        </div>
                                    </div>
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
                                    <div class="text-3xl font-mono font-bold text-gray-900 dark:text-white"
                                        id="display_distance">{{ number_format($order->distance_km, 2) }} km</div>
                                    <div class="text-xs text-gray-400 mt-2">Calculated via OSRM</div>
                                </div>

                                <div class="hidden md:block w-px h-16 bg-gray-200 dark:bg-gray-700"></div>
                                <div class="md:hidden w-full h-px bg-gray-200 dark:bg-gray-700"></div>

                                <div class="text-right">
                                    <div
                                        class="text-primary-600 dark:text-primary-400 text-sm font-bold uppercase tracking-wider mb-1">
                                        Estimated Fare</div>
                                    <div class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white"
                                        id="display_price">RM {{ number_format($order->total_price, 2) }}</div>
                                    <div class="text-xs text-gray-400 mt-2">Includes base fare & distance multiplier
                                    </div>
                                </div>
                            </div>

                            <!-- Rate Notes (Collapsible/Info) -->
                            <div
                                class="mt-6 pt-6 flex flex-col sm:flex-row gap-4 text-xs text-gray-500 dark:text-gray-400">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="p-1 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                                        <i class='bx bx-info-circle text-base'></i>
                                    </div>
                                    <span><strong>Base Rate:</strong> RM 2.50 / km (First 60km)</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div
                                        class="p-1 rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400">
                                        <i class='bx bx-trending-down text-base'></i>
                                    </div>
                                    <span><strong>Long Distance:</strong> RM 1.20 / km (> 60km)</span>
                                </div>
                            </div>
                        </div>


                    </div>

                    <!-- Footer -->
                    <div
                        class="mt-8 flex items-center justify-end gap-3 pt-6 border-t border-gray-100 dark:border-gray-700">
                        <a href="{{ route('orders.index') }}"
                            class="px-5 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">Cancel</a>
                        <button type="submit"
                            class="px-6 py-2.5 rounded-lg bg-black dark:bg-white text-white dark:text-black font-semibold shadow-sm hover:opacity-90 transition-opacity flex items-center gap-2">
                            <span>Update Order</span>
                            <i class='bx bx-right-arrow-alt text-xl'></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Custom Search Logic -->
    <script>
        let pickupCoords = { lat: {{ $order->pickup_latitude }}, lng: {{ $order->pickup_longitude }} };
        let dropoffCoords = { lat: {{ $order->dropoff_latitude }}, lng: {{ $order->dropoff_longitude }} };
        let debounceTimer;

        // Searchable Select Logic
        function setupSearchableSelect(inputId, dropdownId, optionClass, noResultId, hiddenInputId) {
            const input = document.getElementById(inputId);
            const dropdown = document.getElementById(dropdownId);
            const hiddenInput = document.getElementById(hiddenInputId);
            const noResult = document.getElementById(noResultId);
            // Scope options to specific dropdown
            const options = dropdown.querySelectorAll('.' + optionClass);

            // Toggle on click
            input.addEventListener('click', (e) => {
                e.stopPropagation();
                // Close others if needed (optional improvement)
                document.querySelectorAll('[id$="_dropdown"]').forEach(d => {
                    if (d !== dropdown) d.classList.add('hidden');
                });

                dropdown.classList.toggle('hidden');
            });

            // Filter options
            input.addEventListener('input', () => {
                const query = input.value.toLowerCase();
                let hasMatch = false;

                options.forEach(option => {
                    const text = option.innerText.toLowerCase(); // Name + Details
                    if (text.includes(query)) {
                        option.classList.remove('hidden');
                        hasMatch = true;
                    } else {
                        option.classList.add('hidden');
                    }
                });

                if (hasMatch) {
                    noResult.classList.add('hidden');
                } else {
                    noResult.classList.remove('hidden');
                }
                dropdown.classList.remove('hidden');
            });

            // Handle selection
            options.forEach(option => {
                option.addEventListener('click', () => {
                    const name = option.getAttribute('data-name');
                    const id = option.getAttribute('data-id');

                    input.value = name;
                    hiddenInput.value = id;
                    dropdown.classList.add('hidden');
                });
            });

            // Close on click outside
            document.addEventListener('click', (e) => {
                if (!input.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        }

        // Initialize Customer and Vehicle Selects
        setupSearchableSelect('customer_search', 'customer_dropdown', 'customer-option', 'no_customer_found', 'customer_id');
        setupSearchableSelect('vehicle_search', 'vehicle_dropdown', 'vehicle-option', 'no_vehicle_found', 'vehicle_id');


        const customLocations = [
            { name: "KLIA 1 - Departure Hall (Door 1)", lat: "2.7533", lon: "101.7010", display_name: "KLIA 1, Departure Hall Level 5, Door 1" },
            { name: "KLIA 1 - Arrival (E-hailing Pickup)", lat: "2.7540", lon: "101.7020", display_name: "KLIA 1, Arrival Level 3, E-hailing Pickup Point" },
            { name: "KLIA 2 - Transportation Hub (Level 1)", lat: "2.7433", lon: "101.6860", display_name: "KLIA 2, Gateway Transportation Hub, Level 1" },
            { name: "KLIA 2 - Departure (Drop-off)", lat: "2.7440", lon: "101.6870", display_name: "KLIA 2, Departure Hall Level 3" },
            { name: "KL Sentral - Main Entrance", lat: "3.1340", lon: "101.6860", display_name: "KL Sentral, Main Entrance, Kuala Lumpur" },
            { name: "Pavilion KL - Main Entrance", lat: "3.1480", lon: "101.7130", display_name: "Pavilion Kuala Lumpur, Main Entrance, Bukit Bintang" },
            { name: "Mid Valley Megamall - North Court", lat: "3.1180", lon: "101.6770", display_name: "Mid Valley Megamall, North Court Entrance" },
            { name: "Suria KLCC - Ampang Mall Entrance", lat: "3.1580", lon: "101.7120", display_name: "Suria KLCC, Ampang Mall Main Entrance" }
        ];

        function performSearch(inputId, suggestionsId, type, query = '') {
            const suggestions = document.getElementById(suggestionsId);
            const input = document.getElementById(inputId);

            suggestions.innerHTML = '';
            let hasResults = false;
            let displayCount = 0;

            // 1. Local Search (Hotspots) - Always show on focus if query empty, OR filter if query exists
            const localMatches = customLocations.filter(loc => {
                if (query.length === 0) return true; // Show all on focus
                return loc.name.toLowerCase().includes(query) || loc.display_name.toLowerCase().includes(query);
            });

            if (localMatches.length > 0) {
                hasResults = true;
                const header = document.createElement('div');
                header.className = 'px-4 py-2 text-xs font-bold text-primary-600 bg-primary-50 dark:bg-primary-900/20 uppercase tracking-wider sticky top-0 backdrop-blur-sm z-10';
                header.textContent = query.length === 0 ? '🔥 Popular Hotspots' : 'Recommended Spots';
                suggestions.appendChild(header);

                localMatches.forEach(place => {
                    const div = document.createElement('div');
                    div.className = 'cursor-pointer px-5 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-gray-100 border-b border-gray-100 dark:border-gray-700 transition-colors flex items-center gap-4';
                    div.innerHTML = `
                        <div class="w-8 h-8 rounded-full bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center shrink-0">
                            <i class='bx bxs-hot text-orange-500'></i>
                        </div>
                        <div>
                            <div class="font-bold text-sm text-gray-800 dark:text-gray-100">${place.name}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 truncate">${place.display_name}</div>
                        </div>
                    `;
                    div.onclick = () => {
                        input.value = place.name;
                        suggestions.classList.add('hidden');
                        handleSelection({ lat: parseFloat(place.lat), lng: parseFloat(place.lon) }, type);
                    };
                    suggestions.appendChild(div);
                });
            }

            // 2. API Search (Only if query exists and is long enough)
            if (query.length >= 3) {
                // We don't wait for this to show local results, we append async
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=my&limit=8&addressdetails=1`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.length > 0) {
                            if (hasResults) {
                                const sep = document.createElement('div');
                                sep.className = 'px-4 py-2 text-xs font-bold text-gray-500 bg-gray-50 dark:bg-gray-700/50 uppercase tracking-wider border-t border-gray-100 dark:border-gray-700 sticky top-0';
                                sep.textContent = 'Map Locations';
                                suggestions.appendChild(sep);
                            }

                            data.forEach(place => {
                                const div = document.createElement('div');
                                div.className = 'cursor-pointer px-5 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-gray-100 border-b border-gray-100 dark:border-gray-700 flex items-center gap-4';

                                // Format name
                                const parts = place.display_name.split(', ');
                                const mainName = parts[0];
                                const subName = parts.slice(1, 3).join(', ');

                                div.innerHTML = `
                                    <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center shrink-0">
                                        <i class='bx bx-map-pin text-gray-500'></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-sm text-gray-800 dark:text-gray-200">${mainName}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 truncate">${subName}...</div>
                                    </div>
                                `;
                                div.onclick = () => {
                                    input.value = mainName;
                                    suggestions.classList.add('hidden');
                                    handleSelection({ lat: parseFloat(place.lat), lng: parseFloat(place.lon) }, type);
                                };
                                suggestions.appendChild(div);
                            });
                            suggestions.classList.remove('hidden');
                        }
                    });
            }

            if (hasResults) suggestions.classList.remove('hidden');
        }

        function setupSearch(inputId, suggestionsId, type, clearBtnId) {
            const input = document.getElementById(inputId);
            const suggestions = document.getElementById(suggestionsId);
            const clearBtn = document.getElementById(clearBtnId);

            // Toggle clear button
            const toggleClear = () => {
                if (input.value.length > 0) clearBtn.classList.remove('hidden');
                else clearBtn.classList.add('hidden');
            };

            // Initial check
            toggleClear();

            // Clear functionality
            clearBtn.addEventListener('click', () => {
                input.value = '';
                toggleClear();
                suggestions.classList.add('hidden');

                // Clear coordinates
                if (type === 'pickup') {
                    pickupCoords = null;
                    document.getElementById('pickup_latitude').value = '';
                    document.getElementById('pickup_longitude').value = '';
                } else {
                    dropoffCoords = null;
                    document.getElementById('dropoff_latitude').value = '';
                    document.getElementById('dropoff_longitude').value = '';
                }

                // Reset Price/Distance if missing one point
                if (!pickupCoords || !dropoffCoords) {
                    document.getElementById('display_distance').textContent = '0.00 km';
                    document.getElementById('display_price').textContent = 'RM 0.00';
                    document.getElementById('map_container').classList.add('hidden');
                }

                input.focus();
            });

            // Show hotspots on focus
            input.addEventListener('focus', () => {
                const query = input.value.toLowerCase();
                performSearch(inputId, suggestionsId, type, query);
            });

            input.addEventListener('input', () => {
                toggleClear();
                clearTimeout(debounceTimer);
                const query = input.value.toLowerCase();
                debounceTimer = setTimeout(() => {
                    performSearch(inputId, suggestionsId, type, query);
                }, 300);
            });

            // Close on outside click
            document.addEventListener('click', (e) => {
                if (e.target !== input && e.target !== suggestions && !suggestions.contains(e.target) && e.target !== clearBtn && !clearBtn.contains(e.target)) {
                    suggestions.classList.add('hidden');
                }
            });
        }

        setupSearch('pickup_address', 'pickup_suggestions', 'pickup', 'pickup_clear');
        setupSearch('dropoff_address', 'dropoff_suggestions', 'dropoff', 'dropoff_clear');

        function setupSearch(inputId, suggestionsId, type, clearBtnId) {
            const input = document.getElementById(inputId);
            const suggestions = document.getElementById(suggestionsId);
            const clearBtn = document.getElementById(clearBtnId);

            // Toggle clear button
            const toggleClear = () => {
                if (input.value.length > 0) clearBtn.classList.remove('hidden');
                else clearBtn.classList.add('hidden');
            };

            // Initial check
            toggleClear();

            // Clear functionality
            clearBtn.addEventListener('click', () => {
                input.value = '';
                toggleClear();
                suggestions.classList.add('hidden');

                // Clear coordinates
                if (type === 'pickup') {
                    pickupCoords = null;
                    document.getElementById('pickup_latitude').value = '';
                    document.getElementById('pickup_longitude').value = '';
                } else {
                    dropoffCoords = null;
                    document.getElementById('dropoff_latitude').value = '';
                    document.getElementById('dropoff_longitude').value = '';
                }

                // Reset Price/Distance if missing one point
                if (!pickupCoords || !dropoffCoords) {
                    document.getElementById('display_distance').textContent = '0.00 km';
                    document.getElementById('display_price').textContent = 'RM 0.00';
                    document.getElementById('map_container').classList.add('hidden');
                }

                input.focus();
            });

            // Show hotspots on focus
            input.addEventListener('focus', () => {
                const query = input.value.toLowerCase();
                performSearch(inputId, suggestionsId, type, query);
            });

            input.addEventListener('input', () => {
                toggleClear();
                clearTimeout(debounceTimer);
                const query = input.value.toLowerCase();
                debounceTimer = setTimeout(() => {
                    performSearch(inputId, suggestionsId, type, query);
                }, 300);
            });

            // Close on outside click
            document.addEventListener('click', (e) => {
                if (e.target !== input && e.target !== suggestions && !suggestions.contains(e.target) && e.target !== clearBtn && !clearBtn.contains(e.target)) {
                    suggestions.classList.add('hidden');
                }
            });
        }

        setupSearch('pickup_address', 'pickup_suggestions', 'pickup', 'pickup_clear');
        setupSearch('dropoff_address', 'dropoff_suggestions', 'dropoff', 'dropoff_clear');

        function handleSelection(coords, type) {
            if (type === 'pickup') {
                pickupCoords = coords;
                const latInput = document.getElementById('pickup_latitude');
                const lngInput = document.getElementById('pickup_longitude');
                if (latInput) latInput.value = coords.lat;
                if (lngInput) lngInput.value = coords.lng;
            } else {
                dropoffCoords = coords;
                const latInput = document.getElementById('dropoff_latitude');
                const lngInput = document.getElementById('dropoff_longitude');
                if (latInput) latInput.value = coords.lat;
                if (lngInput) lngInput.value = coords.lng;
            }
            if (pickupCoords && dropoffCoords) calculateDistanceAndPrice();
        }

        let map = null;
        let routeLayer = null;
        let pickupMarker = null;
        let dropoffMarker = null;

        function initMap() {
            if (!map) {
                // Default center (KL)
                map = L.map('map').setView([3.140853, 101.693207], 12);
                L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
                    subdomains: 'abcd',
                    maxZoom: 20
                }).addTo(map);
            }
        }

        function calculateDistanceAndPrice() {
            if (!pickupCoords || !dropoffCoords) return;

            // Update OSRM call to get geometry
            const url = `https://router.project-osrm.org/route/v1/driving/${pickupCoords.lng},${pickupCoords.lat};${dropoffCoords.lng},${dropoffCoords.lat}?overview=full&geometries=geojson`;

            fetch(url).then(res => res.json()).then(data => {
                if (data.routes && data.routes.length > 0) {
                    const route = data.routes[0];
                    const dist = (route.distance / 1000).toFixed(2);

                    // Update inputs and text
                    const distanceInput = document.getElementById('distance_km');
                    const displayDistance = document.getElementById('display_distance');
                    const displayPrice = document.getElementById('display_price');

                    if (distanceInput) distanceInput.value = dist;
                    if (displayDistance) displayDistance.textContent = `${dist} km`;

                    // Simple pricing logic (Server side re-validates this)
                    let price = dist <= 60 ? dist * 2.50 : (60 * 2.50) + ((dist - 60) * 1.20);
                    if (displayPrice) displayPrice.textContent = `RM ${price.toFixed(2)}`;

                    // Show Map
                    const mapContainer = document.getElementById('map_container');
                    if (mapContainer) mapContainer.classList.remove('hidden');
                    initMap();

                    // Clear previous layers
                    if (routeLayer) map.removeLayer(routeLayer);
                    if (pickupMarker) map.removeLayer(pickupMarker);
                    if (dropoffMarker) map.removeLayer(dropoffMarker);

                    // Add Markers
                    const blueIcon = L.divIcon({ className: 'bg-transparent', html: `<div class="w-4 h-4 rounded-full bg-blue-600 ring-4 ring-white shadow-lg"></div>` });
                    const redIcon = L.divIcon({ className: 'bg-transparent', html: `<div class="w-4 h-4 rounded-full bg-red-600 ring-4 ring-white shadow-lg"></div>` });

                    pickupMarker = L.marker([pickupCoords.lat, pickupCoords.lng], { icon: blueIcon }).addTo(map);
                    dropoffMarker = L.marker([dropoffCoords.lat, dropoffCoords.lng], { icon: redIcon }).addTo(map);

                    // Draw Route
                    routeLayer = L.geoJSON(route.geometry, {
                        style: { color: '#3b82f6', weight: 5, opacity: 0.7 }
                    }).addTo(map);

                    // Fit Bounds
                    map.fitBounds(routeLayer.getBounds(), { padding: [50, 50] });
                    setTimeout(() => { map.invalidateSize(); }, 100);
                }
            }).catch(err => console.error("OSRM Error:", err));
        }
        // Initialize Map if coordinates exist
        if (pickupCoords && dropoffCoords) {
            calculateDistanceAndPrice(); // This will init map
        }
    </script>
</x-app-layout>