<x-public-layout>
    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    @endpush

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    @endpush

    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">
        <div class="relative h-[50vh] min-h-[400px] overflow-hidden">
            <img src="{{ $attraction->featured_image_url }}" alt="{{ $attraction->name }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-8 lg:p-12">
                <div class="max-w-7xl mx-auto">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="px-3 py-1 text-xs font-semibold bg-emerald-600 text-white rounded-full">{{ $attraction->category_label }}</span>
                        @if($attraction->is_featured)
                        <span class="px-3 py-1 text-xs font-semibold bg-amber-500 text-white rounded-full">Popular</span>
                        @endif
                    </div>
                    <h1 class="text-4xl lg:text-5xl font-bold text-white mb-4">{{ $attraction->name }}</h1>
                    <div class="flex flex-wrap items-center gap-4 text-gray-300">
                        <span class="flex items-center gap-1.5"><i class='bx bx-map'></i> {{ $attraction->location }}</span>
                        <div class="flex items-center gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                <i class='bx {{ $i <= round($attraction->rating) ? 'bxs' : 'bx' }}-star text-amber-400'></i>
                            @endfor
                            <span class="ml-1">({{ $attraction->reviews_count }} reviews)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 lg:p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <i class='bx bx-info-circle text-emerald-600'></i>
                            Attraction Information
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center shrink-0">
                                    <i class='bx bx-map text-emerald-600 dark:text-emerald-400 text-lg'></i>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">Location</span>
                                    <p class="text-gray-900 dark:text-white font-medium">{{ $attraction->location }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center shrink-0">
                                    <i class='bx bx-map-alt text-emerald-600 dark:text-emerald-400 text-lg'></i>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">Address</span>
                                    <p class="text-gray-900 dark:text-white font-medium">{{ $attraction->address }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center shrink-0">
                                    <i class='bx bx-dollar text-emerald-600 dark:text-emerald-400 text-lg'></i>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">Entrance Fee</span>
                                    @if($attraction->entrance_fee > 0)
                                    <p class="text-gray-900 dark:text-white font-medium">RM {{ number_format($attraction->entrance_fee, 2) }}</p>
                                    @else
                                    <p class="text-green-600 dark:text-green-400 font-medium">Free Entry</p>
                                    @endif
                                </div>
                            </div>
                            @if($attraction->contact_number)
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center shrink-0">
                                    <i class='bx bx-phone text-emerald-600 dark:text-emerald-400 text-lg'></i>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">Contact</span>
                                    <p class="text-gray-900 dark:text-white font-medium">{{ $attraction->contact_number }}</p>
                                </div>
                            </div>
                            @endif
                            @if($attraction->website)
                            <div class="flex items-start gap-4 md:col-span-2">
                                <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center shrink-0">
                                    <i class='bx bx-globe text-emerald-600 dark:text-emerald-400 text-lg'></i>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">Website</span>
                                    <a href="{{ $attraction->website }}" target="_blank" rel="noopener noreferrer" class="text-primary-600 dark:text-primary-400 font-medium hover:underline">{{ $attraction->website }}</a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    @if($attraction->latitude && $attraction->longitude)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 lg:p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <i class='bx bx-map text-emerald-600'></i>
                            Location Map
                        </h2>
                        <div id="map" class="h-80 w-full rounded-xl overflow-hidden z-0"></div>
                    </div>
                    @endif

                    @if($attraction->opening_hours)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 lg:p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <i class='bx bx-time text-emerald-600'></i>
                            Opening Hours
                        </h2>
                        <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700">
                            <table class="w-full">
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($attraction->formatted_opening_hours as $day => $hours)
                                    <tr class="{{ strtolower($day) === strtolower(\Carbon\Carbon::now()->format('l')) ? 'bg-emerald-50 dark:bg-emerald-900/20' : '' }}">
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ $day }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400 text-right">{{ $hours }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 lg:p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Description</h2>
                        <div class="prose prose-gray dark:prose-invert max-w-none">
                            {!! nl2br(e($attraction->description)) !!}
                        </div>
                    </div>

                    @if(!empty($attraction->gallery))
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 lg:p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <i class='bx bx-images text-emerald-600'></i>
                            Gallery
                        </h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($attraction->gallery_urls as $imageUrl)
                            <div class="aspect-square rounded-xl overflow-hidden">
                                <img src="{{ $imageUrl }}" alt="{{ $attraction->name }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300 cursor-pointer" onclick="window.open('{{ $imageUrl }}', '_blank')">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($attraction->reviews->count() > 0)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 lg:p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <i class='bx bx-message-rounded-detail text-emerald-600'></i>
                            Reviews ({{ $attraction->reviews_count }})
                        </h2>
                        <div class="space-y-6">
                            @foreach($attraction->reviews as $review)
                            <div class="pb-6 {{ !$loop->last ? 'border-b border-gray-100 dark:border-gray-700' : '' }}">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                            <i class='bx bx-user text-gray-500 dark:text-gray-400'></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">{{ $review->customer->name ?? 'Anonymous' }}</p>
                                            <div class="flex items-center gap-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class='bx {{ $i <= $review->rating ? 'bxs' : 'bx' }}-star text-amber-400 text-sm'></i>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $review->created_at->format('M d, Y') }}</span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">{{ $review->comment }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <div class="lg:col-span-1">
                    <div class="sticky top-8 space-y-6">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                            <div class="text-center mb-6">
                                <div class="flex items-center justify-center gap-2 mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class='bx {{ $i <= round($attraction->rating) ? 'bxs' : 'bx' }}-star text-amber-400 text-2xl'></i>
                                    @endfor
                                </div>
                                <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($attraction->rating, 1) }}</div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Based on {{ $attraction->reviews_count }} reviews</span>
                            </div>

                            @if($attraction->entrance_fee > 0)
                            <div class="text-center py-4 border-t border-gray-100 dark:border-gray-700">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Entrance Fee</span>
                                <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">RM {{ number_format($attraction->entrance_fee, 2) }}</div>
                            </div>
                            @else
                            <div class="text-center py-4 border-t border-gray-100 dark:border-gray-700">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Entrance Fee</span>
                                <div class="text-2xl font-bold text-green-600 dark:text-green-400">Free Entry</div>
                            </div>
                            @endif

                            <a href="{{ route('transport-rates', ['destination' => $attraction->name]) }}" class="w-full block text-center px-6 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition-colors shadow-lg mt-4">
                                <i class='bx bx-car mr-2'></i>
                                Book Transport
                            </a>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Share This Place</h3>
                            <div class="flex items-center gap-3">
                                <button onclick="navigator.share({ title: '{{ $attraction->name }}', url: window.location.href })" class="flex-1 py-2 px-4 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-sm font-medium">
                                    <i class='bx bx-share-alt mr-1'></i> Share
                                </button>
                                <button onclick="navigator.clipboard.writeText(window.location.href)" class="flex-1 py-2 px-4 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-sm font-medium">
                                    <i class='bx bx-link mr-1'></i> Copy Link
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($nearbyAttractions->count() > 0)
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">Nearby Attractions</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($nearbyAttractions as $nearby)
                    <a href="{{ route('attractions.show', $nearby) }}" class="group bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all border border-gray-100 dark:border-gray-700">
                        <div class="relative aspect-[4/3] overflow-hidden">
                            <img src="{{ $nearby->featured_image_url }}" alt="{{ $nearby->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute top-3 right-3">
                                <span class="px-2 py-1 text-xs font-semibold bg-white/90 dark:bg-gray-800/90 text-gray-900 dark:text-white rounded-full backdrop-blur-sm">
                                    {{ $nearby->category_label }}
                                </span>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center gap-1 mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class='bx {{ $i <= round($nearby->rating) ? 'bxs' : 'bx' }}-star text-amber-400 text-sm'></i>
                                @endfor
                            </div>
                            <h3 class="font-semibold text-gray-900 dark:text-white line-clamp-1 mb-1">{{ $nearby->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400"><i class='bx bx-map text-xs'></i> {{ $nearby->location }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    @if($attraction->latitude && $attraction->longitude)
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const map = L.map('map').setView([{{ $attraction->latitude }}, {{ $attraction->longitude }}], 15);
            L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; OpenStreetMap &copy; CARTO',
                maxZoom: 20
            }).addTo(map);

            const icon = L.divIcon({
                className: 'bg-transparent',
                html: `<div class="w-6 h-6 rounded-full bg-emerald-600 ring-4 ring-white shadow-lg flex items-center justify-center">
                    <i class='bx bx-map-pin text-white text-xs'></i>
                </div>`
            });

            L.marker([{{ $attraction->latitude }}, {{ $attraction->longitude }}], { icon: icon }).addTo(map);
        });
    </script>
    @endif
</x-public-layout>
