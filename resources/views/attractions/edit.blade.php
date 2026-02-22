<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <div class="sm:flex sm:items-center mb-8">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">Edit Attraction</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-400">Update attraction details.</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
        <form action="{{ route('admin.attractions.update', $attraction) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $attraction->latitude) }}">
            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $attraction->longitude) }}">

            @if ($errors->any())
                <div class="px-4 py-6 sm:px-8 bg-red-50 dark:bg-red-900/20 border-b border-red-200 dark:border-red-800">
                    <ul class="list-disc pl-5 space-y-1 text-sm text-red-600 dark:text-red-400">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="px-4 py-6 sm:p-8">
                <div class="space-y-10">
                    <div>
                        <h3 class="text-sm font-bold uppercase tracking-wider text-gray-500 mb-6 flex items-center gap-2">
                            <i class='bx bx-info-circle text-lg'></i> Basic Information
                        </h3>
                        <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
                            <div class="sm:col-span-6">
                                <label for="name" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Name</label>
                                <div class="mt-2">
                                    <input type="text" name="name" id="name" value="{{ old('name', $attraction->name) }}"
                                        class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white dark:ring-gray-700"
                                        placeholder="e.g., Batu Caves">
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-6">
                                <label for="short_description" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Short Description</label>
                                <div class="mt-2">
                                    <input type="text" name="short_description" id="short_description" value="{{ old('short_description', $attraction->short_description) }}"
                                        class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white dark:ring-gray-700"
                                        placeholder="Brief description (max 500 characters)" maxlength="500">
                                    @error('short_description')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-6">
                                <label for="description" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Full Description</label>
                                <div class="mt-2">
                                    <textarea name="description" id="description" rows="4"
                                        class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white dark:ring-gray-700"
                                        placeholder="Detailed description of the attraction...">{{ old('description', $attraction->description) }}</textarea>
                                    @error('description')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="category" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Category</label>
                                <div class="mt-2 relative">
                                    <select id="category" name="category"
                                        class="block w-full appearance-none rounded-md border-0 py-2.5 pl-3 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white dark:ring-gray-700">
                                        <option value="">Select Category</option>
                                        <option value="temple" {{ old('category', $attraction->category) == 'temple' ? 'selected' : '' }}>Temple</option>
                                        <option value="beach" {{ old('category', $attraction->category) == 'beach' ? 'selected' : '' }}>Beach</option>
                                        <option value="mountain" {{ old('category', $attraction->category) == 'mountain' ? 'selected' : '' }}>Mountain</option>
                                        <option value="park" {{ old('category', $attraction->category) == 'park' ? 'selected' : '' }}>Park</option>
                                        <option value="museum" {{ old('category', $attraction->category) == 'museum' ? 'selected' : '' }}>Museum</option>
                                        <option value="island" {{ old('category', $attraction->category) == 'island' ? 'selected' : '' }}>Island</option>
                                        <option value="waterfall" {{ old('category', $attraction->category) == 'waterfall' ? 'selected' : '' }}>Waterfall</option>
                                        <option value="cave" {{ old('category', $attraction->category) == 'cave' ? 'selected' : '' }}>Cave</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                        <i class='bx bx-chevron-down text-lg'></i>
                                    </div>
                                    @error('category')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="entrance_fee" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Entrance Fee (RM)</label>
                                <div class="mt-2">
                                    <input type="number" name="entrance_fee" id="entrance_fee" value="{{ old('entrance_fee', $attraction->entrance_fee) }}" step="0.01" min="0"
                                        class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white dark:ring-gray-700"
                                        placeholder="0.00">
                                    @error('entrance_fee')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-bold uppercase tracking-wider text-gray-500 mb-6 flex items-center gap-2">
                            <i class='bx bx-map text-lg'></i> Location
                        </h3>
                        <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="location" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Location / City</label>
                                <div class="mt-2">
                                    <input type="text" name="location" id="location" value="{{ old('location', $attraction->location) }}"
                                        class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white dark:ring-gray-700"
                                        placeholder="e.g., Selangor">
                                    @error('location')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="address" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Full Address</label>
                                <div class="mt-2">
                                    <input type="text" name="address" id="address" value="{{ old('address', $attraction->address) }}"
                                        class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white dark:ring-gray-700"
                                        placeholder="Full street address">
                                    @error('address')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-6">
                                <label class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Map Location</label>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Click on the map to set the exact location</p>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none z-10">
                                        <i class='bx bx-search text-gray-400'></i>
                                    </div>
                                    <input type="text" id="map_search" 
                                        class="block w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 mb-3"
                                        placeholder="Search for a location...">
                                </div>
                                <div id="map" class="h-80 w-full rounded-xl border border-gray-200 dark:border-gray-700 z-0"></div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-bold uppercase tracking-wider text-gray-500 mb-6 flex items-center gap-2">
                            <i class='bx bx-time text-lg'></i> Opening Hours
                        </h3>
                        <div class="space-y-4">
                            @php
                                $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                                $existingHours = $attraction->opening_hours ?? [];
                                $oldHours = old('opening_hours', []);
                            @endphp
                            @foreach($days as $day)
                                @php
                                    $hours = $oldHours[$day] ?? $existingHours[$day] ?? [];
                                @endphp
                                <div class="flex items-center gap-4">
                                    <label class="w-28 text-sm font-medium text-gray-700 dark:text-gray-300 capitalize">{{ $day }}</label>
                                    <div class="flex items-center gap-2 flex-1">
                                        <input type="time" name="opening_hours[{{ $day }}][open]" 
                                            value="{{ $hours['open'] ?? '' }}"
                                            class="block rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm dark:bg-gray-900 dark:text-white dark:ring-gray-700"
                                            {{ isset($hours['closed']) ? 'disabled' : '' }}>
                                        <span class="text-gray-500 dark:text-gray-400">to</span>
                                        <input type="time" name="opening_hours[{{ $day }}][close]" 
                                            value="{{ $hours['close'] ?? '' }}"
                                            class="block rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm dark:bg-gray-900 dark:text-white dark:ring-gray-700"
                                            {{ isset($hours['closed']) ? 'disabled' : '' }}>
                                        <label class="flex items-center gap-2 ml-4">
                                            <input type="checkbox" name="opening_hours[{{ $day }}][closed]" value="1"
                                                {{ isset($hours['closed']) ? 'checked' : '' }}
                                                class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-600"
                                                onchange="this.checked ? this.closest('.flex').querySelectorAll('input[type=time]').forEach(i => i.disabled = true) : this.closest('.flex').querySelectorAll('input[type=time]').forEach(i => i.disabled = false)">
                                            <span class="text-sm text-gray-500 dark:text-gray-400">Closed</span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-bold uppercase tracking-wider text-gray-500 mb-6 flex items-center gap-2">
                            <i class='bx bx-phone text-lg'></i> Contact Information
                        </h3>
                        <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="contact_number" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Contact Number</label>
                                <div class="mt-2">
                                    <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number', $attraction->contact_number) }}"
                                        class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white dark:ring-gray-700"
                                        placeholder="+60 3-1234 5678">
                                    @error('contact_number')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="website" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Website</label>
                                <div class="mt-2">
                                    <input type="url" name="website" id="website" value="{{ old('website', $attraction->website) }}"
                                        class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white dark:ring-gray-700"
                                        placeholder="https://example.com">
                                    @error('website')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-bold uppercase tracking-wider text-gray-500 mb-6 flex items-center gap-2">
                            <i class='bx bx-image text-lg'></i> Images
                        </h3>
                        <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="featured_image" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Featured Image</label>
                                <div class="mt-2">
                                    @if($attraction->featured_image)
                                        <div class="mb-3">
                                            <img src="{{ $attraction->featured_image_url }}" alt="Current featured image" class="h-24 w-32 object-cover rounded-lg">
                                            <p class="text-xs text-gray-500 mt-1">Current image</p>
                                        </div>
                                    @endif
                                    <div class="flex items-center justify-center w-full">
                                        <label for="featured_image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <i class='bx bx-cloud-upload text-2xl text-gray-400 mb-2'></i>
                                                <p class="text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG (max 2MB)</p>
                                            </div>
                                            <input type="file" name="featured_image" id="featured_image" class="hidden" accept="image/*">
                                        </label>
                                    </div>
                                    @error('featured_image')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="gallery" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Gallery Images</label>
                                <div class="mt-2">
                                    @if($attraction->gallery && count($attraction->gallery) > 0)
                                        <div class="mb-3 flex flex-wrap gap-2">
                                            @foreach($attraction->gallery_urls as $url)
                                                <img src="{{ $url }}" alt="Gallery image" class="h-16 w-16 object-cover rounded-lg">
                                            @endforeach
                                        </div>
                                        <p class="text-xs text-gray-500 mb-2">Uploading new images will replace existing gallery</p>
                                    @endif
                                    <div class="flex items-center justify-center w-full">
                                        <label for="gallery" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <i class='bx bx-images text-2xl text-gray-400 mb-2'></i>
                                                <p class="text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Multiple images allowed</p>
                                            </div>
                                            <input type="file" name="gallery[]" id="gallery" class="hidden" accept="image/*" multiple>
                                        </label>
                                    </div>
                                    @error('gallery')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-bold uppercase tracking-wider text-gray-500 mb-6 flex items-center gap-2">
                            <i class='bx bx-cog text-lg'></i> Settings
                        </h3>
                        <div class="flex flex-wrap gap-6">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $attraction->is_featured) ? 'checked' : '' }}
                                    class="h-5 w-5 rounded border-gray-300 text-primary-600 focus:ring-primary-600">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Mark as Featured</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $attraction->is_active) ? 'checked' : '' }}
                                    class="h-5 w-5 rounded border-gray-300 text-primary-600 focus:ring-primary-600">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Active (Published)</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 dark:border-gray-700 px-4 py-4 sm:px-8">
                <a href="{{ route('admin.attractions.index') }}" class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">Cancel</a>
                <button type="submit" class="rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">Update Attraction</button>
            </div>
        </form>
    </div>

    <script>
        let map = null;
        let marker = null;

        const initialLat = {{ $attraction->latitude ?? 'null' }};
        const initialLng = {{ $attraction->longitude ?? 'null' }};

        function initMap() {
            const centerLat = initialLat || 3.140853;
            const centerLng = initialLng || 101.693207;
            const zoom = initialLat ? 15 : 6;

            map = L.map('map').setView([centerLat, centerLng], zoom);
            
            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
                subdomains: 'abcd',
                maxZoom: 20
            }).addTo(map);

            if (initialLat && initialLng) {
                setMarker(initialLat, initialLng);
            }

            map.on('click', function(e) {
                setMarker(e.latlng.lat, e.latlng.lng);
            });
        }

        function setMarker(lat, lng) {
            if (marker) {
                map.removeLayer(marker);
            }

            const customIcon = L.divIcon({
                className: 'bg-transparent',
                html: '<div class="w-6 h-6 rounded-full bg-primary-600 ring-4 ring-white shadow-lg flex items-center justify-center"><i class="bx bx-map-pin text-white text-xs"></i></div>'
            });

            marker = L.marker([lat, lng], { icon: customIcon }).addTo(map);
            
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        }

        document.getElementById('map_search').addEventListener('input', function() {
            const query = this.value;
            if (query.length < 3) return;

            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=my&limit=5`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        const result = data[0];
                        const lat = parseFloat(result.lat);
                        const lng = parseFloat(result.lon);
                        map.setView([lat, lng], 15);
                        setMarker(lat, lng);
                    }
                });
        });

        document.addEventListener('DOMContentLoaded', initMap);
    </script>
</x-app-layout>
