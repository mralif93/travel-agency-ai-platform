<x-public-layout>
    <div
        class="py-24 bg-gray-50 dark:bg-gray-900 min-h-screen flex items-center justify-center transition-colors duration-300">
        <div class="max-w-md w-full px-4 sm:px-6">
            <div
                class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-xl border border-gray-100 dark:border-gray-700 backdrop-blur-xl transition-colors duration-300">
                <div class="text-center mb-8">
                    <h1
                        class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary-600 to-purple-600 dark:from-primary-400 dark:to-purple-400 mb-2">
                        Create Account
                    </h1>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                        Join us to book and manage your trips easily
                    </p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full
                            Name</label>
                        <div class="relative">
                            <input id="name"
                                class="block w-full px-4 py-3 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 transition-all duration-200"
                                type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                                placeholder="John Doe" />
                        </div>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email
                            Address</label>
                        <div class="relative">
                            <input id="email"
                                class="block w-full px-4 py-3 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 transition-all duration-200"
                                type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                                placeholder="example@example.com" />
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone
                            Number</label>
                        <div class="relative">
                            <input id="phone"
                                class="block w-full px-4 py-3 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 transition-all duration-200"
                                type="text" name="phone" value="{{ old('phone') }}" required autocomplete="tel"
                                placeholder="+60123456789" />
                        </div>
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
                        <div class="relative">
                            <input id="password"
                                class="block w-full px-4 py-3 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 transition-all duration-200"
                                type="password" name="password" required autocomplete="new-password"
                                placeholder="••••••••" />
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm
                            Password</label>
                        <div class="relative">
                            <input id="password_confirmation"
                                class="block w-full px-4 py-3 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 transition-all duration-200"
                                type="password" name="password_confirmation" required autocomplete="new-password"
                                placeholder="••••••••" />
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full py-3 px-6 bg-gradient-to-r from-primary-600 to-purple-600 hover:from-primary-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-lg transform transition hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                        Create Account
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Already have an account?
                        <a href="{{ route('login') }}"
                            class="font-medium text-primary-600 dark:text-primary-400 hover:text-primary-500 transition-colors">
                            Log in
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>