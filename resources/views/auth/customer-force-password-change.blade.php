<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Glossy Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-purple-500/20 via-indigo-500/20 to-blue-500/20 dark:from-purple-900/40 dark:via-indigo-900/40 dark:to-blue-900/40"></div>
        <div class="absolute inset-0 backdrop-blur-3xl"></div>
        
        <!-- Decorative Circles -->
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-400/30 dark:bg-purple-600/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-400/30 dark:bg-indigo-600/20 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-blue-400/20 dark:bg-blue-600/10 rounded-full blur-3xl"></div>
        
        <div class="relative max-w-md w-full space-y-8">
            <div class="text-center">
                <div class="mx-auto w-20 h-20 bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl flex items-center justify-center mb-6 shadow-2xl shadow-amber-500/30 rotate-3">
                    <i class='bx bx-lock-alt text-4xl text-white'></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Update Your Password</h2>
                <p class="mt-3 text-base text-gray-600 dark:text-gray-300">
                    For security purposes, please create a new password before continuing.
                </p>
            </div>

            <form method="POST" action="{{ route('customer.password.change.update') }}" class="mt-8 space-y-6 bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl p-8 rounded-2xl shadow-2xl border border-white/20 dark:border-gray-700/50">
                @csrf
                @method('PATCH')

                <div class="space-y-5">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">New Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class='bx bx-lock text-gray-400 text-lg'></i>
                            </div>
                            <input id="password" name="password" type="password" required
                                class="appearance-none block w-full pl-11 pr-4 py-3.5 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white rounded-xl bg-white/50 dark:bg-gray-700/50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all placeholder-gray-400"
                                placeholder="Enter new password">
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                <i class='bx bx-error-circle'></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class='bx bx-check-shield text-gray-400 text-lg'></i>
                            </div>
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                class="appearance-none block w-full pl-11 pr-4 py-3.5 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white rounded-xl bg-white/50 dark:bg-gray-700/50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all placeholder-gray-400"
                                placeholder="Confirm new password">
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/30 dark:to-orange-900/30 border border-amber-200/50 dark:border-amber-700/50 rounded-xl p-4">
                    <p class="text-sm text-amber-800 dark:text-amber-200 flex items-start gap-2">
                        <i class='bx bx-info-circle text-lg flex-shrink-0 mt-0.5'></i>
                        <span>Password must be at least <strong>8 characters</strong> long and different from your current password.</span>
                    </p>
                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-3.5 px-4 text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all shadow-lg shadow-purple-500/30 hover:shadow-xl hover:shadow-purple-500/40 active:scale-[0.98]">
                        <i class='bx bx-check mr-2 text-lg'></i>
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
