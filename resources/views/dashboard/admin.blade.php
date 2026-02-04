<x-app-layout>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">Agency Operations</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-400">Manage bookings, fleet, and agency performance.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <button type="button" class="block rounded-md bg-primary-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">New Booking</button>
        </div>
    </div>

    <!-- Stats Grid -->
    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 px-4 py-5 shadow sm:p-6 backdrop-blur-xl border border-gray-100 dark:border-gray-700">
            <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Total Bookings</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">142</dd>
        </div>
        <div class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 px-4 py-5 shadow sm:p-6 backdrop-blur-xl border border-gray-100 dark:border-gray-700">
            <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Revenue (Today)</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">$3,240</dd>
        </div>
        <div class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 px-4 py-5 shadow sm:p-6 backdrop-blur-xl border border-gray-100 dark:border-gray-700">
            <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Active Drivers</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-green-600">8/10</dd>
        </div>
         <div class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 px-4 py-5 shadow sm:p-6 backdrop-blur-xl border border-gray-100 dark:border-gray-700">
            <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Pending Review</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-yellow-500">3</dd>
        </div>
    </dl>

    <div class="mt-8">
        <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white">Recent Bookings</h3>
        <ul role="list" class="mt-4 divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800 shadow rounded-lg px-4 sm:px-6">
            <li class="py-4">
                <div class="flex items-center gap-x-3">
                    <img class="h-6 w-6 flex-none rounded-full" src="https://ui-avatars.com/api/?name=John+Doe&background=random" alt="">
                    <h3 class="flex-auto truncate text-sm font-semibold leading-6 text-gray-900 dark:text-white">John Doe</h3>
                    <time datetime="2023-01-23T11:00" class="flex-none text-xs text-gray-500 dark:text-gray-400">1h ago</time>
                </div>
                <p class="mt-3 truncate text-sm text-gray-500 dark:text-gray-400">Airport Transfer • Standard Sedan</p>
            </li>
             <li class="py-4">
                <div class="flex items-center gap-x-3">
                    <img class="h-6 w-6 flex-none rounded-full" src="https://ui-avatars.com/api/?name=Jane+Smith&background=random" alt="">
                    <h3 class="flex-auto truncate text-sm font-semibold leading-6 text-gray-900 dark:text-white">Jane Smith</h3>
                    <time datetime="2023-01-23T09:00" class="flex-none text-xs text-gray-500 dark:text-gray-400">3h ago</time>
                </div>
                <p class="mt-3 truncate text-sm text-gray-500 dark:text-gray-400">City Tour • Luxury Van</p>
            </li>
        </ul>
    </div>
</x-app-layout>