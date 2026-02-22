<x-app-layout>
    <div class="sm:flex sm:items-center sm:justify-between">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Tour Packages</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-400">Manage tour packages for customers to explore.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <a href="{{ route('admin.tour-packages.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 transition-all">
                <i class='bx bx-plus text-lg'></i>
                Add Package
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm ring-1 ring-gray-900/5 overflow-hidden">
        <div class="p-4 sm:p-6">
            <form action="{{ route('admin.tour-packages.index') }}" method="GET">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400'></i>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="block w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                placeholder="Search packages...">
                        </div>
                    </div>
                    <div class="w-full sm:w-44">
                        <select name="category" class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                            <option value="">All Categories</option>
                            <option value="adventure" {{ request('category') == 'adventure' ? 'selected' : '' }}>Adventure</option>
                            <option value="cultural" {{ request('category') == 'cultural' ? 'selected' : '' }}>Cultural</option>
                            <option value="nature" {{ request('category') == 'nature' ? 'selected' : '' }}>Nature</option>
                            <option value="beach" {{ request('category') == 'beach' ? 'selected' : '' }}>Beach</option>
                            <option value="city" {{ request('category') == 'city' ? 'selected' : '' }}>City Tour</option>
                            <option value="culinary" {{ request('category') == 'culinary' ? 'selected' : '' }}>Culinary</option>
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
                    <a href="{{ route('admin.tour-packages.index') }}" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Packages Grid -->
    <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($packages as $package)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm ring-1 ring-gray-900/5 overflow-hidden group">
                <div class="relative aspect-video overflow-hidden">
                    <img src="{{ $package->featured_image_url }}" alt="{{ $package->name }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
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
                
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white line-clamp-1">{{ $package->name }}</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 flex items-center gap-1">
                        <i class='bx bx-map'></i> {{ $package->destination }}
                    </p>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300 line-clamp-2">{{ $package->short_description }}</p>
                    
                    <div class="mt-4 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $package->duration }}</p>
                            <p class="text-lg font-bold text-primary-600 dark:text-primary-400">RM {{ number_format($package->price, 2) }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium rounded-lg {{ $package->difficulty_color === 'green' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : ($package->difficulty_color === 'yellow' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400') }}">
                            {{ $package->difficulty_label }}
                        </span>
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.tour-packages.show', $package) }}" class="p-2 text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors" title="View">
                                <i class='bx bx-show text-lg'></i>
                            </a>
                            <a href="{{ route('admin.tour-packages.edit', $package) }}" class="p-2 text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-lg transition-colors" title="Edit">
                                <i class='bx bx-edit text-lg'></i>
                            </a>
                            <form action="{{ route('admin.tour-packages.destroy', $package) }}" method="POST" class="inline" onsubmit="return confirm('Delete this package?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors" title="Delete">
                                    <i class='bx bx-trash text-lg'></i>
                                </button>
                            </form>
                        </div>
                        <div class="flex items-center gap-1">
                            <form action="{{ route('admin.tour-packages.toggle-featured', $package) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="p-2 {{ $package->is_featured ? 'text-amber-500' : 'text-gray-400' }} hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/20 rounded-lg transition-colors" title="{{ $package->is_featured ? 'Remove from featured' : 'Mark as featured' }}">
                                    <i class='bx {{ $package->is_featured ? 'bxs' : 'bx' }}-star text-lg'></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.tour-packages.toggle-active', $package) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="p-2 {{ $package->is_active ? 'text-green-500' : 'text-gray-400' }} hover:text-green-600 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-lg transition-colors" title="{{ $package->is_active ? 'Unpublish' : 'Publish' }}">
                                    <i class='bx {{ $package->is_active ? 'bxs' : 'bx' }}-check-circle text-lg'></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white dark:bg-gray-800 rounded-xl shadow-sm ring-1 ring-gray-900/5 p-12 text-center">
                <div class="w-16 h-16 mx-auto bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                    <i class='bx bx-map-pin text-3xl text-gray-400'></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">No tour packages found</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new package.</p>
                <a href="{{ route('admin.tour-packages.create') }}" class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-500 transition-colors">
                    <i class='bx bx-plus'></i> Add Package
                </a>
            </div>
        @endforelse
    </div>

    <x-card-pagination :items="$packages" />
</x-app-layout>
