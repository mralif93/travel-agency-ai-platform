<x-app-layout>
    <div class="sm:flex sm:items-center mb-8">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">Edit Customer</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-400">Update customer information.</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
        <div class="px-4 py-6 sm:p-8">
            <form method="post" action="{{ route('customers.update', $customer) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="name" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Full
                            Name</label>
                        <div class="mt-2">
                            <input type="text" name="name" id="name" autocomplete="name"
                                value="{{ old('name', $customer->name) }}"
                                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 dark:text-white dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                        </div>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="email"
                            class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Email</label>
                        <div class="mt-2">
                            <input type="email" name="email" id="email" autocomplete="email"
                                value="{{ old('email', $customer->email) }}"
                                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 dark:text-white dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="phone"
                            class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Phone</label>
                        <div class="mt-2">
                            <input type="text" name="phone" id="phone" autocomplete="tel"
                                value="{{ old('phone', $customer->phone) }}"
                                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 dark:text-white dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                        </div>
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-6">
                        <label for="address"
                            class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Address</label>
                        <div class="mt-2">
                            <textarea id="address" name="address" rows="3"
                                class="block w-full rounded-lg border-0 py-2.5 text-gray-900 dark:text-white dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 sm:text-sm sm:leading-6">{{ old('address', $customer->address) }}</textarea>
                        </div>
                        @error('address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
        </div>

        <div
            class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 dark:border-gray-700 px-4 py-4 sm:px-8">
            <a href="{{ route('customers.index') }}"
                class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">Cancel</a>
            <button type="submit"
                class="rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">Save</button>
        </div>
        </form>
    </div>
    </div>
</x-app-layout>