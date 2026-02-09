<x-app-layout>
    <div class="sm:flex sm:items-center mb-8">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">Add Vehicle</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-400">Add a new vehicle to the fleet.</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
        <form action="{{ route('vehicles.store') }}" method="POST">
            @csrf
            <div class="px-4 py-6 sm:p-8">
                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <!-- Make -->
                    <div class="sm:col-span-3">
                        <label for="make"
                            class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Make</label>
                        <div class="mt-2">
                            <input type="text" name="make" id="make" value="{{ old('make') }}"
                                class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white dark:ring-gray-700"
                                placeholder="Toyota">
                            @error('make')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Model -->
                    <div class="sm:col-span-3">
                        <label for="model"
                            class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Model</label>
                        <div class="mt-2">
                            <input type="text" name="model" id="model" value="{{ old('model') }}"
                                class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white dark:ring-gray-700"
                                placeholder="Hiace">
                            @error('model')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Type -->
                    <div class="sm:col-span-3">
                        <label for="type"
                            class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Type</label>
                        <div class="mt-2 relative">
                            <select id="type" name="type"
                                class="block w-full appearance-none rounded-md border-0 py-2.5 pl-3 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white dark:ring-gray-700">
                                <option value="sedan" {{ old('type') == 'sedan' ? 'selected' : '' }}>Sedan</option>
                                <option value="mpv" {{ old('type') == 'mpv' ? 'selected' : '' }}>MPV</option>
                                <option value="van" {{ old('type') == 'van' ? 'selected' : '' }}>Van</option>
                                <option value="bus" {{ old('type') == 'bus' ? 'selected' : '' }}>Bus</option>
                                <option value="luxury" {{ old('type') == 'luxury' ? 'selected' : '' }}>Luxury</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                <i class='bx bx-chevron-down text-lg'></i>
                            </div>
                            @error('type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- License Plate -->
                    <div class="sm:col-span-3">
                        <label for="license_plate"
                            class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">License
                            Plate</label>
                        <div class="mt-2">
                            <input type="text" name="license_plate" id="license_plate"
                                value="{{ old('license_plate') }}"
                                class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white dark:ring-gray-700">
                            @error('license_plate')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Year -->
                    <div class="sm:col-span-3">
                        <label for="year"
                            class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Year</label>
                        <div class="mt-2">
                            <input type="text" name="year" id="year" value="{{ old('year') }}"
                                class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white dark:ring-gray-700">
                            @error('year')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Capacity -->
                    <div class="sm:col-span-3">
                        <label for="capacity"
                            class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Capacity
                            (Seats)</label>
                        <div class="mt-2">
                            <input type="number" name="capacity" id="capacity" value="{{ old('capacity') }}"
                                class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white dark:ring-gray-700">
                            @error('capacity')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="sm:col-span-3">
                        <label for="status"
                            class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Status</label>
                        <div class="mt-2 relative">
                            <select id="status" name="status"
                                class="block w-full appearance-none rounded-md border-0 py-2.5 pl-3 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white dark:ring-gray-700">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>
                                    Maintenance</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                <i class='bx bx-chevron-down text-lg'></i>
                            </div>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Driver -->
                    <div class="sm:col-span-6">
                        <label for="user_id"
                            class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Assigned
                            Driver</label>
                        <div class="mt-2 relative">
                            <select id="user_id" name="user_id"
                                class="block w-full appearance-none rounded-md border-0 py-2.5 pl-3 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white dark:ring-gray-700">
                                <option value="">Select a Driver</option>
                                @foreach ($drivers as $driver)
                                    <option value="{{ $driver->id }}" {{ old('user_id') == $driver->id ? 'selected' : '' }}>
                                        {{ $driver->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                <i class='bx bx-chevron-down text-lg'></i>
                            </div>
                            @error('user_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>

            <div
                class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 dark:border-gray-700 px-4 py-4 sm:px-8">
                <a href="{{ route('vehicles.index') }}"
                    class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">Cancel</a>
                <button type="submit"
                    class="rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">Save</button>
            </div>
        </form>
    </div>
</x-app-layout>