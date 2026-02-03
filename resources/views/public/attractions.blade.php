<x-public-layout>
    <div class="py-24 bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4 transition-colors duration-300">
                    Must-Visit Attractions</h1>
                <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto transition-colors duration-300">
                    Discover the most popular destinations and hidden gems in the region.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Placeholder items -->
                @for ($i = 1; $i <= 4; $i++)
                    <div class="relative group rounded-2xl overflow-hidden aspect-[3/4]">
                        <div class="absolute inset-0 bg-gray-200 dark:bg-gray-700 animate-pulse"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-6">
                            <div class="h-6 bg-gray-500/50 rounded w-32 mb-2 animate-pulse"></div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</x-public-layout>