<x-app-layout>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">Vehicles</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-400">A list of all vehicles, their status, and assigned
                drivers.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <a href="{{ route('vehicles.create') }}"
                class="block rounded-md bg-primary-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">Add
                Vehicle</a>
        </div>
    </div>
    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                            <tr>
                                <th scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 sm:pl-6">
                                    Make & Model</th>
                                <th scope="col"
                                    class="px-3 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    License Plate</th>
                                <th scope="col"
                                    class="px-3 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    Details</th>
                                <th scope="col"
                                    class="px-3 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    Status</th>
                                <th scope="col"
                                    class="px-3 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    Driver</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                            @foreach ($vehicles as $vehicle)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                    <td
                                        class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-white sm:pl-6">
                                        {{ $vehicle->make }} {{ $vehicle->model }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $vehicle->license_plate }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $vehicle->year }} • {{ $vehicle->capacity }} Seats
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
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
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        @if ($vehicle->driver)
                                            <div class="flex items-center gap-x-3">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($vehicle->driver->name) }}&background=random&color=fff&size=24"
                                                    alt="" class="h-6 w-6 rounded-full flex-none">
                                                <!-- Added flex-none -->
                                                <span>{{ $vehicle->driver->name }}</span>
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic">Unassigned</span>
                                        @endif
                                    </td>
                                    <td
                                        class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('vehicles.show', $vehicle) }}"
                                                class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                                                <i class='bx bx-show text-xl'></i><span class="sr-only">View,
                                                    {{ $vehicle->license_plate }}</span>
                                            </a>
                                            <a href="{{ route('vehicles.edit', $vehicle) }}"
                                                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors">
                                                <i class='bx bx-pencil text-xl'></i><span class="sr-only">Edit,
                                                    {{ $vehicle->license_plate }}</span>
                                            </a>
                                            <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST"
                                                class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors"
                                                    onclick="return confirm('Are you sure?')">
                                                    <i class='bx bx-trash text-xl'></i><span class="sr-only">Delete,
                                                        {{ $vehicle->license_plate }}</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-4 px-4 sm:px-6 lg:px-8">
            {{ $vehicles->links() }}
        </div>
    </div>
</x-app-layout>