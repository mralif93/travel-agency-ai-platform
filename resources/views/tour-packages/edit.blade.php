<x-app-layout>
    <div class="sm:flex sm:items-center mb-8">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">Edit Tour Package</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-400">Update tour package details.</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
        <form action="{{ route('admin.tour-packages.update', $package) }}" method="POST" enctype="multipart/form-data" x-data="tourPackageForm(@js($package))">
            @csrf
            @method('PUT')
            <div class="px-4 py-6 sm:p-8">
                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-6">
                        <label for="name" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Package Name</label>
                        <div class="mt-2">
                            <input type="text" name="name" id="name" value="{{ old('name', $package->name) }}"
                                class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white dark:ring-gray-700"
                                placeholder="e.g., Bali Adventure Getaway">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:col-span-6">
                        <label for="short_description" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Short Description</label>
                        <div class="mt-2">
                            <input type="text" name="short_description" id="short_description" value="{{ old('short_description', $package->short_description) }}"
                                class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white dark:ring-gray-700"
                                placeholder="Brief overview for listing cards">
                            @error('short_description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:col-span-6">
                        <label for="description" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Full Description</label>
                        <div class="mt-2">
                            <textarea name="description" id="description" rows="5"
                                class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white dark:ring-gray-700"
                                placeholder="Detailed description of the tour package...">{{ old('description', $package->description) }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="price" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Price (RM)</label>
                        <div class="mt-2">
                            <input type="number" name="price" id="price" step="0.01" min="0" value="{{ old('price', $package->price) }}"
                                class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white dark:ring-gray-700"
                                placeholder="0.00">
                            @error('price')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="duration" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Duration</label>
                        <div class="mt-2">
                            <input type="text" name="duration" id="duration" value="{{ old('duration', $package->duration) }}"
                                class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white dark:ring-gray-700"
                                placeholder="e.g., 3 Days 2 Nights">
                            @error('duration')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="destination" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Destination</label>
                        <div class="mt-2">
                            <input type="text" name="destination" id="destination" value="{{ old('destination', $package->destination) }}"
                                class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white dark:ring-gray-700"
                                placeholder="e.g., Bali, Indonesia">
                            @error('destination')
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
                                <option value="adventure" {{ old('category', $package->category) == 'adventure' ? 'selected' : '' }}>Adventure</option>
                                <option value="cultural" {{ old('category', $package->category) == 'cultural' ? 'selected' : '' }}>Cultural</option>
                                <option value="nature" {{ old('category', $package->category) == 'nature' ? 'selected' : '' }}>Nature</option>
                                <option value="beach" {{ old('category', $package->category) == 'beach' ? 'selected' : '' }}>Beach</option>
                                <option value="city" {{ old('category', $package->category) == 'city' ? 'selected' : '' }}>City Tour</option>
                                <option value="culinary" {{ old('category', $package->category) == 'culinary' ? 'selected' : '' }}>Culinary</option>
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
                        <label for="difficulty" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Difficulty Level</label>
                        <div class="mt-2 relative">
                            <select id="difficulty" name="difficulty"
                                class="block w-full appearance-none rounded-md border-0 py-2.5 pl-3 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white dark:ring-gray-700">
                                <option value="">Select Difficulty</option>
                                <option value="easy" {{ old('difficulty', $package->difficulty) == 'easy' ? 'selected' : '' }}>Easy</option>
                                <option value="moderate" {{ old('difficulty', $package->difficulty) == 'moderate' ? 'selected' : '' }}>Moderate</option>
                                <option value="challenging" {{ old('difficulty', $package->difficulty) == 'challenging' ? 'selected' : '' }}>Challenging</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                <i class='bx bx-chevron-down text-lg'></i>
                            </div>
                            @error('difficulty')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="max_pax" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Max Pax</label>
                        <div class="mt-2">
                            <input type="number" name="max_pax" id="max_pax" min="1" value="{{ old('max_pax', $package->max_pax) }}"
                                class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white dark:ring-gray-700"
                                placeholder="Maximum number of participants">
                            @error('max_pax')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Options</label>
                        <div class="mt-4 space-y-4">
                            <div class="relative flex items-start">
                                <div class="flex h-6 items-center">
                                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $package->is_featured) ? 'checked' : '' }}
                                        class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-600">
                                </div>
                                <div class="ml-3 text-sm leading-6">
                                    <label for="is_featured" class="text-gray-900 dark:text-white">Featured Package</label>
                                </div>
                            </div>
                            <div class="relative flex items-start">
                                <div class="flex h-6 items-center">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $package->is_active) ? 'checked' : '' }}
                                        class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-600">
                                </div>
                                <div class="ml-3 text-sm leading-6">
                                    <label for="is_active" class="text-gray-900 dark:text-white">Active (Published)</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sm:col-span-6">
                        <label for="featured_image" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Featured Image</label>
                        <div class="mt-2">
                            <div class="flex items-center gap-4">
                                <div x-show="!featuredImagePreview" class="w-32 h-24 rounded-lg overflow-hidden border border-gray-300 dark:border-gray-600">
                                    <img src="{{ $package->featured_image_url }}" alt="Current featured image" class="w-full h-full object-cover">
                                </div>
                                <div x-show="featuredImagePreview" class="w-32 h-24 rounded-lg overflow-hidden border border-gray-300 dark:border-gray-600">
                                    <img :src="featuredImagePreview" alt="Preview" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <input type="file" name="featured_image" id="featured_image" accept="image/*" @change="previewFeaturedImage($event)"
                                        class="block w-full text-sm text-gray-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-primary-900/30 dark:file:text-primary-400">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Leave empty to keep current image. Recommended: 1200x800px</p>
                                </div>
                            </div>
                            @error('featured_image')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:col-span-6">
                        <label for="gallery" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Gallery Images</label>
                        <div class="mt-2">
                            <div x-show="existingGallery.length > 0 || galleryPreviews.length > 0" class="flex flex-wrap gap-3 mb-4">
                                <template x-for="(image, index) in existingGallery" :key="'existing-' + index">
                                    <div class="relative w-24 h-24 rounded-lg overflow-hidden border border-gray-300 dark:border-gray-600 group">
                                        <img :src="image" alt="Gallery image" class="w-full h-full object-cover">
                                    </div>
                                </template>
                                <template x-for="(preview, index) in galleryPreviews" :key="'new-' + index">
                                    <div class="relative w-24 h-24 rounded-lg overflow-hidden border border-gray-300 dark:border-gray-600">
                                        <img :src="preview" alt="Gallery preview" class="w-full h-full object-cover">
                                        <button type="button" @click="removeGalleryImage(index)"
                                            class="absolute top-1 right-1 w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600">
                                            <i class='bx bx-x text-sm'></i>
                                        </button>
                                    </div>
                                </template>
                            </div>
                            <input type="file" name="gallery[]" id="gallery" accept="image/*" multiple @change="previewGallery($event)"
                                class="block w-full text-sm text-gray-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-primary-900/30 dark:file:text-primary-400">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Select additional images. Existing gallery will be preserved. Recommended: 1200x800px</p>
                            @error('gallery')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:col-span-6">
                        <div class="flex items-center justify-between mb-4">
                            <label class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Inclusions</label>
                            <button type="button" @click="addInclusion()"
                                class="inline-flex items-center gap-1 text-sm text-primary-600 hover:text-primary-500">
                                <i class='bx bx-plus'></i> Add Inclusion
                            </button>
                        </div>
                        <div class="space-y-3">
                            <template x-for="(inclusion, index) in inclusions" :key="index">
                                <div class="flex items-center gap-2">
                                    <input type="text" :name="'inclusions[' + index + ']'" x-model="inclusion.value"
                                        class="block flex-1 rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white dark:ring-gray-700"
                                        placeholder="e.g., Airport transfers">
                                    <button type="button" @click="removeInclusion(index)" class="p-2 text-red-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg">
                                        <i class='bx bx-trash text-lg'></i>
                                    </button>
                                </div>
                            </template>
                            <p x-show="inclusions.length === 0" class="text-sm text-gray-500 dark:text-gray-400 italic">No inclusions added yet. Click the button above to add.</p>
                        </div>
                        @error('inclusions')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-6">
                        <div class="flex items-center justify-between mb-4">
                            <label class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Exclusions</label>
                            <button type="button" @click="addExclusion()"
                                class="inline-flex items-center gap-1 text-sm text-primary-600 hover:text-primary-500">
                                <i class='bx bx-plus'></i> Add Exclusion
                            </button>
                        </div>
                        <div class="space-y-3">
                            <template x-for="(exclusion, index) in exclusions" :key="index">
                                <div class="flex items-center gap-2">
                                    <input type="text" :name="'exclusions[' + index + ']'" x-model="exclusion.value"
                                        class="block flex-1 rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white dark:ring-gray-700"
                                        placeholder="e.g., Personal expenses">
                                    <button type="button" @click="removeExclusion(index)" class="p-2 text-red-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg">
                                        <i class='bx bx-trash text-lg'></i>
                                    </button>
                                </div>
                            </template>
                            <p x-show="exclusions.length === 0" class="text-sm text-gray-500 dark:text-gray-400 italic">No exclusions added yet. Click the button above to add.</p>
                        </div>
                        @error('exclusions')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-6">
                        <div class="flex items-center justify-between mb-4">
                            <label class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Itinerary</label>
                            <button type="button" @click="addItinerary()"
                                class="inline-flex items-center gap-1 text-sm text-primary-600 hover:text-primary-500">
                                <i class='bx bx-plus'></i> Add Day
                            </button>
                        </div>
                        <div class="space-y-4">
                            <template x-for="(item, index) in itinerary" :key="index">
                                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">Day <span x-text="index + 1"></span></span>
                                        <button type="button" @click="removeItinerary(index)" class="p-1 text-red-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-6">
                                        <div class="sm:col-span-2">
                                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
                                            <input type="text" :name="'itinerary[' + index + '][title]'" x-model="item.title"
                                                class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 text-sm dark:bg-gray-800 dark:text-white dark:ring-gray-600"
                                                placeholder="e.g., Arrival & Welcome">
                                        </div>
                                        <div class="sm:col-span-4">
                                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                                            <textarea :name="'itinerary[' + index + '][description]'" x-model="item.description" rows="2"
                                                class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 text-sm dark:bg-gray-800 dark:text-white dark:ring-gray-600"
                                                placeholder="Describe the activities for this day..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <p x-show="itinerary.length === 0" class="text-sm text-gray-500 dark:text-gray-400 italic">No itinerary added yet. Click the button above to add days.</p>
                        </div>
                        @error('itinerary')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 dark:border-gray-700 px-4 py-4 sm:px-8">
                <a href="{{ route('admin.tour-packages.index') }}" class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">Cancel</a>
                <button type="submit"
                    class="rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">Update Package</button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        function tourPackageForm(package) {
            return {
                featuredImagePreview: null,
                galleryPreviews: [],
                existingGallery: package.gallery_urls || [],
                inclusions: package.inclusions && package.inclusions.length > 0 ? package.inclusions.map(v => ({ value: v })) : [],
                exclusions: package.exclusions && package.exclusions.length > 0 ? package.exclusions.map(v => ({ value: v })) : [],
                itinerary: package.itinerary || [],

                previewFeaturedImage(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.featuredImagePreview = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                },

                previewGallery(event) {
                    const files = event.target.files;
                    for (let i = 0; i < files.length; i++) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.galleryPreviews.push(e.target.result);
                        };
                        reader.readAsDataURL(files[i]);
                    }
                },

                removeGalleryImage(index) {
                    this.galleryPreviews.splice(index, 1);
                    const input = document.getElementById('gallery');
                    const dt = new DataTransfer();
                    const files = input.files;
                    for (let i = 0; i < files.length; i++) {
                        if (i !== index) {
                            dt.items.add(files[i]);
                        }
                    }
                    input.files = dt.files;
                },

                addInclusion() {
                    this.inclusions.push({ value: '' });
                },

                removeInclusion(index) {
                    this.inclusions.splice(index, 1);
                },

                addExclusion() {
                    this.exclusions.push({ value: '' });
                },

                removeExclusion(index) {
                    this.exclusions.splice(index, 1);
                },

                addItinerary() {
                    this.itinerary.push({ title: '', description: '' });
                },

                removeItinerary(index) {
                    this.itinerary.splice(index, 1);
                }
            }
        }
    </script>
    @endpush
</x-app-layout>
