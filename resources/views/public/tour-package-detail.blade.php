<x-public-layout>
    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">
        <div class="relative h-[50vh] min-h-[400px] overflow-hidden">
            <img src="{{ $tourPackage->featured_image_url }}" alt="{{ $tourPackage->name }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-8 lg:p-12">
                <div class="max-w-7xl mx-auto">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="px-3 py-1 text-xs font-semibold bg-primary-600 text-white rounded-full">{{ $tourPackage->category_label }}</span>
                        @if($tourPackage->is_featured)
                        <span class="px-3 py-1 text-xs font-semibold bg-amber-500 text-white rounded-full">Featured</span>
                        @endif
                    </div>
                    <h1 class="text-4xl lg:text-5xl font-bold text-white mb-4">{{ $tourPackage->name }}</h1>
                    <div class="flex flex-wrap items-center gap-4 text-gray-300">
                        <span class="flex items-center gap-1.5"><i class='bx bx-map'></i> {{ $tourPackage->destination }}</span>
                        <span class="flex items-center gap-1.5"><i class='bx bx-time'></i> {{ $tourPackage->duration }}</span>
                        <span class="flex items-center gap-1.5"><i class='bx bx-user'></i> Max {{ $tourPackage->max_pax }} Pax</span>
                        <span class="px-2.5 py-1 text-xs font-medium rounded {{ $tourPackage->difficulty_color === 'green' ? 'bg-green-500/20 text-green-300' : ($tourPackage->difficulty_color === 'yellow' ? 'bg-yellow-500/20 text-yellow-300' : 'bg-red-500/20 text-red-300') }}">{{ $tourPackage->difficulty_label }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 lg:p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">About This Tour</h2>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">{{ $tourPackage->short_description }}</p>
                    </div>

                    @if(!empty($tourPackage->itinerary))
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 lg:p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <i class='bx bx-calendar-event text-primary-600'></i>
                            Day-by-Day Itinerary
                        </h2>
                        <div class="space-y-6">
                            @foreach($tourPackage->itinerary as $index => $day)
                            <div class="relative pl-8">
                                <div class="absolute left-0 top-0 w-6 h-6 rounded-full bg-primary-600 text-white text-xs flex items-center justify-center font-bold">
                                    {{ $index + 1 }}
                                </div>
                                @if(!$loop->last)
                                <div class="absolute left-[11px] top-6 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-700"></div>
                                @endif
                                <div class="pb-6">
                                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Day {{ $index + 1 }}: {{ $day['title'] ?? 'Activity' }}</h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">{{ $day['description'] ?? '' }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 lg:p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Full Description</h2>
                        <div class="prose prose-gray dark:prose-invert max-w-none">
                            {!! nl2br(e($tourPackage->description)) !!}
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if(!empty($tourPackage->inclusions))
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                <i class='bx bx-check-circle text-green-500'></i>
                                Inclusions
                            </h2>
                            <ul class="space-y-3">
                                @foreach($tourPackage->inclusions as $inclusion)
                                <li class="flex items-start gap-3 text-gray-600 dark:text-gray-400">
                                    <i class='bx bx-check text-green-500 text-lg mt-0.5 shrink-0'></i>
                                    <span>{{ $inclusion }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if(!empty($tourPackage->exclusions))
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                <i class='bx bx-x-circle text-red-500'></i>
                                Exclusions
                            </h2>
                            <ul class="space-y-3">
                                @foreach($tourPackage->exclusions as $exclusion)
                                <li class="flex items-start gap-3 text-gray-600 dark:text-gray-400">
                                    <i class='bx bx-x text-red-500 text-lg mt-0.5 shrink-0'></i>
                                    <span>{{ $exclusion }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="sticky top-8 space-y-6">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                            <div class="text-center mb-6">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Starting from</span>
                                <div class="text-4xl font-bold text-primary-600 dark:text-primary-400">RM {{ number_format($tourPackage->price) }}</div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">per person</span>
                            </div>

                            <div class="space-y-4 mb-6">
                                <div class="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700">
                                    <span class="text-gray-600 dark:text-gray-400 flex items-center gap-2"><i class='bx bx-map'></i> Destination</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $tourPackage->destination }}</span>
                                </div>
                                <div class="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700">
                                    <span class="text-gray-600 dark:text-gray-400 flex items-center gap-2"><i class='bx bx-time'></i> Duration</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $tourPackage->duration }}</span>
                                </div>
                                <div class="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700">
                                    <span class="text-gray-600 dark:text-gray-400 flex items-center gap-2"><i class='bx bx-user'></i> Max Pax</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $tourPackage->max_pax }} people</span>
                                </div>
                                <div class="flex items-center justify-between py-3">
                                    <span class="text-gray-600 dark:text-gray-400 flex items-center gap-2"><i class='bx bx-bar-chart-alt-2'></i> Difficulty</span>
                                    <span class="px-2.5 py-1 text-xs font-medium rounded {{ $tourPackage->difficulty_color === 'green' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : ($tourPackage->difficulty_color === 'yellow' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400') }}">{{ $tourPackage->difficulty_label }}</span>
                                </div>
                            </div>

                            <a href="{{ route('transport-rates', ['destination' => $tourPackage->destination]) }}" class="w-full block text-center px-6 py-4 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl transition-colors shadow-lg">
                                <i class='bx bx-calendar-check mr-2'></i>
                                Book Now
                            </a>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Need Help?</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Contact our travel experts for personalized assistance.</p>
                            <a href="{{ route('contact') }}" class="text-primary-600 dark:text-primary-400 text-sm font-medium hover:underline">
                                Contact Us <i class='bx bx-right-arrow-alt'></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @if($relatedPackages->count() > 0)
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">Related Packages</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($relatedPackages as $package)
                    <a href="{{ route('tour-packages.show', $package) }}" class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700">
                        <div class="relative aspect-video overflow-hidden">
                            <img src="{{ $package->featured_image_url }}" alt="{{ $package->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute top-3 right-3">
                                <span class="px-3 py-1 text-xs font-semibold bg-white/90 dark:bg-gray-800/90 text-gray-900 dark:text-white rounded-full backdrop-blur-sm">
                                    {{ $package->category_label }}
                                </span>
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-2">
                                <i class='bx bx-map'></i>
                                <span>{{ $package->destination }}</span>
                                <span>•</span>
                                <span>{{ $package->duration }}</span>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 line-clamp-1">{{ $package->name }}</h3>
                            <div class="flex items-center justify-between pt-3 border-t border-gray-100 dark:border-gray-700">
                                <span class="text-lg font-bold text-primary-600 dark:text-primary-400">RM {{ number_format($package->price) }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">View Details →</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</x-public-layout>
