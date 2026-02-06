<x-app-layout>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">Corporate Travel Dashboard</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-400">Manage business trips and expenses.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <button type="button"
                class="block rounded-md bg-purple-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-purple-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple-600">Book
                Business Trip</button>
        </div>
    </div>

    <!-- Quick Stats -->
    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <div
            class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 px-4 py-5 shadow sm:p-6 backdrop-blur-xl border border-gray-100 dark:border-gray-700">
            <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Active Trips</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $activeTrips }}</dd>
        </div>
        <div
            class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 px-4 py-5 shadow sm:p-6 backdrop-blur-xl border border-gray-100 dark:border-gray-700">
            <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Total Spend (Month)</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                ${{ number_format($totalSpend, 2) }}</dd>
        </div>
        <div
            class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 px-4 py-5 shadow sm:p-6 backdrop-blur-xl border border-gray-100 dark:border-gray-700">
            <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Pending Approvals</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-yellow-500">{{ $pendingApprovals }}</dd>
        </div>
    </dl>

    <!-- Trip History Table -->
    <div class="mt-8">
        <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white mb-4">Recent Business Trips</h3>
        <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <th scope="col"
                            class="py-3.5 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 sm:pl-6">
                            Employee / Driver</th>
                        <th scope="col"
                            class="px-3 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Route</th>
                        <th scope="col"
                            class="px-3 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Status</th>
                        <th scope="col"
                            class="px-3 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Cost</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                    @forelse ($recentTrips as $trip)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                            <td
                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-white sm:pl-6">
                                <div class="flex items-center gap-x-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($trip->vehicle->driver->name ?? 'Unknown') }}&background=random&color=fff"
                                        alt="" class="h-8 w-8 flex-none rounded-full">
                                    <div class="flex flex-col">
                                        <span>{{ $trip->vehicle->driver->name ?? 'Unassigned' }}</span>
                                        <span class="text-xs text-gray-500">{{ $trip->vehicle->license_plate ?? '' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col">
                                    <span class="truncate max-w-xs">{{ $trip->pickup_address }}</span>
                                    <span class="text-xs text-gray-400">to</span>
                                    <span class="truncate max-w-xs">{{ $trip->dropoff_address }}</span>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm">
                                @php
                                    $statusClasses = [
                                        'completed' => 'bg-green-50 text-green-700 ring-green-600/20',
                                        'active' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
                                        'pending' => 'bg-yellow-50 text-yellow-800 ring-yellow-600/20',
                                        'cancelled' => 'bg-red-50 text-red-700 ring-red-600/20',
                                    ];
                                    $statusClass = $statusClasses[$trip->status] ?? 'bg-gray-50 text-gray-600 ring-gray-500/10';
                                @endphp
                                <span
                                    class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $statusClass }}">
                                    {{ ucfirst($trip->status) }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                ${{ number_format($trip->total_price, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-3 py-4 text-sm text-gray-500 text-center italic">No recent trips
                                found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>