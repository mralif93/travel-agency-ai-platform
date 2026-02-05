<x-app-layout>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">Orders</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-400">A list of all scheduled trips and orders.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <a href="{{ route('orders.create') }}"
                class="block rounded-md bg-primary-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                Create Order
            </a>
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
                                                <a href="{{ route('orders.create') }}" class="mt-2 text-primary-600 hover:text-primary-500 text-xs font-medium">Create New Order &rarr;</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        <div class="mt-4 px-4 sm:px-6 lg:px-8">
            {{ $orders->links() }}
        </div>
    </div>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
</x-app-layout>