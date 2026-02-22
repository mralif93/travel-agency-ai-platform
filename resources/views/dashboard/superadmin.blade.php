<x-app-layout>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">System Overview</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-400">A snapshot of platform performance and key metrics.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <a href="{{ route('orders.index') }}" class="block rounded-md bg-primary-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">View All Orders</a>
        </div>
    </div>

    <!-- Stats Grid -->
    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-5">
        <div class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 px-4 py-5 shadow sm:p-6 backdrop-blur-xl border border-gray-100 dark:border-gray-700">
            <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Total Staff</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $totalUsers }}</dd>
        </div>
        <div class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 px-4 py-5 shadow sm:p-6 backdrop-blur-xl border border-gray-100 dark:border-gray-700">
            <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Total Customers</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $totalCustomers }}</dd>
        </div>
        <div class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 px-4 py-5 shadow sm:p-6 backdrop-blur-xl border border-gray-100 dark:border-gray-700">
            <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">System Status</dt>
            <dd class="mt-1 text-xl font-semibold tracking-tight text-green-600">Operational</dd>
        </div>
        <div class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 px-4 py-5 shadow sm:p-6 backdrop-blur-xl border border-gray-100 dark:border-gray-700">
            <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">New Signups (24h)</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $newSignups24h }}</dd>
        </div>
        <div class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 px-4 py-5 shadow sm:p-6 backdrop-blur-xl border border-gray-100 dark:border-gray-700">
            <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Total Revenue</dt>
            <dd class="mt-1 text-2xl font-semibold tracking-tight text-primary-600">RM {{ number_format($totalRevenue, 2) }}</dd>
        </div>
    </dl>

    <!-- Recent Activity Table -->
    <div class="mt-8">
        <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white mb-4">Recent Activity</h3>
        <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 sm:pl-6">User</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Action</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Route</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Time</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6"><span class="sr-only">View</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                    @forelse($recentActivity as $activity)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-white sm:pl-6">
                            <div class="flex items-center gap-x-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($activity->user) }}&background=6366f1&color=fff" alt="" class="h-8 w-8 flex-none rounded-full">
                                <span>{{ $activity->user }}</span>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $activity->action }}</td>
                        <td class="px-3 py-4 text-sm text-gray-500 dark:text-gray-400 max-w-xs truncate">{{ $activity->order->pickup_address ?? '-' }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $activity->time }}</td>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <a href="{{ route('orders.show', $activity->order->id) }}" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">View<span class="sr-only">, {{ $activity->user }}</span></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center text-gray-500 dark:text-gray-400">No recent activity</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
