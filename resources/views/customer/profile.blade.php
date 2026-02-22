<x-customer-layout>
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <nav class="flex items-center gap-x-2 text-sm text-gray-500 dark:text-gray-400 mb-2">
                    <a href="{{ route('dashboard.customer') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Dashboard</a>
                    <i class='bx bx-chevron-right text-gray-300 dark:text-gray-600'></i>
                    <span class="text-gray-900 dark:text-white font-medium">Profile</span>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Profile Settings</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Manage your account settings and preferences.</p>
            </div>
        </div>

        <!-- Profile Overview Card -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-primary-600 to-indigo-600 p-6 sm:p-8 shadow-xl">
            <div class="absolute inset-0 bg-grid-white/10"></div>
            <div class="absolute -top-24 -right-24 w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>
            
            <div class="relative flex flex-col sm:flex-row items-center sm:items-start gap-6">
                <div class="relative">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-white text-3xl sm:text-4xl font-bold ring-4 ring-white/20 shadow-xl">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 rounded-full bg-green-500 border-4 border-white dark:border-gray-900 flex items-center justify-center">
                        <i class='bx bx-check text-white text-sm'></i>
                    </div>
                </div>
                <div class="text-center sm:text-left">
                    <h2 class="text-xl sm:text-2xl font-bold text-white">{{ $user->name }}</h2>
                    <p class="text-primary-100 mt-1">{{ $user->email }}</p>
                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mt-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/20 text-white backdrop-blur-sm">
                            <i class='bx bx-calendar mr-1'></i>
                            Joined {{ $user->created_at->format('M Y') }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/20 text-white backdrop-blur-sm">
                            <i class='bx bx-shield-quarter mr-1'></i>
                            Verified Account
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <form method="post" action="{{ route('customer.profile.update') }}">
            @csrf
            @method('patch')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Personal Information -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700/50 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                                    <i class='bx bx-user text-primary-600 dark:text-primary-400 text-lg'></i>
                                </div>
                                <div>
                                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">Personal Information</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Update your personal details</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                        required class="block w-full rounded-xl border-0 px-4 py-3 text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700/50 ring-1 ring-inset ring-gray-200 dark:ring-gray-600 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-500 sm:text-sm transition-all">
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                            <i class='bx bx-error-circle'></i> {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                        required class="block w-full rounded-xl border-0 px-4 py-3 text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700/50 ring-1 ring-inset ring-gray-200 dark:ring-gray-600 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-500 sm:text-sm transition-all">
                                    @error('email')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                            <i class='bx bx-error-circle'></i> {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone Number</label>
                                    <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                                        class="block w-full rounded-xl border-0 px-4 py-3 text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700/50 ring-1 ring-inset ring-gray-200 dark:ring-gray-600 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-500 sm:text-sm transition-all" placeholder="+60 12 345 6789">
                                    @error('phone')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                            <i class='bx bx-error-circle'></i> {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Address</label>
                                    <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}"
                                        class="block w-full rounded-xl border-0 px-4 py-3 text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700/50 ring-1 ring-inset ring-gray-200 dark:ring-gray-600 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-500 sm:text-sm transition-all" placeholder="Your address">
                                    @error('address')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                            <i class='bx bx-error-circle'></i> {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Password Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700/50 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                                    <i class='bx bx-lock text-amber-600 dark:text-amber-400 text-lg'></i>
                                </div>
                                <div>
                                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">Change Password</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Keep your account secure</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6 space-y-4">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Password</label>
                                <input type="password" name="current_password" id="current_password"
                                    class="block w-full rounded-xl border-0 px-4 py-3 text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700/50 ring-1 ring-inset ring-gray-200 dark:ring-gray-600 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-500 sm:text-sm transition-all" placeholder="••••••••">
                                @error('current_password')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                        <i class='bx bx-error-circle'></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">New Password</label>
                                <input type="password" name="password" id="password"
                                    class="block w-full rounded-xl border-0 px-4 py-3 text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700/50 ring-1 ring-inset ring-gray-200 dark:ring-gray-600 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-500 sm:text-sm transition-all" placeholder="••••••••">
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                        <i class='bx bx-error-circle'></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="block w-full rounded-xl border-0 px-4 py-3 text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700/50 ring-1 ring-inset ring-gray-200 dark:ring-gray-600 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-500 sm:text-sm transition-all" placeholder="••••••••">
                            </div>
                        </div>
                    </div>

                    <!-- Save Button Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700/50 p-6">
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-xl shadow-sm transition-all hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <i class='bx bx-save text-lg'></i>
                            Save Changes
                        </button>
                        <p class="mt-3 text-xs text-center text-gray-500 dark:text-gray-400">
                            Make sure to save your changes before leaving this page.
                        </p>
                    </div>

                    <!-- Security Tips -->
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-800/50 rounded-2xl p-5 border border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                            <i class='bx bx-info-circle text-primary-500'></i>
                            Security Tips
                        </h4>
                        <ul class="space-y-2 text-xs text-gray-600 dark:text-gray-400">
                            <li class="flex items-start gap-2">
                                <i class='bx bx-check text-green-500 mt-0.5'></i>
                                Use a strong, unique password
                            </li>
                            <li class="flex items-start gap-2">
                                <i class='bx bx-check text-green-500 mt-0.5'></i>
                                Never share your login credentials
                            </li>
                            <li class="flex items-start gap-2">
                                <i class='bx bx-check text-green-500 mt-0.5'></i>
                                Keep your contact info updated
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-customer-layout>
