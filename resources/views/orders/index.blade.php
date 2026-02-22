<x-app-layout>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">Orders</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-400">A list of all scheduled trips and orders.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            @if(auth()->user()->role !== 'driver')
            <a href="{{ route('orders.create') }}"
                class="block rounded-md bg-primary-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                <i class='bx bx-plus align-middle mr-1'></i>Create Order
            </a>
            @endif
        </div>
    </div>
    <!-- Filters -->
    <div class="mt-8 bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
        <div class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700 px-4 py-3 sm:px-6">
            <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white">Search and Filter</h3>
        </div>
        <div class="p-4 sm:p-6">
            <form action="{{ route('orders.index') }}" method="GET">
                <div class="flex flex-col sm:flex-row gap-4 items-end">
                    <!-- Search (Flex Grow) -->
                    <div class="w-full sm:flex-1">
                        <label for="search"
                            class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                        <div class="relative rounded-md">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class='bx bx-search text-gray-400 text-lg'></i>
                            </div>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                class="block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 dark:ring-gray-600 pl-10 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white h-10"
                                placeholder="Order ID or Customer Name">
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div class="w-full sm:w-44 text-sm">
                        <label for="status"
                            class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select name="status" id="status"
                            style="background-image: url(&quot;data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e&quot;); background-position: right 1rem center; background-repeat: no-repeat; background-size: 1.5em 1.5em; padding-right: 2.5rem !important;"
                            class="block w-full appearance-none rounded-md border-0 py-1.5 pl-3 text-gray-900 dark:text-gray-100 ring-1 ring-inset ring-gray-300 dark:ring-gray-600 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 h-10">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending (New)</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active (Current)</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <!-- Actions -->
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-md bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 h-10">
                        Filter
                    </button>

                    <a href="{{ route('orders.index') }}"
                        class="inline-flex items-center justify-center rounded-md bg-white dark:bg-gray-700 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 h-10"
                        title="Reset Filters">
                        <i class='bx bx-reset text-lg'></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-8 flow-root">
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div
                        class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50/50 dark:bg-gray-900/50">
                                <tr>
                                    <th scope="col"
                                        class="py-3.5 pl-4 pr-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider sm:pl-6">
                                        Order Info</th>
                                    <th scope="col"
                                        class="px-3 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Customer</th>
                                    <th scope="col"
                                        class="px-3 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Route Details</th>
                                    <th scope="col"
                                        class="px-3 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Price</th>
                                    <th scope="col"
                                        class="px-3 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                                @forelse ($orders as $order)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200 group">
                                        <!-- Order ID -->
                                        <td class="whitespace-nowrap py-3 pl-4 pr-3 sm:pl-6">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 group-hover:bg-primary-100 dark:group-hover:bg-primary-900/30 transition-colors">
                                                    <i class='bx bx-hash text-lg'></i>
                                                </div>
                                                <div>
                                                    <div class="font-mono text-sm font-bold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                                        #{{ substr($order->id, 0, 8) }}
                                                    </div>
                                                    <div class="text-[10px] text-gray-400 font-medium uppercase tracking-wide">{{ $order->created_at->format('M d, H:i') }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Customer -->
                                        <td class="whitespace-nowrap px-3 py-3">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 flex-shrink-0 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-[10px] font-bold text-gray-500 dark:text-gray-300 uppercase me-2.5">
                                                    {{ substr($order->customer->name, 0, 2) }}
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white leading-tight">{{ $order->customer->name }}</div>
                                                    <div class="text-xs text-gray-500 flex items-center gap-1 mt-0.5">
                                                        <i class='bx bx-phone text-[10px]'></i> 
                                                        {{ $order->customer->phone ?? '-' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Route -->
                                        <td class="px-3 py-3">
                                            <div class="flex flex-col gap-1.5 min-w-[300px]">
                                                <!-- Pickup -->
                                                <div class="flex items-center gap-2">
                                                    <i class='bx bx-current-location text-blue-500 text-base shrink-0'></i>
                                                    <span class="text-sm text-gray-900 dark:text-white truncate max-w-[350px] leading-tight" title="{{ $order->pickup_address }}">
                                                        {{ $order->pickup_address }}
                                                    </span>
                                                </div>
                                                
                                                <!-- Connector (Visual only) -->
                                                <div class="ml-[7px] w-0.5 h-3 bg-gray-200 dark:bg-gray-700 -my-1"></div>
                                                
                                                <!-- Dropoff -->
                                                <div class="flex items-center gap-2">
                                                    <i class='bx bxs-map text-red-500 text-base shrink-0'></i>
                                                    <span class="text-sm text-gray-900 dark:text-white truncate max-w-[350px] leading-tight" title="{{ $order->dropoff_address }}">
                                                        {{ $order->dropoff_address }}
                                                    </span>
                                                </div>
                                                
                                                <!-- Meta (Distance) -->
                                                <div class="pl-7 flex items-center gap-3 mt-0.5">
                                                     <span class="text-[10px] font-medium text-gray-400 dark:text-gray-500 bg-gray-50 dark:bg-gray-800 px-1.5 py-px rounded border border-gray-100 dark:border-gray-700">
                                                        {{ number_format($order->distance_km, 1) }} km
                                                    </span>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Price -->
                                        <td class="whitespace-nowrap px-3 py-3 text-right">
                                            <div class="text-sm font-bold text-gray-900 dark:text-white">
                                                RM{{ number_format($order->total_price, 2) }}
                                            </div>
                                        </td>

                                        <!-- Status -->
                                        <td class="whitespace-nowrap px-3 py-3 text-center">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-yellow-50 text-yellow-700 ring-yellow-600/20 dark:bg-yellow-900/30 dark:text-yellow-400',
                                                    'active' => 'bg-blue-50 text-blue-700 ring-blue-600/20 dark:bg-blue-900/30 dark:text-blue-400',
                                                    'completed' => 'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-900/30 dark:text-green-400',
                                                    'cancelled' => 'bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-900/30 dark:text-red-400',
                                                    'processing' => 'bg-blue-50 text-blue-700 ring-blue-600/20 dark:bg-blue-900/30 dark:text-blue-400',
                                                ];
                                                $colorClass = $statusColors[$order->status] ?? 'bg-gray-50 text-gray-600 ring-gray-500/10';
                                            @endphp
                                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-medium ring-1 ring-inset {{ $colorClass }} uppercase tracking-wide">
                                                {{ $order->status }}
                                            </span>
                                        </td>

                                        <!-- Actions -->
                                        <td class="relative whitespace-nowrap py-3 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('orders.show', $order) }}" 
                                                   class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-colors" 
                                                   title="View Details">
                                                    <i class='bx bx-show text-lg'></i>
                                                </a>
                                                @if(auth()->user()->role !== 'driver')
                                                <a href="{{ route('orders.edit', $order) }}" 
                                                   class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors" 
                                                   title="Edit Order">
                                                    <i class='bx bx-edit text-lg'></i>
                                                </a>
                                                
                                                <!-- Delete Button -->
                                                <button type="button" onclick="confirmDelete('{{ $order->id }}')"
                                                    class="flex items-center justify-center w-8 h-8 rounded-full bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors"
                                                    title="Delete Order">
                                                    <i class='bx bx-trash text-lg'></i>
                                                </button>
                                                @endif
                                                
                                                <form id="delete-form-{{ $order->id }}" action="{{ route('orders.destroy', $order) }}" method="POST" class="hidden">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-3 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="w-12 h-12 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-3">
                                                    <i class='bx bx-calendar-x text-2xl text-gray-400'></i>
                                                </div>
                                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">No orders found</h3>
                                                @if(auth()->user()->role !== 'driver')
                                                <a href="{{ route('orders.create') }}" class="mt-2 text-primary-600 hover:text-primary-500 text-xs font-medium">Create New Order &rarr;</a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <x-card-pagination :items="$orders" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id) {
            var isDark = document.documentElement.classList.contains('dark');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                background: isDark ? '#1f2937' : '#fff',
                color: isDark ? '#f3f4f6' : '#1f2937',
                width: '380px',
                padding: '24px'
            }).then(function(result) {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>