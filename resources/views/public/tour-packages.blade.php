<x-public-layout>
    <div class="py-16 bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Curated Tour Packages</h1>
                <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Explore our handpicked selection of premium tour packages designed for unforgettable experiences.
                </p>
            </div>

            <!-- Featured Packages -->
            @if($featuredPackages->count() > 0)
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Featured Packages</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($featuredPackages as $package)
                    <a href="{{ route('tour-packages.show', $package) }}" class="group relative rounded-2xl overflow-hidden aspect-[4/3]">
                        <img src="{{ $package->featured_image_url }}" alt="{{ $package->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 text-xs font-semibold bg-amber-500 text-white rounded-full">Featured</span>
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            <span class="text-xs text-gray-300">{{ $package->category_label }} • {{ $package->duration }}</span>
                            <h3 class="text-xl font-bold text-white mt-1">{{ $package->name }}</h3>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-sm text-gray-300"><i class='bx bx-map'></i> {{ $package->destination }}</span>
                                <span class="text-lg font-bold text-white">RM {{ number_format($package->price) }}</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Filter -->
            <div class="mb-8 flex flex-wrap gap-3 items-center">
                <span class="text-sm text-gray-600 dark:text-gray-400">Filter:</span>
                <a href="{{ route('tour-packages') }}" class="px-4 py-2 text-sm font-medium rounded-full {{ !request('category') ? 'bg-primary-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700' }} transition-colors">
                    All
                </a>
                @foreach(['adventure', 'cultural', 'nature', 'beach', 'city', 'culinary'] as $cat)
                <a href="{{ route('tour-packages', ['category' => $cat]) }}" class="px-4 py-2 text-sm font-medium rounded-full {{ request('category') == $cat ? 'bg-primary-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700' }} transition-colors">
                    {{ ucfirst($cat) }}
                </a>
                @endforeach
            </div>

            <!-- Packages Grid -->
            @if($packages->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($packages as $package)
                <a href="{{ route('tour-packages.show', $package) }}" class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700">
                    <div class="relative aspect-video overflow-hidden">
                        <img src="{{ $package->featured_image_url }}" alt="{{ $package->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute top-3 right-3">
                            <span class="px-3 py-1 text-xs font-semibold bg-white/90 dark:bg-gray-800/90 text-gray-900 dark:text-white rounded-full backdrop-blur-sm">
                                {{ $package->category_label }}
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-2">
                            <i class='bx bx-map'></i>
                            <span>{{ $package->destination }}</span>
                            <span>•</span>
                            <span>{{ $package->duration }}</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 line-clamp-1">{{ $package->name }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mb-4">{{ $package->short_description }}</p>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-1 text-xs font-medium rounded {{ $package->difficulty_color === 'green' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : ($package->difficulty_color === 'yellow' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400') }}">
                                    {{ $package->difficulty_label }}
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    <i class='bx bx-user'></i> Max {{ $package->max_pax }}
                                </span>
                            </div>
                            <span class="text-lg font-bold text-primary-600 dark:text-primary-400">RM {{ number_format($package->price) }}</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $packages->links() }}
            </div>
            @else
            <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-2xl">
                <div class="w-20 h-20 mx-auto bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                    <i class='bx bx-map-pin text-4xl text-gray-400'></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No packages available</h3>
                <p class="text-gray-500 dark:text-gray-400">Check back later for exciting tour packages!</p>
            </div>
            @endif
        </div>
    </div>
</x-public-layout>
