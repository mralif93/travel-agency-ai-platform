<x-app-layout>
    <div class="sm:flex sm:items-center mb-8">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">Tour Package Details</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-400">View detailed information about this tour package.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none flex gap-2">
            <a href="{{ route('admin.tour-packages.edit', $package) }}"
                class="inline-flex items-center gap-2 rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                <i class='bx bx-edit align-middle'></i>Edit
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
                <div class="relative aspect-video">
                    <img src="{{ $package->featured_image_url }}" alt="{{ $package->name }}" class="w-full h-full object-cover">
                    <div class="absolute top-3 left-3 flex gap-2">
                        @if($package->is_featured)
                            <span class="px-2 py-1 text-xs font-semibold bg-amber-500 text-white rounded-lg">Featured</span>
                        @endif
                        @if(!$package->is_active)
                            <span class="px-2 py-1 text-xs font-semibold bg-gray-500 text-white rounded-lg">Inactive</span>
                        @endif
                    </div>
                    <div class="absolute top-3 right-3">
                        <span class="px-2 py-1 text-xs font-semibold bg-white/90 dark:bg-gray-800/90 text-gray-900 dark:text-white rounded-lg backdrop-blur-sm">
                            {{ $package->category_label }}
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $package->name }}</h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 flex items-center gap-1">
                        <i class='bx bx-map'></i> {{ $package->destination }}
                    </p>
                    <p class="mt-4 text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $package->description }}</p>
                </div>
            </div>

            @if($package->gallery_urls && count($package->gallery_urls) > 0)
            <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Gallery</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @foreach($package->gallery_urls as $image)
                            <div class="aspect-square rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                                <img src="{{ $image }}" alt="Gallery image {{ $loop->iteration }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300 cursor-pointer" onclick="openLightbox('{{ $image }}')">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            @if($package->itinerary && count($package->itinerary) > 0)
            <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Itinerary</h3>
                    <div class="space-y-4">
                        @foreach($package->itinerary as $index => $item)
                            <div class="flex gap-4">
                                <div class="flex flex-col items-center">
                                    <div class="w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 flex items-center justify-center text-sm font-semibold">
                                        {{ $index + 1 }}
                                    </div>
                                    @if(!$loop->last)
                                        <div class="w-0.5 flex-1 bg-gray-200 dark:bg-gray-700 my-2"></div>
                                    @endif
                                </div>
                                <div class="flex-1 pb-4">
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white">{{ $item['title'] ?? '' }}</h4>
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $item['description'] ?? '' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-100 dark:divide-gray-700">
                    <div class="p-6">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <i class='bx bx-check-circle text-green-500'></i> Inclusions
                        </h3>
                        @if($package->inclusions && count($package->inclusions) > 0)
                            <ul class="space-y-2">
                                @foreach($package->inclusions as $inclusion)
                                    <li class="flex items-start gap-2 text-sm text-gray-700 dark:text-gray-300">
                                        <i class='bx bx-check text-green-500 mt-0.5'></i>
                                        <span>{{ $inclusion }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400 italic">No inclusions specified</p>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <i class='bx bx-x-circle text-red-500'></i> Exclusions
                        </h3>
                        @if($package->exclusions && count($package->exclusions) > 0)
                            <ul class="space-y-2">
                                @foreach($package->exclusions as $exclusion)
                                    <li class="flex items-start gap-2 text-sm text-gray-700 dark:text-gray-300">
                                        <i class='bx bx-x text-red-500 mt-0.5'></i>
                                        <span>{{ $exclusion }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400 italic">No exclusions specified</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
                <div class="p-6 space-y-6">
                    <div>
                        <p class="text-3xl font-bold text-primary-600 dark:text-primary-400">RM {{ number_format($package->price, 2) }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">per person</p>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                <i class='bx bx-time'></i> Duration
                            </span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $package->duration }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                <i class='bx bx-map'></i> Destination
                            </span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $package->destination }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                <i class='bx bx-category'></i> Category
                            </span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $package->category_label }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                <i class='bx bx-user'></i> Max Pax
                            </span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $package->max_pax ?? 'Unlimited' }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                <i class='bx bx-trending-up'></i> Difficulty
                            </span>
                            <span class="px-2 py-1 text-xs font-medium rounded-lg {{ $package->difficulty_color === 'green' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : ($package->difficulty_color === 'yellow' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400') }}">
                                {{ $package->difficulty_label }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
                <div class="px-4 py-6 sm:p-0">
                    <dl class="divide-y divide-gray-100 dark:divide-gray-700">
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-900 dark:text-white">Status</dt>
                            <dd class="mt-1 text-sm text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                                @php
                                    $statusClass = $package->is_active ? 'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-50 text-gray-600 ring-gray-500/10 dark:bg-gray-700 dark:text-gray-300';
                                @endphp
                                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $statusClass }}">
                                    {{ $package->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-900 dark:text-white">Featured</dt>
                            <dd class="mt-1 text-sm text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                                @if($package->is_featured)
                                    <span class="inline-flex items-center gap-1 text-amber-600 dark:text-amber-400">
                                        <i class='bx bxs-star'></i> Yes
                                    </span>
                                @else
                                    <span class="text-gray-500 dark:text-gray-400">No</span>
                                @endif
                            </dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-900 dark:text-white">Created</dt>
                            <dd class="mt-1 text-sm text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                                {{ $package->created_at->format('M d, Y \a\t h:i A') }}
                            </dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-900 dark:text-white">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                                {{ $package->updated_at->format('M d, Y \a\t h:i A') }}
                            </dd>
                        </div>
                    </dl>
                </div>
                <div class="bg-gray-50 dark:bg-gray-800/50 px-4 py-4 sm:px-6 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                    <a href="{{ route('admin.tour-packages.index') }}"
                        class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white flex items-center">
                        <i class='bx bx-arrow-back mr-1'></i>Back to Tour Packages
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div id="lightbox" class="fixed inset-0 bg-black/90 z-50 hidden items-center justify-center p-4" onclick="closeLightbox()">
        <button class="absolute top-4 right-4 text-white hover:text-gray-300" onclick="closeLightbox()">
            <i class='bx bx-x text-3xl'></i>
        </button>
        <img id="lightbox-image" src="" alt="Full size image" class="max-w-full max-h-full object-contain">
    </div>

    @push('scripts')
    <script>
        function openLightbox(src) {
            const lightbox = document.getElementById('lightbox');
            const image = document.getElementById('lightbox-image');
            image.src = src;
            lightbox.classList.remove('hidden');
            lightbox.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            const lightbox = document.getElementById('lightbox');
            lightbox.classList.add('hidden');
            lightbox.classList.remove('flex');
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeLightbox();
            }
        });
    </script>
    @endpush
</x-app-layout>
