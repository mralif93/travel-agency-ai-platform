<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div class="sm:flex-auto">
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">{{ $attraction->name }}</h1>
                @if($attraction->is_featured)
                    <span class="px-2 py-1 text-xs font-semibold bg-amber-500 text-white rounded-lg">Featured</span>
                @endif
                @if(!$attraction->is_active)
                    <span class="px-2 py-1 text-xs font-semibold bg-gray-500 text-white rounded-lg">Inactive</span>
                @endif
            </div>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-400 flex items-center gap-1">
                <i class='bx bx-map'></i> {{ $attraction->location }}
            </p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none flex gap-2">
            <a href="{{ route('admin.attractions.edit', $attraction) }}"
                class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 transition-all">
                <i class='bx bx-edit'></i> Edit
            </a>
            <a href="{{ route('admin.attractions.index') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-gray-100 dark:bg-gray-700 px-4 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                <i class='bx bx-arrow-back'></i> Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
                <div class="aspect-video relative">
                    <img src="{{ $attraction->featured_image_url }}" alt="{{ $attraction->name }}"
                        class="w-full h-full object-cover">
                    <div class="absolute top-3 right-3">
                        <span class="px-3 py-1.5 text-sm font-semibold bg-white/90 dark:bg-gray-800/90 text-gray-900 dark:text-white rounded-lg backdrop-blur-sm">
                            {{ $attraction->category_label }}
                        </span>
                    </div>
                </div>
                
                @if($attraction->gallery && count($attraction->gallery) > 0)
                    <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Gallery</h3>
                        <div class="grid grid-cols-4 sm:grid-cols-6 gap-2">
                            @foreach($attraction->gallery_urls as $url)
                                <img src="{{ $url }}" alt="Gallery image" class="h-16 w-16 object-cover rounded-lg cursor-pointer hover:opacity-80 transition-opacity">
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">About</h2>
                </div>
                <div class="px-6 py-4">
                    <p class="text-gray-600 dark:text-gray-300 whitespace-pre-line">{{ $attraction->description }}</p>
                </div>
            </div>

            @if($attraction->latitude && $attraction->longitude)
                <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <i class='bx bx-map-alt text-primary-600'></i> Location
                        </h2>
                    </div>
                    <div class="p-4">
                        @if($attraction->address)
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ $attraction->address }}</p>
                        @endif
                        <div id="map" class="h-64 w-full rounded-xl border border-gray-200 dark:border-gray-700"></div>
                    </div>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class='bx bx-star text-amber-500'></i> Reviews
                        <span class="text-sm font-normal text-gray-500">({{ $attraction->reviews_count ?? 0 }})</span>
                    </h2>
                    <div class="flex items-center gap-1">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($attraction->rating ?? 0))
                                <i class='bx bxs-star text-amber-500'></i>
                            @else
                                <i class='bx bx-star text-gray-300'></i>
                            @endif
                        @endfor
                        <span class="ml-1 text-sm text-gray-500">{{ number_format($attraction->rating ?? 0, 1) }}</span>
                    </div>
                </div>
                
                @if($attraction->reviews->count() > 0)
                    <div class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($attraction->reviews as $review)
                            <div class="px-6 py-4">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-center gap-3">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($review->customer->name ?? 'Unknown') }}&background=random&color=fff&size=40"
                                            class="w-10 h-10 rounded-full">
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">{{ $review->customer->name ?? 'Unknown' }}</p>
                                            <div class="flex items-center gap-2">
                                                <div class="flex items-center">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->rating)
                                                            <i class='bx bxs-star text-amber-500 text-xs'></i>
                                                        @else
                                                            <i class='bx bx-star text-gray-300 text-xs'></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <span class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        @if($review->is_approved)
                                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-lg">Approved</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 rounded-lg">Pending</span>
                                        @endif
                                    </div>
                                </div>
                                @if($review->comment)
                                    <p class="mt-3 text-sm text-gray-600 dark:text-gray-300">{{ $review->comment }}</p>
                                @endif
                                <div class="mt-3 flex items-center gap-2">
                                    @if(!$review->is_approved)
                                        <form action="{{ route('admin.attractions.reviews.approve', $review) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium bg-green-600 text-white rounded-lg hover:bg-green-500 transition-colors">
                                                <i class='bx bx-check'></i> Approve
                                            </button>
                                        </form>
                                    @endif
                                    @if($review->is_approved)
                                        <form action="{{ route('admin.attractions.reviews.reject', $review) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium bg-yellow-600 text-white rounded-lg hover:bg-yellow-500 transition-colors">
                                                <i class='bx bx-x'></i> Reject
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.attractions.reviews.delete', $review) }}" method="POST" class="inline" onsubmit="return confirm('Delete this review?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium bg-red-600 text-white rounded-lg hover:bg-red-500 transition-colors">
                                            <i class='bx bx-trash'></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="px-6 py-12 text-center">
                        <div class="w-12 h-12 mx-auto bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-3">
                            <i class='bx bx-comment-detail text-2xl text-gray-400'></i>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">No reviews yet</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Entrance Fee</span>
                        <span class="text-xl font-bold text-primary-600 dark:text-primary-400">
                            @if($attraction->entrance_fee)
                                RM {{ number_format($attraction->entrance_fee, 2) }}
                            @else
                                <span class="text-green-600">Free Entry</span>
                            @endif
                        </span>
                    </div>

                    @if($attraction->contact_number)
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                <i class='bx bx-phone text-blue-600 dark:text-blue-400'></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Contact</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $attraction->contact_number }}</p>
                            </div>
                        </div>
                    @endif

                    @if($attraction->website)
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                                <i class='bx bx-globe text-purple-600 dark:text-purple-400'></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Website</p>
                                <a href="{{ $attraction->website }}" target="_blank" class="text-sm font-medium text-primary-600 dark:text-primary-400 hover:underline">{{ $attraction->website }}</a>
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                            <i class='bx bx-category text-green-600 dark:text-green-400'></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Category</p>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $attraction->category_label }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                            <i class='bx bx-star text-amber-600 dark:text-amber-400'></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Rating</p>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ number_format($attraction->rating ?? 0, 1) }} / 5 ({{ $attraction->reviews_count ?? 0 }} reviews)</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($attraction->opening_hours)
                <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <i class='bx bx-time text-primary-600'></i> Opening Hours
                        </h2>
                    </div>
                    <div class="p-4">
                        <div class="space-y-2">
                            @foreach($attraction->formatted_opening_hours as $day => $hours)
                                <div class="flex items-center justify-between py-2 @if(!$loop->last) border-b border-gray-100 dark:border-gray-700 @endif">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $day }}</span>
                                    @if(isset($hours['closed']) && $hours['closed'])
                                        <span class="text-sm font-medium text-red-500">Closed</span>
                                    @else
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $hours['open'] ?? 'N/A' }} - {{ $hours['close'] ?? 'N/A' }}
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
                <div class="px-6 py-4">
                    <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Status</h2>
                    <div class="flex flex-wrap gap-2">
                        @if($attraction->is_featured)
                            <span class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 rounded-lg">
                                <i class='bx bxs-star'></i> Featured
                            </span>
                        @endif
                        <span class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium {{ $attraction->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-400' }} rounded-lg">
                            <i class='bx {{ $attraction->is_active ? 'bxs-check-circle' : 'bx-x-circle' }}'></i>
                            {{ $attraction->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 dark:bg-gray-800/50 rounded-xl p-4">
                <p class="text-xs text-gray-500 dark:text-gray-400">Created {{ $attraction->created_at->format('M d, Y') }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">Updated {{ $attraction->updated_at->diffForHumans() }}</p>
            </div>
        </div>
    </div>

    @if($attraction->latitude && $attraction->longitude)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const map = L.map('map').setView([{{ $attraction->latitude }}, {{ $attraction->longitude }}], 15);
                
                L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
                    subdomains: 'abcd',
                    maxZoom: 20
                }).addTo(map);

                const customIcon = L.divIcon({
                    className: 'bg-transparent',
                    html: '<div class="w-8 h-8 rounded-full bg-primary-600 ring-4 ring-white shadow-lg flex items-center justify-center"><i class="bx bx-map-pin text-white text-sm"></i></div>'
                });

                L.marker([{{ $attraction->latitude }}, {{ $attraction->longitude }}], { icon: customIcon }).addTo(map);
            });
        </script>
    @endif
</x-app-layout>
