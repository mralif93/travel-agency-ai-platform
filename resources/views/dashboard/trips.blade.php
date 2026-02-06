<x-customer-layout>
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">My Trips</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">View and manage all your travel history</p>
    </div>

    <div
        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th scope="col"
                            class="pl-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Order ID</th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider w-1/3">
                            Route</th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Schedule</th>
                        <th scope="col"
                            class="px-6 py-4 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Status</th>
                        <th scope="col"
                            class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Amount</th>
                        <th scope="col"
                            class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                    @forelse ($trips as $trip)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                            <td class="pl-6 py-4 whitespace-nowrap">
                                <span
                                    class="font-mono text-xs text-gray-500 dark:text-gray-400 group-hover:text-primary-600 transition-colors">#{{ substr($trip->id, 0, 8) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-3">
                                    {{-- Pickup --}}
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="h-2 w-2 rounded-full bg-green-500 ring-4 ring-green-100 dark:ring-green-900/30">
                                        </div>
                                        <span
                                            class="text-sm text-gray-600 dark:text-gray-300">{{ $trip->pickup_location }}</span>
                                    </div>
                                    {{-- Connector --}}
                                    <div class="absolute ml-1 mt-3.5 h-6 w-0.5 bg-gray-100 dark:bg-gray-700 hidden"></div>
                                    {{-- Dropoff --}}
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="h-2 w-2 rounded-full bg-red-500 ring-4 ring-red-100 dark:ring-red-900/30">
                                        </div>
                                        <span
                                            class="text-sm font-semibold text-gray-900 dark:text-white">{{ $trip->dropoff_location }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $trip->scheduled_at ? $trip->scheduled_at->format('M d, Y') : 'ASAP' }}
                                    </span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 flex items-center gap-1">
                                        <i class='bx bx-time'></i>
                                        {{ $trip->scheduled_at ? $trip->scheduled_at->format('h:i A') : '' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-amber-100 text-amber-800 border-amber-200 dark:bg-amber-900/30 dark:text-amber-400 dark:border-amber-800',
                                        'active' => 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800',
                                        'completed' => 'bg-emerald-100 text-emerald-800 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800',
                                        'cancelled' => 'bg-red-100 text-red-800 border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800',
                                        'scheduled' => 'bg-purple-100 text-purple-800 border-purple-200 dark:bg-purple-900/30 dark:text-purple-400 dark:border-purple-800',
                                    ];
                                    $statusClass = $statusClasses[$trip->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                @endphp
                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border {{ $statusClass }}">
                                    {{ ucfirst($trip->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="text-sm font-bold text-gray-900 dark:text-white">
                                    RM{{ number_format($trip->total_price, 2) }}
                                </div>
                                <div
                                    class="text-xs mt-1 {{ $trip->payment_status === 'paid' ? 'text-green-600 dark:text-green-400' : 'text-red-500 dark:text-red-400' }} font-medium">
                                    {{ ucfirst($trip->payment_status ?? 'Unpaid') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('customer.trips.show', $trip) }}"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 text-xs font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm">
                                    View
                                    <i class='bx bx-right-arrow-alt text-base'></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div
                                    class="mx-auto h-16 w-16 bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center text-gray-300 dark:text-gray-600 mb-4">
                                    <i class='bx bx-trip text-3xl'></i>
                                </div>
                                <h3 class="text-base font-semibold text-gray-900 dark:text-white">No trips found</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 max-w-sm mx-auto">Get ready for your
                                    first journey! Start by booking a trip with us today.</p>
                                <div class="mt-6">
                                    <a href="{{ route('transport-rates') }}"
                                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all">
                                        <i class='bx bx-plus mr-2'></i>
                                        Book New Trip
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($trips->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/30">
                {{ $trips->links() }}
            </div>
        @endif
    </div>
</x-customer-layout>