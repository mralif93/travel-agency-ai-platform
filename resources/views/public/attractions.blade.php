<x-public-layout>
    <div class="py-16 bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Must-Visit Attractions</h1>
                <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Discover the most popular destinations and hidden gems in the region.
                </p>
            </div>

            <!-- Featured Attractions -->
            @if($featuredAttractions->count() > 0)
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Popular Destinations</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($featuredAttractions as $attraction)
                    <a href="{{ route('attractions.show', $attraction) }}" class="relative group rounded-2xl overflow-hidden aspect-[3/4]">
                        <img src="{{ $attraction->featured_image_url }}" alt="{{ $attraction->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                        <div class="absolute top-3 left-3">
                            <span class="px-2 py-1 text-xs font-semibold bg-amber-500 text-white rounded">Featured</span>
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <div class="flex items-center gap-1 mb-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class='bx {{ $i <= round($attraction->rating) ? 'bxs' : 'bx' }}-star text-amber-400 text-xs'></i>
                                @endfor
                                <span class="text-xs text-gray-300 ml-1">({{ $attraction->reviews_count }})</span>
                            </div>
                            <h3 class="text-white font-semibold line-clamp-1">{{ $attraction->name }}</h3>
                            <p class="text-xs text-gray-300"><i class='bx bx-map'></i> {{ $attraction->location }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Filter -->
            <div class="mb-8 flex flex-wrap gap-3 items-center">
                <span class="text-sm text-gray-600 dark:text-gray-400">Filter:</span>
                <a href="{{ route('attractions') }}" class="px-4 py-2 text-sm font-medium rounded-full {{ !request('category') ? 'bg-emerald-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700' }} transition-colors">
                    All
                </a>
                @foreach(['temple', 'beach', 'mountain', 'park', 'museum', 'island', 'waterfall', 'cave'] as $cat)
                <a href="{{ route('attractions', ['category' => $cat]) }}" class="px-4 py-2 text-sm font-medium rounded-full {{ request('category') == $cat ? 'bg-emerald-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700' }} transition-colors">
                    {{ ucfirst($cat) }}
                </a>
                @endforeach
            </div>

            <!-- Attractions Grid -->
            @if($attractions->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($attractions as $attraction)
                <a href="{{ route('attractions.show', $attraction) }}" class="group bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all border border-gray-100 dark:border-gray-700">
                    <div class="relative aspect-[4/3] overflow-hidden">
                        <img src="{{ $attraction->featured_image_url }}" alt="{{ $attraction->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute top-3 right-3">
                            <span class="px-2 py-1 text-xs font-semibold bg-white/90 dark:bg-gray-800/90 text-gray-900 dark:text-white rounded-full">
                                {{ $attraction->category_label }}
                            </span>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center gap-1 mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class='bx {{ $i <= round($attraction->rating) ? 'bxs' : 'bx' }}-star text-amber-400 text-sm'></i>
                            @endfor
                            <span class="text-xs text-gray-500 dark:text-gray-400 ml-1">({{ $attraction->reviews_count }})</span>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white line-clamp-1 mb-1">{{ $attraction->name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                            <i class='bx bx-map text-xs'></i> {{ $attraction->location }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">{{ $attraction->short_description }}</p>
                        <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
                            @if($attraction->entrance_fee > 0)
                                <span class="text-sm font-medium text-gray-900 dark:text-white">RM {{ number_format($attraction->entrance_fee, 2) }}</span>
                            @else
                                <span class="text-sm font-medium text-green-600 dark:text-green-400">Free Entry</span>
                            @endif
                            <span class="text-xs text-gray-500 dark:text-gray-400">View Details →</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $attractions->links() }}
            </div>
            @else
            <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-2xl">
                <div class="w-20 h-20 mx-auto bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                    <i class='bx bx-landscape text-4xl text-gray-400'></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No attractions available</h3>
                <p class="text-gray-500 dark:text-gray-400">Check back later for exciting places to visit!</p>
            </div>
            @endif
        </div>
    </div>
</x-public-layout>
