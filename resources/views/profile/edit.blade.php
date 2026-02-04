<x-app-layout>
    <div class="sm:flex sm:items-center mb-8">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">Profile Settings</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-400">Update your account information and secure your
                account.</p>
        </div>
    </div>

    @if (session('status') === 'profile-updated')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                Swal.fire({
                    icon: 'success',
                    title: 'Saved!',
                    text: 'Your profile has been updated.',
                    timer: 2000,
                    showConfirmButton: false,
                    background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#fff',
                    color: document.documentElement.classList.contains('dark') ? '#fff' : '#1f2937'
                });
            });
        </script>
    @endif

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 gap-x-8 gap-y-8 lg:grid-cols-2">
            <!-- Profile Information -->
            <div
                class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2 lg:col-span-1">
                <div class="px-4 py-6 sm:p-8">
                    <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Personal Information
                    </h2>
                    <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-gray-400">Use a permanent address where you
                        can
                        receive mail.</p>

                    <div class="mt-6 space-y-6">
                        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-full">
                                <label for="name"
                                    class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Full
                                    Name</label>
                                <div class="mt-2">
                                    <input type="text" name="name" id="name" autocomplete="name"
                                        value="{{ old('name', $user->name) }}"
                                        class="block w-full rounded-lg border-0 py-2.5 text-gray-900 dark:text-white dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-full">
                                <label for="email"
                                    class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Email
                                    address</label>
                                <div class="mt-2">
                                    <input type="email" name="email" id="email" autocomplete="email"
                                        value="{{ old('email', $user->email) }}"
                                        class="block w-full rounded-lg border-0 py-2.5 text-gray-900 dark:text-white dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Password -->
            <div
                class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2 lg:col-span-1">
                <div class="px-4 py-6 sm:p-8">
                    <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Change Password</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-gray-400">Ensure your account is using a
                        long,
                        random password to stay secure.</p>

                    <div class="mt-6 space-y-6">
                        <div class="sm:col-span-full">
                            <label for="current_password"
                                class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Current
                                Password</label>
                            <div class="mt-2">
                                <input type="password" name="current_password" id="current_password"
                                    autocomplete="current-password"
                                    class="block w-full rounded-lg border-0 py-2.5 text-gray-900 dark:text-white dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                            @error('current_password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-full">
                            <label for="password"
                                class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">New
                                Password</label>
                            <div class="mt-2">
                                <input type="password" name="password" id="password" autocomplete="new-password"
                                    class="block w-full rounded-lg border-0 py-2.5 text-gray-900 dark:text-white dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-full">
                            <label for="password_confirmation"
                                class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Confirm
                                Password</label>
                            <div class="mt-2">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    autocomplete="new-password"
                                    class="block w-full rounded-lg border-0 py-2.5 text-gray-900 dark:text-white dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 dark:border-gray-700 px-4 py-4 sm:px-8">
                    <button type="submit"
                        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save
                        Changes</button>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>