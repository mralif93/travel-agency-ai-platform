<x-app-layout>
    <div class="sm:flex sm:items-center mb-8">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">Vehicle Details</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-400">View detailed information about the vehicle.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <a href="{{ route('vehicles.edit', $vehicle) }}"
                class="block rounded-md bg-primary-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                <i class='bx bx-pencil align-middle mr-1'></i>Edit Vehicle
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
        <div class="px-4 py-6 sm:p-0">
            <dl class="divide-y divide-gray-100 dark:divide-gray-700">
                <!-- Make & Model -->
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Make & Model</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                        {{ $vehicle->make }} {{ $vehicle->model }}
                    </dd>
                </div>

                <!-- License Plate -->
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">License Plate</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                        {{ $vehicle->license_plate }}
                    </dd>
                </div>

                <!-- Year -->
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Year</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                        {{ $vehicle->year }}
                    </dd>
                </div>

                <!-- Capacity -->
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Capacity</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                        {{ $vehicle->capacity }} Seats
                    </dd>
                </div>

                <!-- Status -->
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Status</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                        @php
                            $statusClasses = [
                                'active' => 'bg-green-50 text-green-700 ring-green-600/20',
                                'maintenance' => 'bg-yellow-50 text-yellow-800 ring-yellow-600/20',
                                'inactive' => 'bg-gray-50 text-gray-600 ring-gray-500/10',
                            ];
                            $statusClass = $statusClasses[$vehicle->status] ?? $statusClasses['inactive'];
                        @endphp
                        <span
                            class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $statusClass }}">
                            {{ ucfirst($vehicle->status) }}
                        </span>
                    </dd>
                </div>

                <!-- Assigned Driver -->
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Assigned Driver</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                        @if ($vehicle->driver)
                            <div class="flex items-center gap-x-2">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($vehicle->driver->name) }}&background=random&color=fff&size=24"
                                    alt="" class="h-6 w-6 rounded-full flex-none">
                                <span>{{ $vehicle->driver->name }}</span>
                                <a href="{{ route('users.show', $vehicle->driver) }}"
                                    class="text-primary-600 hover:text-primary-500 ml-2 text-xs">View Driver</a>
                            </div>
                        @else
                            <span class="text-gray-400 italic">Unassigned</span>
                        @endif
                    </dd>
                </div>

                <!-- Registration Date -->
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Added On</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                        {{ $vehicle->created_at->format('M d, Y') }}
                    </dd>
                </div>
            </dl>
        </div>
        <div
            class="bg-gray-50 dark:bg-gray-800/50 px-4 py-4 sm:px-8 border-t border-gray-100 dark:border-gray-700 flex justify-end">
            <a href="{{ route('vehicles.index') }}"
                class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white flex items-center">
                <i class='bx bx-arrow-back mr-1'></i>Back to Vehicles</a>
        </div>
    </div>
</x-app-layout>