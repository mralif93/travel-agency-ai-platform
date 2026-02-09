<x-public-layout>
    <!-- Map Assets (Leaflet) -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="transportRateCalculator()">

        <!-- Header -->
        <div class="mb-8 text-center max-w-2xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight mb-2">Plan Your Journey</h1>
            <p class="text-gray-500 dark:text-gray-400">Get instant pricing and book your premium ride in seconds.</p>
        </div>

        <div class="flex flex-col gap-8">

            <!-- 1. Route Form Container -->
            <div
                class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800 p-6 lg:p-8 relative z-30">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Trip Details
                </h2>

                <form class="bg-gray-50 dark:bg-gray-800/50 rounded-xl p-4 lg:p-6 relative">
                    <!-- Connector Line (Hidden on mobile maybe? No, vertical stack is good) -->
                    <!-- Actually, let's make it side-by-side inputs on large screens for better "Top" presentation -->

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative">
                        <!-- Connector Line (Horizontal on Desktop, Vertical on Mobile? distinct implementation easiest to just keep separate or use simple flex) -->

                        <!-- Pickup -->
                        <div class="relative z-10">
                            <label
                                class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">From</label>
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-3 h-3 rounded-full bg-black dark:bg-white shrink-0 shadow-sm ring-4 ring-white dark:ring-gray-900">
                                </div>
                                <div class="grow relative" @click.outside="showPickupSuggestions = false">
                                    <input type="text" x-model="pickup" @click="showSuggestions('pickup')"
                                        @input.debounce.300ms="searchLocation('pickup')"
                                        @focus="showSuggestions('pickup')"
                                        class="block w-full rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:border-black dark:focus:border-white focus:ring-0 text-base py-3 pl-4 pr-10 dark:text-white placeholder-gray-400 transition-all font-medium shadow-sm"
                                        placeholder="Enter pickup location" autocomplete="off">

                                    <!-- Cleanup -->
                                    <button type="button" x-show="pickup" @click="clearLocation('pickup')"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-black dark:hover:text-white">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>

                                    <!-- Suggestions -->
                                    <div x-show="showPickupSuggestions && suggestions.pickup.length > 0"
                                        class="absolute z-50 mt-2 w-full max-h-60 overflow-y-auto rounded-xl bg-white dark:bg-gray-800 shadow-2xl border border-gray-100 dark:border-gray-700 text-sm"
                                        x-cloak>
                                        <template x-for="place in suggestions.pickup"
                                            :key="place.display_name + (place.type === 'header' ? '_header' : '')">
                                            <div>
                                                <template x-if="place.type === 'header'">
                                                    <div class="px-4 py-2 text-xs font-bold text-primary-600 bg-primary-50 dark:bg-primary-900/20 uppercase tracking-wider sticky top-0 backdrop-blur-sm z-10"
                                                        x-text="place.label"></div>
                                                </template>
                                                <template x-if="place.type !== 'header'">
                                                    <div @click="selectLocation('pickup', place)"
                                                        class="cursor-pointer px-5 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 border-b border-gray-50 dark:border-gray-700/50 last:border-0 flex items-center gap-4 transition-colors">
                                                        <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0"
                                                            :class="place.type === 'hotspot' ? 'bg-orange-100 dark:bg-orange-900/30' : 'bg-gray-100 dark:bg-gray-700'">
                                                            <i class='bx'
                                                                :class="place.type === 'hotspot' ? 'bxs-hot text-orange-500' : 'bx-map-pin text-gray-500'"></i>
                                                        </div>
                                                        <div class="overflow-hidden">
                                                            <div class="font-bold text-sm text-gray-900 dark:text-white truncate"
                                                                x-text="place.name"></div>
                                                            <div class="text-xs text-gray-500 dark:text-gray-400 truncate mt-0.5"
                                                                x-text="place.display_name"></div>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Dropoff -->
                        <div class="relative z-10">
                            <label
                                class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">To</label>
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-3 h-3 rounded-sm bg-black dark:bg-white shrink-0 shadow-sm ring-4 ring-white dark:ring-gray-900">
                                </div>
                                <div class="grow relative" @click.outside="showDropoffSuggestions = false">
                                    <input type="text" x-model="dropoff" @click="showSuggestions('dropoff')"
                                        @input.debounce.300ms="searchLocation('dropoff')"
                                        @focus="showSuggestions('dropoff')"
                                        class="block w-full rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:border-black dark:focus:border-white focus:ring-0 text-base py-3 pl-4 pr-10 dark:text-white placeholder-gray-400 transition-all font-medium shadow-sm"
                                        placeholder="Enter destination" autocomplete="off">

                                    <!-- Cleanup -->
                                    <button type="button" x-show="dropoff" @click="clearLocation('dropoff')"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-black dark:hover:text-white">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>

                                    <!-- Suggestions -->
                                    <div x-show="showDropoffSuggestions && suggestions.dropoff.length > 0"
                                        class="absolute z-50 mt-2 w-full max-h-60 overflow-y-auto rounded-xl bg-white dark:bg-gray-800 shadow-2xl border border-gray-100 dark:border-gray-700 text-sm"
                                        x-cloak>
                                        <template x-for="place in suggestions.dropoff"
                                            :key="place.display_name + (place.type === 'header' ? '_header' : '')">
                                            <div>
                                                <template x-if="place.type === 'header'">
                                                    <div class="px-4 py-2 text-xs font-bold text-primary-600 bg-primary-50 dark:bg-primary-900/20 uppercase tracking-wider sticky top-0 backdrop-blur-sm z-10"
                                                        x-text="place.label"></div>
                                                </template>
                                                <template x-if="place.type !== 'header'">
                                                    <div @click="selectLocation('dropoff', place)"
                                                        class="cursor-pointer px-5 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 border-b border-gray-50 dark:border-gray-700/50 last:border-0 flex items-center gap-4 transition-colors">
                                                        <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0"
                                                            :class="place.type === 'hotspot' ? 'bg-orange-100 dark:bg-orange-900/30' : 'bg-gray-100 dark:bg-gray-700'">
                                                            <i class='bx'
                                                                :class="place.type === 'hotspot' ? 'bxs-hot text-orange-500' : 'bx-map-pin text-gray-500'"></i>
                                                        </div>
                                                        <div class="overflow-hidden">
                                                            <div class="font-bold text-sm text-gray-900 dark:text-white truncate"
                                                                x-text="place.name"></div>
                                                            <div class="text-xs text-gray-500 dark:text-gray-400 truncate mt-0.5"
                                                                x-text="place.display_name"></div>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- 2. Map Section -->
            <div
                class="relative h-[400px] bg-gray-100 dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800 overflow-hidden">
                <div id="map" class="absolute inset-0 z-0 h-full w-full"></div>

                <!-- Empty State Overlay -->
                <div x-show="!pickupCoords || !dropoffCoords" x-transition.opacity
                    class="absolute inset-0 bg-white/40 dark:bg-black/40 backdrop-blur-sm flex flex-col items-center justify-center z-10 pointer-events-none">
                    <div class="bg-white dark:bg-gray-900 px-6 py-4 rounded-full shadow-lg flex items-center gap-3">
                        <span class="relative flex h-3 w-3">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-primary-500"></span>
                        </span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">Waiting for route
                            details...</span>
                    </div>
                </div>

                <!-- Loading -->
                <div x-show="loading"
                    class="absolute inset-0 bg-white/50 dark:bg-black/50 z-20 flex items-center justify-center backdrop-blur-sm"
                    x-cloak>
                    <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-primary-600"></div>
                </div>
            </div>

            <!-- 3. Vehicle Selection -->
            <div x-show="pickupCoords && dropoffCoords" x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0"
                id="vehicle-section" x-cloak class="scroll-mt-8">

                <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Choose Your Ride</h2>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Premium fleet for every occasion.</p>
                    </div>

                    <!-- Vehicle Type Tabs -->
                    <div
                        class="flex items-center bg-gray-100 dark:bg-gray-800 rounded-xl p-1.5 shadow-inner border border-gray-200 dark:border-gray-700 self-start md:self-auto overflow-x-auto max-w-full">
                        <template x-for="type in ['all', 'sedan', 'mpv', 'van', 'luxury']">
                            <button @click="filterType = type"
                                :class="{'bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm ring-1 ring-black/5': filterType === type, 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200': filterType !== type}"
                                class="px-5 py-2.5 rounded-lg text-sm font-semibold capitalize transition-all whitespace-nowrap"
                                x-text="type"></button>
                        </template>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($vehicles as $vehicle)
                        <div x-show="filterType === 'all' || filterType === '{{ strtolower($vehicle->type) }}'"
                            @click="selectVehicle('{{ $vehicle->id }}', {{ $vehicle->price_multiplier }}, '{{ $vehicle->make }} {{ $vehicle->model }}')"
                            :class="{'ring-2 ring-black dark:ring-white scale-[1.02] shadow-2xl': selectedVehicleId == '{{ $vehicle->id }}', 'bg-white dark:bg-gray-900 border-gray-100 dark:border-gray-800 hover:border-gray-300 dark:hover:border-gray-600 shadow-lg hover:shadow-xl': selectedVehicleId != '{{ $vehicle->id }}'}"
                            class="relative p-6 rounded-3xl border transition-all duration-300 cursor-pointer group flex flex-col h-full bg-gradient-to-br from-white to-gray-50 dark:from-gray-900 dark:to-gray-800">

                            <!-- Selection Indicator -->
                            <div x-show="selectedVehicleId == '{{ $vehicle->id }}'"
                                class="absolute -top-3 -right-3 w-8 h-8 bg-black dark:bg-white text-white dark:text-black rounded-full flex items-center justify-center shadow-lg z-10">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>

                            <!-- Vehicle Header -->
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <div
                                        class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 mb-2 capitalize">
                                        {{ $vehicle->type }}
                                    </div>
                                    <h3 class="font-bold text-gray-900 dark:text-white text-xl tracking-tight">
                                        {{ $vehicle->make }}
                                        {{ $vehicle->model }}
                                    </h3>
                                </div>
                                <!-- Icon representation -->
                                <div class="text-gray-300 dark:text-gray-600">
                                    <i class='bx bxs-car text-4xl'></i>
                                </div>
                            </div>

                            <!-- Features -->
                            <div class="flex items-center gap-4 mb-6 text-sm text-gray-600 dark:text-gray-400">
                                <div class="flex items-center gap-1.5">
                                    <i class='bx bx-user text-lg'></i>
                                    <span class="font-medium">{{ $vehicle->capacity }} Pax</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <i class='bx bx-briefcase text-lg'></i>
                                    <span class="font-medium">{{ max(1, floor($vehicle->capacity / 2)) }} Luggage</span>
                                </div>
                            </div>

                            <!-- Price Section -->
                            <div class="mt-auto pt-6 border-t border-gray-100 dark:border-gray-800">
                                <div class="flex items-end justify-between">
                                    <div>
                                        <template x-if="calculatedPrice > 0">
                                            <div>
                                                <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-0.5">
                                                    Est. Fare</div>
                                                <div class="flex items-baseline gap-1">
                                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">RM</span>
                                                    <span class="text-3xl font-extrabold text-gray-900 dark:text-white"
                                                        x-text="(basePrice * {{ $vehicle->price_multiplier }}).toFixed(2)"></span>
                                                </div>
                                            </div>
                                        </template>
                                        <template x-if="!calculatedPrice">
                                            <div class="text-sm font-medium text-gray-400">Base Rate
                                                x{{ $vehicle->price_multiplier }}</div>
                                        </template>
                                    </div>

                                    <button
                                        class="rounded-xl px-5 py-2.5 font-bold text-sm transition-all duration-300 flex items-center gap-2"
                                        :class="selectedVehicleId == '{{ $vehicle->id }}' ? 'bg-black dark:bg-white text-white dark:text-black shadow-lg translate-y-[-2px]' : 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600'">
                                        <span x-text="selectedVehicleId == '{{ $vehicle->id }}' ? 'Selected' : 'Book'"></span>
                                        <i class='bx bx-right-arrow-alt text-lg'
                                            x-show="selectedVehicleId != '{{ $vehicle->id }}'"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div
                            class="col-span-full p-12 text-center border-2 border-dashed border-gray-200 dark:border-gray-800 rounded-3xl">
                            <p class="text-gray-500 dark:text-gray-400 font-medium">No vehicles found available.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- 4. Booking Form (Appears after vehicle selection) -->
            <div x-show="selectedVehicleId && calculatedPrice > 0" x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="opacity-0 translate-y-12" x-transition:enter-end="opacity-100 translate-y-0"
                id="booking-form-section" x-cloak class="scroll-mt-8">

                <div
                    class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-100 dark:border-gray-800 overflow-hidden">
                    <div class="p-8 lg:p-10">
                        <div class="flex items-center justify-between mb-8 border-b border-gray-100 dark:border-gray-800 pb-8">
                            <div>
                                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Finalize Booking</h2>
                                <p class="text-gray-500 dark:text-gray-400 mt-1">Complete your details to secure your
                                    ride.</p>
                            </div>
                            <div class="text-right hidden md:block">
                                <div class="text-sm font-bold text-gray-400 uppercase tracking-wider">Selected Vehicle</div>
                                <div class="text-xl font-bold text-gray-900 dark:text-white" x-text="selectedVehicleName">
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('book.store') }}" class="grid grid-cols-1 lg:grid-cols-2 gap-10" @submit="loading = true">
                            @csrf
                            
                            <!-- Hidden Inputs for Calculated Data -->
                            <input type="hidden" name="pickup_address" x-model="pickup">
                            <input type="hidden" name="dropoff_address" x-model="dropoff">
                            <input type="hidden" name="pickup_latitude" :value="pickupCoords?.lat">
                            <input type="hidden" name="pickup_longitude" :value="pickupCoords?.lng">
                            <input type="hidden" name="dropoff_latitude" :value="dropoffCoords?.lat">
                            <input type="hidden" name="dropoff_longitude" :value="dropoffCoords?.lng">
                            <input type="hidden" name="distance_km" x-model="distanceKm">
                            <input type="hidden" name="vehicle_id" x-model="selectedVehicleId">
                            <input type="hidden" name="base_price" x-model="basePrice"> <!-- For reference/validation -->

                            <!-- Left: Personal Details -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                    <span
                                        class="w-6 h-6 rounded-full bg-black dark:bg-white text-white dark:text-black text-xs flex items-center justify-center">1</span>
                                    Contact Information
                                </h3>

                                <div class="grid grid-cols-1 gap-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
                                        <input type="text" name="name"
                                            class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-3.5 focus:border-black dark:focus:border-white focus:ring-0 transition-colors"
                                            placeholder="John Doe" required value="{{ auth()->check() ? auth()->user()->name : '' }}">
                                    </div>
                                    <div class="grid grid-cols-2 gap-6">
                                        <div>
                                            <label
                                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Phone</label>
                                            <input type="tel" name="phone"
                                                class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-3.5 focus:border-black dark:focus:border-white focus:ring-0 transition-colors"
                                                placeholder="+60 12-345 6789" required>
                                        </div>
                                        <div>
                                            <label
                                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email</label>
                                            <input type="email" name="email"
                                                class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-3.5 focus:border-black dark:focus:border-white focus:ring-0 transition-colors"
                                                placeholder="john@example.com" required value="{{ auth()->check() ? auth()->user()->email : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Trip Details -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                    <span
                                        class="w-6 h-6 rounded-full bg-black dark:bg-white text-white dark:text-black text-xs flex items-center justify-center">2</span>
                                    Trip Schedule
                                </h3>

                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Pickup Date</label>
                                        <input type="date" name="date"
                                            class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-3.5 focus:border-black dark:focus:border-white focus:ring-0 transition-colors"
                                            required min="{{ date('Y-m-d') }}">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Pickup Time</label>
                                        <input type="time" name="time"
                                            class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-3.5 focus:border-black dark:focus:border-white focus:ring-0 transition-colors"
                                            required>
                                    </div>
                                    <div class="col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Flight No.
                                            (Optional)</label>
                                        <input type="text" name="flight_number"
                                            class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-3.5 focus:border-black dark:focus:border-white focus:ring-0 transition-colors"
                                            placeholder="e.g. MH123">
                                    </div>
                                    <div class="col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Remarks</label>
                                        <textarea name="remarks" rows="2"
                                            class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-3.5 focus:border-black dark:focus:border-white focus:ring-0 transition-colors"
                                            placeholder="Child seat request, extra luggage, etc."></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer Action (Inside Form) -->
                            <div class="col-span-1 lg:col-span-2 bg-gray-50 dark:bg-gray-800/50 p-8 flex items-center justify-between border-t border-gray-100 dark:border-gray-800 rounded-b-3xl">
                                <div class="hidden sm:block">
                                    <div class="text-sm font-medium text-gray-500">Total Estimated Price</div>
                                    <div class="text-3xl font-black text-gray-900 dark:text-white" x-text="'RM ' + calculatedPrice.toFixed(2)"></div>
                                </div>
                                <button type="submit"
                                    :disabled="loading"
                                    class="w-full sm:w-auto px-8 py-4 bg-black dark:bg-white text-white dark:text-black rounded-xl font-bold text-lg hover:scale-105 transition-transform shadow-xl flex items-center justify-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span x-show="!loading">Confirm Booking</span>
                                    <span x-show="loading">Processing...</span>
                                    <i x-show="!loading" class='bx bx-check-circle text-xl'></i>
                                    <div x-show="loading" class="animate-spin rounded-full h-5 w-5 border-b-2 border-current"></div>
                                </button>
                            </div>
                        </form>
                </div>
            </div>

        </div>

    </div>

    <!-- Logic -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('transportRateCalculator', () => ({
                pickup: '',
                dropoff: '',
                pickupCoords: null,
                dropoffCoords: null,
                showPickupSuggestions: false,
                showDropoffSuggestions: false,
                suggestions: { pickup: [], dropoff: [] },

                selectedVehicleId: null,
                selectedVehicleName: '',
                selectedMultiplier: 1.0,
                filterType: 'all',

                loading: false,
                basePrice: 0,
                calculatedPrice: 0,
                distanceKm: 0,

                form: {
                    name: '',
                    email: '',
                    phone: '',
                    date: '',
                    time: '',
                    flight: '',
                    remarks: ''
                },

                map: null,
                markers: { pickup: null, dropoff: null },
                routeLayer: null,

                customLocations: [
                    { name: "KLIA 1 - Departure Hall (Door 1)", lat: "2.7533", lon: "101.7010", display_name: "KLIA 1, Departure Hall Level 5, Door 1", type: "hotspot" },
                    { name: "KLIA 1 - Arrival (E-hailing Pickup)", lat: "2.7540", lon: "101.7020", display_name: "KLIA 1, Arrival Level 3, E-hailing Pickup Point", type: "hotspot" },
                    { name: "KLIA 2 - Transportation Hub (Level 1)", lat: "2.7433", lon: "101.6860", display_name: "KLIA 2, Gateway Transportation Hub, Level 1", type: "hotspot" },
                    { name: "KLIA 2 - Departure (Drop-off)", lat: "2.7440", lon: "101.6870", display_name: "KLIA 2, Departure Hall Level 3", type: "hotspot" },
                    { name: "KL Sentral - Main Entrance", lat: "3.1340", lon: "101.6860", display_name: "KL Sentral, Main Entrance, Kuala Lumpur", type: "hotspot" },
                    { name: "Pavilion KL - Main Entrance", lat: "3.1480", lon: "101.7130", display_name: "Pavilion Kuala Lumpur, Main Entrance, Bukit Bintang", type: "hotspot" },
                    { name: "Mid Valley Megamall - North Court", lat: "3.1180", lon: "101.6770", display_name: "Mid Valley Megamall, North Court Entrance", type: "hotspot" },
                    { name: "Suria KLCC - Ampang Mall Entrance", lat: "3.1580", lon: "101.7120", display_name: "Suria KLCC, Ampang Mall Main Entrance", type: "hotspot" }
                ],

                init() {
                    this.$nextTick(() => {
                        this.initMap();
                    });
                },

                initMap() {
                    this.map = L.map('map', { zoomControl: false }).setView([3.140853, 101.693207], 13);
                    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                        attribution: '&copy; OpenStreetMap &copy; CARTO',
                        maxZoom: 20
                    }).addTo(this.map);
                    L.control.zoom({ position: 'bottomright' }).addTo(this.map);
                    setTimeout(() => { this.map.invalidateSize(); }, 500);
                },

                searchLocation(type) {
                    const query = this[type].toLowerCase();
                    let finalResults = [];

                    // 1. Local Search (Hotspots)
                    const localMatches = this.customLocations.filter(loc => {
                        if (query.length === 0) return true;
                        return loc.name.toLowerCase().includes(query) || loc.display_name.toLowerCase().includes(query);
                    });

                    if (localMatches.length > 0) {
                        finalResults.push({ type: 'header', label: query.length === 0 ? '🔥 Popular Hotspots' : 'Recommended Spots' });
                        finalResults = [...finalResults, ...localMatches];
                    }

                    if (query.length < 2) {
                        this.suggestions[type] = finalResults;
                        this['show' + type.charAt(0).toUpperCase() + type.slice(1) + 'Suggestions'] = true;
                        return;
                    }

                    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=my&limit=8&addressdetails=1`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.length > 0) {
                                if (finalResults.length > 0) {
                                    finalResults.push({ type: 'header', label: 'Map Locations' });
                                }
                                const apiResults = data.map(item => ({
                                    name: item.display_name.split(',')[0],
                                    lat: item.lat,
                                    lon: item.lon,
                                    display_name: item.display_name,
                                    type: 'api'
                                }));
                                finalResults = [...finalResults, ...apiResults];
                            }

                            this.suggestions[type] = finalResults;
                            this['show' + type.charAt(0).toUpperCase() + type.slice(1) + 'Suggestions'] = true;
                        });
                },

                showSuggestions(type) {
                    // Always ensure we have something to show (Hotspots if nothing else)
                    if (!this.suggestions[type] || this.suggestions[type].length === 0) {
                        this.suggestions[type] = this.customLocations;
                    }
                    // If input has value, trigger search to update list (optional, but good for consistency)
                    if (this[type].length > 0) {
                        this.searchLocation(type);
                    } else {
                        this.suggestions[type] = this.customLocations;
                        this['show' + type.charAt(0).toUpperCase() + type.slice(1) + 'Suggestions'] = true;
                    }
                },

                selectLocation(type, place) {
                    this[type] = place.name;
                    this[type + 'Coords'] = { lat: place.lat, lng: place.lon };
                    this['show' + type.charAt(0).toUpperCase() + type.slice(1) + 'Suggestions'] = false;

                    this.updateMapMarkers();
                    this.calculateRoute();
                },

                clearLocation(type) {
                    this[type] = '';
                    this[type + 'Coords'] = null;
                    if (type === 'pickup' && this.markers.pickup) this.map.removeLayer(this.markers.pickup);
                    if (type === 'dropoff' && this.markers.dropoff) this.map.removeLayer(this.markers.dropoff);
                    if (this.routeLayer) this.map.removeLayer(this.routeLayer);
                    this.calculatedPrice = 0;
                    this.basePrice = 0;
                    this.distanceKm = 0;
                    this.selectedVehicleId = null; // Reset selection on new route
                },

                updateMapMarkers() {
                    if (this.pickupCoords) {
                        if (this.markers.pickup) this.map.removeLayer(this.markers.pickup);
                        const icon = L.divIcon({ className: 'bg-transparent', html: '<div class="w-4 h-4 rounded-full bg-black ring-4 ring-white shadow-xl transform scale-125"></div>' });
                        this.markers.pickup = L.marker([this.pickupCoords.lat, this.pickupCoords.lng], { icon: icon }).addTo(this.map);
                    }
                    if (this.dropoffCoords) {
                        if (this.markers.dropoff) this.map.removeLayer(this.markers.dropoff);
                        const icon = L.divIcon({ className: 'bg-transparent', html: '<div class="w-4 h-4 rounded-sm bg-black ring-4 ring-white shadow-xl transform scale-125"></div>' });
                        this.markers.dropoff = L.marker([this.dropoffCoords.lat, this.dropoffCoords.lng], { icon: icon }).addTo(this.map);
                    }
                },

                async calculateRoute() {
                    if (!this.pickupCoords || !this.dropoffCoords) return;

                    this.loading = true;
                    try {
                        const url = `https://router.project-osrm.org/route/v1/driving/${this.pickupCoords.lng},${this.pickupCoords.lat};${this.dropoffCoords.lng},${this.dropoffCoords.lat}?overview=full&geometries=geojson`;
                        const res = await fetch(url);
                        const data = await res.json();

                        if (!data.routes || data.routes.length === 0) return;

                        const route = data.routes[0];
                        this.distanceKm = (route.distance / 1000);

                        let price = 0;
                        if (this.distanceKm <= 60) {
                            price = this.distanceKm * 2.50;
                        } else {
                            price = (60 * 2.50) + ((this.distanceKm - 60) * 1.20);
                        }
                        this.basePrice = price;
                        this.updateTotal();

                        if (this.routeLayer) this.map.removeLayer(this.routeLayer);
                        this.routeLayer = L.geoJSON(route.geometry, { style: { color: '#000', weight: 4, opacity: 0.8, lineCap: 'round' } }).addTo(this.map);
                        this.map.fitBounds(this.routeLayer.getBounds(), { padding: [50, 50], maxZoom: 15 });

                        // Scroll to vehicles
                        setTimeout(() => {
                            document.getElementById('vehicle-section').scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }, 500);

                    } catch (e) {
                        console.error('Routing Error', e);
                    } finally {
                        this.loading = false;
                    }
                },

                selectVehicle(id, multiplier, name) {
                    this.selectedVehicleId = id;
                    this.selectedVehicleName = name;
                    this.selectedMultiplier = multiplier;
                    this.updateTotal();
                    
                    // Scroll to form
                    setTimeout(() => {
                        document.getElementById('booking-form-section').scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 100);
                },

                updateTotal() {
                    if (this.basePrice > 0) {
                        this.calculatedPrice = this.basePrice * this.selectedMultiplier;
                    }
                }
            }))
        })
    </script>
</x-public-layout>