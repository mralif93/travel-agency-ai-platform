<x-customer-layout>
    <div class="space-y-8">
        <!-- Hero Welcome Section -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-primary-600 via-primary-700 to-indigo-700 px-6 py-8 sm:px-8 sm:py-10 shadow-xl">
            <div class="absolute inset-0 bg-grid-white/10 [mask-image:linear-gradient(0deg,transparent,black)]"></div>
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl"></div>
            
            <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <div>
                    <p class="text-primary-200 text-sm font-medium">Welcome back</p>
                    <h1 class="text-2xl sm:text-3xl font-bold text-white mt-1">{{ $user->name }}</h1>
                    <p class="text-primary-100 mt-2 text-sm sm:text-base max-w-md">
                        Manage your trips, track bookings, and explore seamless travel experiences.
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('transport-rates') }}" 
                        class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-semibold text-primary-700 shadow-lg hover:bg-primary-50 transition-all hover:shadow-xl hover:-translate-y-0.5">
                        <i class='bx bx-plus-circle text-lg'></i>
                        Book New Trip
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            <!-- Pending -->
            <div class="group relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 p-5 shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700/50 hover:shadow-md transition-all">
                <div class="absolute top-0 right-0 w-20 h-20 bg-amber-50 dark:bg-amber-900/20 rounded-full -mr-10 -mt-10"></div>
                <div class="relative">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-amber-100 dark:bg-amber-900/30">
                            <i class='bx bx-time text-amber-600 dark:text-amber-400 text-xl'></i>
                        </div>
                        <span class="text-xs font-medium text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/30 px-2 py-1 rounded-full">Pending</span>
                    </div>
                    <div class="mt-4">
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ $pendingOrders }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Awaiting confirmation</p>
                    </div>
                </div>
            </div>

            <!-- Active -->
            <div class="group relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 p-5 shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700/50 hover:shadow-md transition-all">
                <div class="absolute top-0 right-0 w-20 h-20 bg-blue-50 dark:bg-blue-900/20 rounded-full -mr-10 -mt-10"></div>
                <div class="relative">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30">
                            <i class='bx bx-trip text-blue-600 dark:text-blue-400 text-xl'></i>
                        </div>
                        <span class="text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 px-2 py-1 rounded-full">Active</span>
                    </div>
                    <div class="mt-4">
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ $orders->where('status', 'active')->count() }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">In progress</p>
                    </div>
                </div>
            </div>

            <!-- Completed -->
            <div class="group relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 p-5 shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700/50 hover:shadow-md transition-all">
                <div class="absolute top-0 right-0 w-20 h-20 bg-green-50 dark:bg-green-900/20 rounded-full -mr-10 -mt-10"></div>
                <div class="relative">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-green-100 dark:bg-green-900/30">
                            <i class='bx bx-check-circle text-green-600 dark:text-green-400 text-xl'></i>
                        </div>
                        <span class="text-xs font-medium text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/30 px-2 py-1 rounded-full">Done</span>
                    </div>
                    <div class="mt-4">
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ $completedOrders }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Completed trips</p>
                    </div>
                </div>
            </div>

            <!-- Total Spent -->
            <div class="group relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 p-5 shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700/50 hover:shadow-md transition-all">
                <div class="absolute top-0 right-0 w-20 h-20 bg-primary-50 dark:bg-primary-900/20 rounded-full -mr-10 -mt-10"></div>
                <div class="relative">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-primary-100 dark:bg-primary-900/30">
                            <i class='bx bx-wallet text-primary-600 dark:text-primary-400 text-xl'></i>
                        </div>
                        <span class="text-xs font-medium text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/30 px-2 py-1 rounded-full">Total</span>
                    </div>
                    <div class="mt-4">
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">RM{{ number_format($totalSpent, 0) }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Total spent</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Upcoming Trip -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Quick Actions -->
            <div class="lg:col-span-1 space-y-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Quick Actions</h2>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('transport-rates') }}" class="group flex flex-col items-center justify-center p-4 bg-white dark:bg-gray-800 rounded-xl shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700/50 hover:shadow-md hover:ring-primary-200 dark:hover:ring-primary-800 transition-all">
                        <div class="w-12 h-12 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <i class='bx bx-plus text-primary-600 dark:text-primary-400 text-2xl'></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">New Booking</span>
                    </a>
                    <a href="{{ route('customer.trips') }}" class="group flex flex-col items-center justify-center p-4 bg-white dark:bg-gray-800 rounded-xl shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700/50 hover:shadow-md hover:ring-primary-200 dark:hover:ring-primary-800 transition-all">
                        <div class="w-12 h-12 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <i class='bx bx-history text-indigo-600 dark:text-indigo-400 text-2xl'></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Trip History</span>
                    </a>
                    <a href="{{ route('customer.profile.edit') }}" class="group flex flex-col items-center justify-center p-4 bg-white dark:bg-gray-800 rounded-xl shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700/50 hover:shadow-md hover:ring-primary-200 dark:hover:ring-primary-800 transition-all">
                        <div class="w-12 h-12 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <i class='bx bx-user text-purple-600 dark:text-purple-400 text-2xl'></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Profile</span>
                    </a>
                    <a href="{{ route('transport-rates') }}#calculator" class="group flex flex-col items-center justify-center p-4 bg-white dark:bg-gray-800 rounded-xl shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700/50 hover:shadow-md hover:ring-primary-200 dark:hover:ring-primary-800 transition-all">
                        <div class="w-12 h-12 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <i class='bx bx-calculator text-emerald-600 dark:text-emerald-400 text-2xl'></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Get Quote</span>
                    </a>
                </div>
            </div>

            <!-- Upcoming Trip -->
            <div class="lg:col-span-2">
                @php
                    $upcomingTrip = $orders->where('status', 'pending')->where('scheduled_at', '>=', now())->sortBy('scheduled_at')->first()
                        ?: $orders->where('status', 'active')->first();
                @endphp
                
                @if($upcomingTrip)
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Upcoming Trip</h2>
                <div class="relative overflow-hidden rounded-xl bg-gradient-to-br from-indigo-500 via-primary-500 to-purple-600 p-1">
                    <div class="bg-white dark:bg-gray-900 rounded-lg p-5 sm:p-6">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-4">
                                    @if($upcomingTrip->status === 'active')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400">
                                        <span class="animate-pulse w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                        Trip Active
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400">
                                        Scheduled
                                    </span>
                                    @endif
                                    <span class="text-xs text-gray-500 dark:text-gray-400">#{{ substr($upcomingTrip->id, 0, 8) }}</span>
                                </div>
                                
                                <div class="space-y-3">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center mt-0.5">
                                            <i class='bx bx-map-pin text-green-600 dark:text-green-400'></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Pickup</p>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white mt-0.5">{{ Illuminate\Support\Str::limit($upcomingTrip->pickup_address, 50) }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center mt-0.5">
                                            <i class='bx bx-map text-red-600 dark:text-red-400'></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Drop-off</p>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white mt-0.5">{{ Illuminate\Support\Str::limit($upcomingTrip->dropoff_address, 50) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex flex-col items-end gap-3 sm:border-l sm:border-gray-200 dark:sm:border-gray-700 sm:pl-5">
                                <div class="text-right">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Scheduled</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white mt-0.5">
                                        {{ $upcomingTrip->scheduled_at->format('d M Y') }}
                                    </p>
                                    <p class="text-sm text-primary-600 dark:text-primary-400 font-medium">
                                        {{ $upcomingTrip->scheduled_at->format('h:i A') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Fare</p>
                                    <p class="text-xl font-bold text-gray-900 dark:text-white">RM{{ number_format($upcomingTrip->total_price, 2) }}</p>
                                </div>
                                <a href="{{ route('customer.trips.show', $upcomingTrip) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors">
                                    View Details
                                    <i class='bx bx-right-arrow-alt'></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Ready for Your Next Trip?</h2>
                <div class="rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-800/50 border-2 border-dashed border-gray-200 dark:border-gray-700 p-8 text-center">
                    <div class="w-16 h-16 mx-auto rounded-full bg-white dark:bg-gray-700 shadow-sm flex items-center justify-center mb-4">
                        <i class='bx bx-map-alt text-3xl text-gray-400 dark:text-gray-500'></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">No Upcoming Trips</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">Start planning your next journey with us. Book a trip in just a few clicks!</p>
                    <a href="{{ route('transport-rates') }}" class="inline-flex items-center gap-2 mt-4 px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors">
                        <i class='bx bx-plus'></i>
                        Book Your First Trip
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Recent Orders Section -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Bookings</h2>
                <a href="{{ route('customer.trips') }}" class="text-sm font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 flex items-center gap-1">
                    View All
                    <i class='bx bx-chevron-right'></i>
                </a>
            </div>
            
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700/50 overflow-hidden">
                @forelse($orders->take(5) as $order)
                <div class="group p-4 sm:p-5 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors {{ !$loop->last ? 'border-b border-gray-100 dark:border-gray-700' : '' }}">
                    <div class="flex items-center gap-4">
                        <!-- Status Icon -->
                        <div class="flex-shrink-0">
                            @php
                                $statusConfig = [
                                    'pending' => ['icon' => 'bx-time', 'bg' => 'bg-amber-100 dark:bg-amber-900/30', 'text' => 'text-amber-600 dark:text-amber-400'],
                                    'active' => ['icon' => 'bx-trip', 'bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-600 dark:text-blue-400'],
                                    'completed' => ['icon' => 'bx-check-circle', 'bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-600 dark:text-green-400'],
                                    'cancelled' => ['icon' => 'bx-x-circle', 'bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-600 dark:text-red-400'],
                                ];
                                $config = $statusConfig[$order->status] ?? $statusConfig['pending'];
                            @endphp
                            <div class="w-10 h-10 rounded-full {{ $config['bg'] }} flex items-center justify-center">
                                <i class='bx {{ $config['icon'] }} {{ $config['text'] }} text-lg'></i>
                            </div>
                        </div>
                        
                        <!-- Order Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">#{{ substr($order->id, 0, 8) }}</span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $config['bg'] }} {{ $config['text'] }} capitalize">
                                    {{ $order->status }}
                                </span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-3">
                                <p class="text-sm text-gray-600 dark:text-gray-400 truncate">
                                    <span class="text-green-500">●</span> {{ Illuminate\Support\Str::limit($order->pickup_address, 30) }}
                                </p>
                                <i class='bx bx-right-arrow-alt text-gray-300 dark:text-gray-600 hidden sm:block'></i>
                                <p class="text-sm text-gray-600 dark:text-gray-400 truncate">
                                    <span class="text-red-500">●</span> {{ Illuminate\Support\Str::limit($order->dropoff_address, 30) }}
                                </p>
                            </div>
                        </div>
                        
                        <!-- Price & Date -->
                        <div class="flex-shrink-0 text-right hidden sm:block">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">RM{{ number_format($order->total_price, 2) }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $order->scheduled_at->format('d M, h:i A') }}</p>
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex-shrink-0 flex items-center gap-1">
                            <a href="{{ route('customer.trips.show', $order) }}" class="p-2 text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors" title="View Details">
                                <i class='bx bx-show text-lg'></i>
                            </a>
                            <button type="button" onclick="showQrCode('{{ $order->id }}')" class="p-2 text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors" title="QR Code">
                                <i class='bx bx-qr text-lg'></i>
                            </button>
                            <a href="{{ route('customer.trips.print', $order) }}" target="_blank" class="p-2 text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors" title="Download PDF">
                                <i class='bx bxs-file-pdf text-lg'></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Hidden QR Code Content -->
                    <div id="qr-content-{{ $order->id }}" class="hidden">
                        <div class="flex flex-col items-center justify-center p-2 text-center">
                            <div class="bg-white p-3 rounded-lg border border-gray-100 shadow-sm inline-block mb-4">
                                {!! QrCode::size(180)->color(0, 0, 0)->generate($order->id) !!}
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Scan to verify your trip</p>
                            <div class="w-full border-t border-gray-100 dark:border-gray-700 pt-3">
                                <p class="text-xs font-mono font-bold text-gray-400 uppercase tracking-wider mb-1">#{{ substr($order->id, 0, 8) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center">
                    <div class="w-16 h-16 mx-auto rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-4">
                        <i class='bx bx-calendar-x text-3xl text-gray-400 dark:text-gray-500'></i>
                    </div>
                    <h3 class="text-base font-medium text-gray-900 dark:text-white">No bookings yet</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Start your journey by booking your first trip.</p>
                    <a href="{{ route('transport-rates') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors">
                        <i class='bx bx-plus'></i>
                        Book a Trip
                    </a>
                </div>
                @endforelse
            </div>
            
            @if($orders->hasMorePages())
            <div class="mt-4 text-center">
                <a href="{{ route('customer.trips') }}" class="inline-flex items-center gap-2 text-sm font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400">
                    View All Bookings
                    <i class='bx bx-arrow-right'></i>
                </a>
            </div>
            @endif
        </div>
    </div>

    <script>
        function showQrCode(orderId) {
            var content = document.getElementById('qr-content-' + orderId).innerHTML;
            var isDark = document.documentElement.classList.contains('dark');

            Swal.fire({
                title: 'Trip QR Code',
                html: content,
                showConfirmButton: false,
                showCloseButton: true,
                width: '360px',
                padding: '24px',
                background: isDark ? '#1f2937' : '#fff',
                color: isDark ? '#f3f4f6' : '#1f2937'
            });
        }
    </script>
</x-customer-layout>
