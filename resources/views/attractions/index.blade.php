<x-app-layout>
    <div class="sm:flex sm:items-center sm:justify-between">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Attractions</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-400">Manage tourist attractions and destinations.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <a href="{{ route('admin.attractions.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 transition-all">
                <i class='bx bx-plus text-lg'></i>
                Add Attraction
            </a>
        </div>
    </div>

    <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm ring-1 ring-gray-900/5 overflow-hidden">
        <div class="p-4 sm:p-6">
            <form action="{{ route('admin.attractions.index') }}" method="GET">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400'></i>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="block w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                placeholder="Search attractions...">
                        </div>
                    </div>
                    <div class="w-full sm:w-44">
                        <select name="category" class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                            <option value="">All Categories</option>
                            <option value="temple" {{ request('category') == 'temple' ? 'selected' : '' }}>Temple</option>
                            <option value="beach" {{ request('category') == 'beach' ? 'selected' : '' }}>Beach</option>
                            <option value="mountain" {{ request('category') == 'mountain' ? 'selected' : '' }}>Mountain</option>
                            <option value="park" {{ request('category') == 'park' ? 'selected' : '' }}>Park</option>
                            <option value="museum" {{ request('category') == 'museum' ? 'selected' : '' }}>Museum</option>
                            <option value="island" {{ request('category') == 'island' ? 'selected' : '' }}>Island</option>
                            <option value="waterfall" {{ request('category') == 'waterfall' ? 'selected' : '' }}>Waterfall</option>
                            <option value="cave" {{ request('category') == 'cave' ? 'selected' : '' }}>Cave</option>
                        </select>
                    </div>
                    <div class="w-full sm:w-36">
                        <select name="status" class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="px-4 py-2.5 bg-primary-600 text-white rounded-lg hover:bg-primary-500 transition-colors">
                        Filter
                    </button>
                    <a href="{{ route('admin.attractions.index') }}" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($attractions as $attraction)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm ring-1 ring-gray-900/5 overflow-hidden group">
                <div class="relative aspect-video overflow-hidden">
                    <img src="{{ $attraction->featured_image_url }}" alt="{{ $attraction->name }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute top-3 left-3 flex gap-2">
                        @if($attraction->is_featured)
                            <span class="px-2 py-1 text-xs font-semibold bg-amber-500 text-white rounded-lg">Featured</span>
                        @endif
                        @if(!$attraction->is_active)
                            <span class="px-2 py-1 text-xs font-semibold bg-gray-500 text-white rounded-lg">Inactive</span>
                        @endif
                    </div>
                    <div class="absolute top-3 right-3">
                        <span class="px-2 py-1 text-xs font-semibold bg-white/90 dark:bg-gray-800/90 text-gray-900 dark:text-white rounded-lg backdrop-blur-sm">
                            {{ $attraction->category_label }}
                        </span>
                    </div>
                </div>

                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white line-clamp-1">{{ $attraction->name }}</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 flex items-center gap-1">
                        <i class='bx bx-map'></i> {{ $attraction->location }}
                    </p>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300 line-clamp-2">{{ $attraction->short_description }}</p>

                    <div class="mt-4 flex items-center justify-between">
                        <div>
                            <div class="flex items-center gap-1 text-amber-500">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($attraction->rating ?? 0))
                                        <i class='bx bxs-star text-sm'></i>
                                    @else
                                        <i class='bx bx-star text-sm text-gray-300'></i>
                                    @endif
                                @endfor
                                <span class="text-xs text-gray-500 dark:text-gray-400 ml-1">({{ $attraction->reviews_count ?? 0 }})</span>
                            </div>
                            <p class="text-lg font-bold text-primary-600 dark:text-primary-400 mt-1">
                                @if($attraction->entrance_fee)
                                    RM {{ number_format($attraction->entrance_fee, 2) }}
                                @else
                                    <span class="text-sm font-medium text-green-600">Free Entry</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.attractions.show', $attraction) }}" class="p-2 text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors" title="View">
                                <i class='bx bx-show text-lg'></i>
                            </a>
                            <a href="{{ route('admin.attractions.edit', $attraction) }}" class="p-2 text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-lg transition-colors" title="Edit">
                                <i class='bx bx-edit text-lg'></i>
                            </a>
                            <form action="{{ route('admin.attractions.destroy', $attraction) }}" method="POST" class="inline" onsubmit="return confirm('Delete this attraction?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors" title="Delete">
                                    <i class='bx bx-trash text-lg'></i>
                                </button>
                            </form>
                        </div>
                        <div class="flex items-center gap-1">
                            <form action="{{ route('admin.attractions.toggle-featured', $attraction) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="p-2 {{ $attraction->is_featured ? 'text-amber-500' : 'text-gray-400' }} hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/20 rounded-lg transition-colors" title="{{ $attraction->is_featured ? 'Remove from featured' : 'Mark as featured' }}">
                                    <i class='bx {{ $attraction->is_featured ? 'bxs' : 'bx' }}-star text-lg'></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.attractions.toggle-active', $attraction) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="p-2 {{ $attraction->is_active ? 'text-green-500' : 'text-gray-400' }} hover:text-green-600 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-lg transition-colors" title="{{ $attraction->is_active ? 'Unpublish' : 'Publish' }}">
                                    <i class='bx {{ $attraction->is_active ? 'bxs' : 'bx' }}-check-circle text-lg'></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white dark:bg-gray-800 rounded-xl shadow-sm ring-1 ring-gray-900/5 p-12 text-center">
                <div class="w-16 h-16 mx-auto bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                    <i class='bx bx-map-alt text-3xl text-gray-400'></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">No attractions found</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new attraction.</p>
                <a href="{{ route('admin.attractions.create') }}" class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-500 transition-colors">
                    <i class='bx bx-plus'></i> Add Attraction
                </a>
            </div>
        @endforelse
    </div>

    <x-card-pagination :items="$attractions" />
</x-app-layout>
