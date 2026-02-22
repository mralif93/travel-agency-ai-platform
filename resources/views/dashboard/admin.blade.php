<x-app-layout>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">Agency Operations</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-400">Manage bookings, fleet, and agency performance.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <a href="{{ route('orders.create') }}" class="block rounded-md bg-primary-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">New Booking</a>
        </div>
    </div>

    <!-- Stats Grid -->
    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 px-4 py-5 shadow sm:p-6 backdrop-blur-xl border border-gray-100 dark:border-gray-700">
            <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Total Bookings</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $totalBookings }}</dd>
        </div>
        <div class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 px-4 py-5 shadow sm:p-6 backdrop-blur-xl border border-gray-100 dark:border-gray-700">
            <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Revenue (Today)</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">RM {{ number_format($revenueToday, 2) }}</dd>
        </div>
        <div class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 px-4 py-5 shadow sm:p-6 backdrop-blur-xl border border-gray-100 dark:border-gray-700">
            <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Active Drivers</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-green-600">{{ $activeDrivers }}/{{ $totalDrivers }}</dd>
        </div>
         <div class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 px-4 py-5 shadow sm:p-6 backdrop-blur-xl border border-gray-100 dark:border-gray-700">
            <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Pending Review</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-yellow-500">{{ $pendingReview }}</dd>
        </div>
    </dl>

    <div class="mt-8">
        <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white">Recent Bookings</h3>
        <ul role="list" class="mt-4 divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800 shadow rounded-lg px-4 sm:px-6">
            @forelse($recentBookings as $booking)
            <li class="py-4">
                <div class="flex items-center gap-x-3">
                    <img class="h-6 w-6 flex-none rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($booking->customer?->name ?? 'Guest') }}&background=random" alt="">
                    <h3 class="flex-auto truncate text-sm font-semibold leading-6 text-gray-900 dark:text-white">{{ $booking->customer?->name ?? 'Guest' }}</h3>
                    <time class="flex-none text-xs text-gray-500 dark:text-gray-400">{{ $booking->created_at->diffForHumans() }}</time>
                </div>
                <p class="mt-3 truncate text-sm text-gray-500 dark:text-gray-400">
                    {{ $booking->pickup_address }} → {{ $booking->dropoff_address }} • {{ ucfirst($booking->vehicle?->type ?? 'Vehicle') }}
                </p>
            </li>
            @empty
            <li class="py-4 text-center text-gray-500 dark:text-gray-400">No recent bookings</li>
            @endforelse
        </ul>
    </div>
</x-app-layout>
