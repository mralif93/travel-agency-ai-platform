<x-public-layout>
    <div class="py-24 bg-white dark:bg-gray-900 min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4 transition-colors duration-300">Curated
                    Tour Packages</h1>
                <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto transition-colors duration-300">
                    Explore our handpicked selection of premium tour packages designed for unforgettable experiences.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Placeholder items -->
                @for ($i = 1; $i <= 6; $i++)
                    <div
                        class="group bg-gray-50 dark:bg-gray-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700">
                        <div class="h-48 bg-gray-200 dark:bg-gray-700 w-full animate-pulse"></div>
                        <div class="p-6">
                            <div class="h-6 bg-gray-200 dark:bg-gray-700 rounded w-3/4 mb-4 animate-pulse"></div>
                            <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-full mb-2 animate-pulse"></div>
                            <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-2/3 animate-pulse"></div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</x-public-layout>