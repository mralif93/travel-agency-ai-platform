<x-app-layout>
    <div class="sm:flex sm:items-center mb-8">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">Create User</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-400">Add a new user to the system.</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
        <div class="px-4 py-6 sm:p-8">
            <form method="post" action="{{ route('users.store') }}">
                @csrf

                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="name" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Full
                            Name</label>
                        <div class="mt-2">
                            <input type="text" name="name" id="name" autocomplete="name" value="{{ old('name') }}"
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
                            <input type="email" name="email" id="email" autocomplete="email" value="{{ old('email') }}"
                                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 dark:text-white dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="role"
                            class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Role</label>
                        <div class="mt-2 relative">
                            @if(auth()->user()->role === 'company')
                                <input type="hidden" name="role" value="driver">
                                <input type="text" disabled value="Driver (Auto-assigned)"
                                    class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-500 bg-gray-100 dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 sm:text-sm sm:leading-6">
                            @else
                                <select id="role" name="role" autocomplete="role-name"
                                    style="-webkit-appearance: none; -moz-appearance: none; appearance: none;"
                                    class="block w-full appearance-none bg-none rounded-lg border-0 py-2.5 pl-3 pr-10 text-gray-900 dark:text-white dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6">
                                    <option value="superadmin">Super Admin</option>
                                    <option value="admin">Admin</option>
                                    <option value="driver">Driver</option>
                                    <option value="company">Company</option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        @error('role')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    @if(auth()->user()->role !== 'company')
                        <div class="sm:col-span-3">
                            <label for="company_id"
                                class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Company</label>
                            <div class="mt-2 relative">
                                <select id="company_id" name="company_id"
                                    class="block w-full rounded-lg border-0 py-2.5 pl-3 pr-10 text-gray-900 dark:text-white dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 sm:text-sm sm:leading-6">
                                    <option value="">None</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

                    <div class="sm:col-span-3">
                        <!-- Empty for layout balance -->
                    </div>

                    <div class="sm:col-span-3">
                        <label for="password"
                            class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Password</label>
                        <div class="mt-2">
                            <input type="password" name="password" id="password" autocomplete="new-password"
                                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 dark:text-white dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="password_confirmation"
                            class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Confirm
                            Password</label>
                        <div class="mt-2">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                autocomplete="new-password"
                                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 dark:text-white dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                </div>
        </div>

        <div
            class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 dark:border-gray-700 px-4 py-4 sm:px-8">
            <a href="{{ route('users.index') }}"
                class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">Cancel</a>
            <button type="submit"
                class="rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">Save</button>
        </div>
        </form>
    </div>
    </div>
</x-app-layout>