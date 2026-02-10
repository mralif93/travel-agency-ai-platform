<x-customer-layout>
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h2
                class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:truncate sm:text-3xl sm:tracking-tight">
                Profile Settings
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Update your account's profile information and secure your account.
            </p>
        </div>
    </div>

    <form method="post" action="{{ route('customer.profile.update') }}">
        @csrf
        @method('patch')

        <div class="space-y-12">
            <!-- Profile Information -->
            <div class="grid grid-cols-1 gap-x-8 gap-y-8 md:grid-cols-3">
                <div class="px-4 sm:px-0">
                    <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Profile Information</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">Use a permanent address where you
                        can receive mail.</p>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700/40 sm:rounded-xl md:col-span-2">
                    <div class="px-4 py-6 sm:p-8">
                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <label for="name"
                                    class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Name</label>
                                <div class="mt-2">
                                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                        required autofocus autocomplete="name"
                                        class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-700 dark:text-white dark:ring-gray-600 dark:focus:ring-primary-500">
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-4">
                                <label for="email"
                                    class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Email
                                    address</label>
                                <div class="mt-2">
                                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}"
                                        required autocomplete="username"
                                        class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-700 dark:text-white dark:ring-gray-600 dark:focus:ring-primary-500">
                                    @error('email')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Password -->
            <div class="grid grid-cols-1 gap-x-8 gap-y-8 md:grid-cols-3">
                <div class="px-4 sm:px-0">
                    <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Update Password</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">Ensure your account is using a
                        long, random password to stay secure.</p>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700/40 sm:rounded-xl md:col-span-2">
                    <div class="px-4 py-6 sm:p-8">
                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <label for="current_password"
                                    class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Current
                                    Password</label>
                                <div class="mt-2">
                                    <input id="current_password" name="current_password" type="password"
                                        autocomplete="current-password"
                                        class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-700 dark:text-white dark:ring-gray-600 dark:focus:ring-primary-500">
                                    @error('current_password')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-4">
                                <label for="password"
                                    class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">New
                                    Password</label>
                                <div class="mt-2">
                                    <input id="password" name="password" type="password" autocomplete="new-password"
                                        class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-700 dark:text-white dark:ring-gray-600 dark:focus:ring-primary-500">
                                    @error('password')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-4">
                                <label for="password_confirmation"
                                    class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Confirm
                                    Password</label>
                                <div class="mt-2">
                                    <input id="password_confirmation" name="password_confirmation" type="password"
                                        autocomplete="new-password"
                                        class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-700 dark:text-white dark:ring-gray-600 dark:focus:ring-primary-500">
                                    @error('password_confirmation')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex items-center gap-x-6 border-t border-gray-900/10 dark:border-gray-700 px-4 py-4 sm:px-8">
                        <button type="submit"
                            class="rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">Save</button>


                    </div>
                </div>
            </div>
        </div>
    </form>
</x-customer-layout>