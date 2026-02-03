<x-guest-layout>
    <div class="mb-8 text-center">
        <h1
            class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-400 dark:to-purple-400">
            Welcome Back
        </h1>
        <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">
            Sign in to access your dashboard
        </p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Email</label>
            <div class="mt-1 relative">
                <input id="email"
                    class="block w-full px-4 py-3 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-200"
                    type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            </div>
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Password</label>
            <div class="mt-1 relative">
                <input id="password"
                    class="block w-full px-4 py-3 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-200"
                    type="password" name="password" required autocomplete="current-password" />
            </div>
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox"
                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-600 text-indigo-600 shadow-sm focus:ring-indigo-500 transition-colors duration-200"
                    name="remember">
                <span
                    class="ms-2 text-sm text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-200 transition-colors duration-200">Remember
                    me</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit"
                class="w-full inline-flex justify-center items-center px-4 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest shadow-lg transform transition hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                Log in
            </button>
        </div>
    </form>
</x-guest-layout>