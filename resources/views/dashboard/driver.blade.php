<x-app-layout>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">Driver Portal</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-400">View your trip schedule and track earnings.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <span
                class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Online</span>
        </div>
    </div>

    <!-- Earnings Overview -->
    <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <div class="overflow-hidden rounded-lg bg-indigo-600 px-4 py-5 shadow sm:p-6 text-white">
            <dt class="truncate text-sm font-medium text-indigo-100">Today's Earnings</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight">$120.50</dd>
        </div>
        <div
            class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 px-4 py-5 shadow sm:p-6 backdrop-blur-xl border border-gray-100 dark:border-gray-700">
            <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Trips Completed</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">5</dd>
        </div>
        <div
            class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 px-4 py-5 shadow sm:p-6 backdrop-blur-xl border border-gray-100 dark:border-gray-700">
            <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Rating</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">4.9 ★</dd>
        </div>
    </div>

    <!-- Trip Timeline -->
    <div class="mt-8">
        <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white mb-4">Today's Schedule</h3>
        <div class="flow-root bg-white dark:bg-gray-800 shadow rounded-lg px-6 py-6">
            <ul role="list" class="-mb-8">
                <li>
                    <div class="relative pb-8">
                        <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700"
                            aria-hidden="true"></span>
                        <div class="relative flex space-x-3">
                            <div>
                                <span
                                    class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                    <svg class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </div>
                            <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Trip #TR-8821 <a href="#"
                                            class="font-medium text-gray-900 dark:text-white">Airport Dropoff</a></p>
                                </div>
                                <div class="whitespace-nowrap text-right text-sm text-gray-500 dark:text-gray-400">
                                    <time datetime="2020-09-20">08:00 AM</time>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="relative pb-8">
                        <div class="relative flex space-x-3">
                            <div>
                                <span
                                    class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Client Pickup <span
                                            class="font-medium text-gray-900 dark:text-white">Hilton Hotel</span></p>
                                </div>
                                <div class="whitespace-nowrap text-right text-sm text-gray-500 dark:text-gray-400">
                                    <time datetime="2020-09-22">02:30 PM</time>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</x-app-layout>