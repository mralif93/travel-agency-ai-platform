<x-customer-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">My Trips</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">View and manage all your travel history</p>
            </div>
            <a href="{{ route('transport-rates') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-xl shadow-sm transition-colors">
                <i class='bx bx-plus'></i>
                Book New Trip
            </a>
        </div>

        <!-- Filter Tabs -->
        <div class="flex flex-wrap gap-2" x-data="{ activeTab: '{{ request('status', 'all') }}' }">
            <a href="{{ route('customer.trips') }}" 
               class="px-4 py-2 text-sm font-medium rounded-lg transition-all {{ !request('status') ? 'bg-primary-600 text-white shadow-sm' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 ring-1 ring-gray-200 dark:ring-gray-700' }}">
                All Trips
            </a>
            <a href="{{ route('customer.trips', ['status' => 'pending']) }}" 
               class="px-4 py-2 text-sm font-medium rounded-lg transition-all {{ request('status') === 'pending' ? 'bg-amber-500 text-white shadow-sm' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 ring-1 ring-gray-200 dark:ring-gray-700' }}">
                <i class='bx bx-time mr-1'></i> Pending
            </a>
            <a href="{{ route('customer.trips', ['status' => 'active']) }}" 
               class="px-4 py-2 text-sm font-medium rounded-lg transition-all {{ request('status') === 'active' ? 'bg-blue-500 text-white shadow-sm' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 ring-1 ring-gray-200 dark:ring-gray-700' }}">
                <i class='bx bx-trip mr-1'></i> Active
            </a>
            <a href="{{ route('customer.trips', ['status' => 'completed']) }}" 
               class="px-4 py-2 text-sm font-medium rounded-lg transition-all {{ request('status') === 'completed' ? 'bg-green-500 text-white shadow-sm' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 ring-1 ring-gray-200 dark:ring-gray-700' }}">
                <i class='bx bx-check-circle mr-1'></i> Completed
            </a>
            <a href="{{ route('customer.trips', ['status' => 'cancelled']) }}" 
               class="px-4 py-2 text-sm font-medium rounded-lg transition-all {{ request('status') === 'cancelled' ? 'bg-red-500 text-white shadow-sm' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 ring-1 ring-gray-200 dark:ring-gray-700' }}">
                <i class='bx bx-x-circle mr-1'></i> Cancelled
            </a>
        </div>

        <!-- Trips Grid -->
        @forelse($trips as $trip)
        @php
            $statusConfig = [
                'pending' => [
                    'color' => 'amber',
                    'icon' => 'bx-time',
                    'bg' => 'bg-amber-50 dark:bg-amber-900/20',
                    'border' => 'border-amber-200 dark:border-amber-800',
                    'text' => 'text-amber-600 dark:text-amber-400',
                    'badge' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400'
                ],
                'active' => [
                    'color' => 'blue',
                    'icon' => 'bx-trip',
                    'bg' => 'bg-blue-50 dark:bg-blue-900/20',
                    'border' => 'border-blue-200 dark:border-blue-800',
                    'text' => 'text-blue-600 dark:text-blue-400',
                    'badge' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400'
                ],
                'completed' => [
                    'color' => 'green',
                    'icon' => 'bx-check-circle',
                    'bg' => 'bg-green-50 dark:bg-green-900/20',
                    'border' => 'border-green-200 dark:border-green-800',
                    'text' => 'text-green-600 dark:text-green-400',
                    'badge' => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400'
                ],
                'cancelled' => [
                    'color' => 'red',
                    'icon' => 'bx-x-circle',
                    'bg' => 'bg-red-50 dark:bg-red-900/20',
                    'border' => 'border-red-200 dark:border-red-800',
                    'text' => 'text-red-600 dark:text-red-400',
                    'badge' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400'
                ],
            ];
            $config = $statusConfig[$trip->status] ?? $statusConfig['pending'];
        @endphp
        
        <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700/50 overflow-hidden hover:shadow-md transition-all">
            <div class="p-5 sm:p-6">
                <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                    <!-- Status & ID -->
                    <div class="flex items-center gap-3 lg:w-48">
                        <div class="w-12 h-12 rounded-xl {{ $config['bg'] }} flex items-center justify-center flex-shrink-0">
                            @if($trip->status === 'active')
                            <i class='bx {{ $config['icon'] }} {{ $config['text'] }} text-2xl animate-pulse'></i>
                            @else
                            <i class='bx {{ $config['icon'] }} {{ $config['text'] }} text-2xl'></i>
                            @endif
                        </div>
                        <div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $config['badge'] }} capitalize">
                                {{ $trip->status }}
                            </span>
                            <p class="text-xs font-mono text-gray-400 dark:text-gray-500 mt-1">#{{ substr($trip->id, 0, 8) }}</p>
                        </div>
                    </div>

                    <!-- Route Info -->
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-col gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center flex-shrink-0">
                                    <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                </div>
                                <p class="text-sm text-gray-700 dark:text-gray-300 truncate">{{ $trip->pickup_address }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center flex-shrink-0">
                                    <div class="w-2 h-2 rounded-full bg-red-500"></div>
                                </div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $trip->dropoff_address }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Schedule & Vehicle -->
                    <div class="flex flex-wrap gap-4 lg:gap-6 lg:items-center">
                        <div class="flex items-center gap-2">
                            <i class='bx bx-calendar text-gray-400'></i>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Date</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $trip->scheduled_at->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class='bx bx-time-five text-gray-400'></i>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Time</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $trip->scheduled_at->format('h:i A') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class='bx bx-car text-gray-400'></i>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Vehicle</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white capitalize">{{ $trip->vehicle?->type ?? 'Standard' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="lg:text-right lg:min-w-[100px]">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Total Fare</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white">RM{{ number_format($trip->total_price, 2) }}</p>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-2 lg:ml-4">
                        <a href="{{ route('customer.trips.show', $trip) }}" 
                           class="flex-1 lg:flex-none inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-xl transition-colors">
                            <i class='bx bx-show'></i>
                            <span class="lg:hidden">View</span>
                        </a>
                        <button type="button" onclick="showQrCode('{{ $trip->id }}')"
                            class="p-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-400 rounded-xl transition-colors" title="QR Code">
                            <i class='bx bx-qr text-lg'></i>
                        </button>
                        <a href="{{ route('customer.trips.print', $trip) }}" target="_blank"
                            class="p-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-400 rounded-xl transition-colors" title="Download PDF">
                            <i class='bx bxs-file-pdf text-lg'></i>
                        </a>
                    </div>
                </div>

                @if($trip->flight_number || $trip->remarks)
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700 flex flex-wrap gap-4">
                    @if($trip->flight_number)
                    <div class="flex items-center gap-2 text-sm">
                        <i class='bx bx-plane text-primary-500'></i>
                        <span class="text-gray-500 dark:text-gray-400">Flight:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $trip->flight_number }}</span>
                    </div>
                    @endif
                    @if($trip->remarks)
                    <div class="flex items-center gap-2 text-sm">
                        <i class='bx bx-note text-gray-400'></i>
                        <span class="text-gray-500 dark:text-gray-400">Notes:</span>
                        <span class="text-gray-700 dark:text-gray-300">{{ Illuminate\Support\Str::limit($trip->remarks, 50) }}</span>
                    </div>
                    @endif
                </div>
                @endif
            </div>

            <!-- Hidden QR Code Content -->
            <div id="qr-content-{{ $trip->id }}" class="hidden">
                <div class="flex flex-col items-center justify-center p-4 text-center">
                    <div class="bg-white p-3 rounded-lg border border-gray-100 shadow-sm inline-block mb-4">
                        {!! QrCode::size(180)->color(0, 0, 0)->generate($trip->id) !!}
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Scan to verify trip</p>
                    <p class="text-xs font-mono font-bold text-gray-400">#{{ substr($trip->id, 0, 8) }}</p>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700/50 p-12 text-center">
            <div class="w-20 h-20 mx-auto bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-6">
                <i class='bx bx-map text-4xl text-gray-400 dark:text-gray-500'></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No trips found</h3>
            <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-6">
                @if(request('status'))
                    You don't have any {{ request('status') }} trips yet.
                @else
                    Ready for your first journey? Book a trip with us today and experience seamless travel.
                @endif
            </p>
            <a href="{{ route('transport-rates') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-xl transition-colors">
                <i class='bx bx-plus'></i>
                Book Your First Trip
            </a>
        </div>
        @endforelse

        <!-- Pagination -->
        @if($trips->hasPages())
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700/50 px-4 py-3">
            {{ $trips->links() }}
        </div>
        @endif
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
