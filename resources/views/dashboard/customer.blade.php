<x-customer-layout>
    <div class="space-y-8">
        <!-- Welcome Section -->
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h1
                    class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:truncate sm:text-3xl sm:tracking-tight">
                    Welcome back, {{ $user->name }}!
                </h1>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Track your active trips and view your travel
                    history.</p>
            </div>
            <div class="mt-4 sm:ml-4 sm:mt-0">
                <a href="{{ route('transport-rates') }}"
                    class="inline-flex items-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                    <i class='bx bx-plus mr-2'></i> New Booking
                </a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <!-- Pending -->
            <div
                class="overflow-hidden rounded-xl bg-white dark:bg-gray-800 p-6 shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700/40">
                <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Pending Orders</dt>
                <dd class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-semibold text-gray-900 dark:text-white">{{ $pendingOrders }}</span>
                    <span class="text-sm text-gray-500">requests</span>
                </dd>
            </div>

            <!-- Completed -->
            <div
                class="overflow-hidden rounded-xl bg-white dark:bg-gray-800 p-6 shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700/40">
                <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Completed Trips</dt>
                <dd class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl font-semibold text-gray-900 dark:text-white">{{ $completedOrders }}</span>
                    <span class="text-sm text-gray-500">trips</span>
                </dd>
            </div>

            <!-- Total Spent -->
            <div
                class="overflow-hidden rounded-xl bg-white dark:bg-gray-800 p-6 shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700/40">
                <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Total Spent</dt>
                <dd class="mt-2 flex items-baseline gap-2">
                    <span
                        class="text-3xl font-semibold text-gray-900 dark:text-white">RM{{ number_format($totalSpent, 2) }}</span>
                    <span class="text-sm text-gray-500">MYR</span>
                </dd>
            </div>
        </div>

        <!-- Recent Orders List -->
        <div
            class="overflow-hidden bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700/40 sm:rounded-xl">
            <div class="border-b border-gray-100 dark:border-gray-700 px-4 py-5 sm:px-6">
                <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white">Recent Orders</h3>
            </div>
            <ul role="list" class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($orders as $order)
                    <li
                        class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 dark:hover:bg-gray-700/50 sm:px-6 transition-colors">
                        <div class="flex min-w-0 gap-x-4">
                            <div class="min-w-0 flex-auto space-y-1">
                                <p class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">
                                    <span class="absolute inset-x-0 -top-px bottom-0"></span>
                                    #{{ substr($order->id, 0, 8) }}
                                </p>
                                <p class="mt-1 flex text-xs leading-5 text-gray-500 dark:text-gray-400">
                                    <span class="truncate">
                                        {{ $order->pickup_address }}
                                        <span class="mx-1">&rarr;</span>
                                        {{ $order->dropoff_address }}
                                    </span>
                                </p>
                                <p class="mt-1 text-xs leading-5 text-gray-400">
                                    {{ $order->created_at->format('M d, Y h:i A') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-y-2">
                            <div class="flex items-center gap-x-4">
                                <div class="hidden sm:flex sm:flex-col sm:items-end">
                                    <p class="text-sm leading-6 text-gray-900 dark:text-white font-medium">
                                        RM{{ number_format($order->total_price, 2) }}</p>
                                    <div class="mt-1 flex items-center gap-x-1.5">
                                        @php
                                            $colors = [
                                                'pending' => 'bg-yellow-500',
                                                'active' => 'bg-blue-500',
                                                'completed' => 'bg-green-500',
                                                'cancelled' => 'bg-red-500',
                                            ];
                                            $color = $colors[$order->status] ?? 'bg-gray-500';
                                        @endphp
                                        <div class="flex-none rounded-full {{ $color }}/20 p-1">
                                            <div class="h-1.5 w-1.5 rounded-full {{ $color }}"></div>
                                        </div>
                                        <p class="text-xs leading-5 text-gray-500 dark:text-gray-400 capitalize">
                                            {{ $order->status }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="relative z-10 flex items-center gap-x-3 mt-1">
                                <a href="{{ route('customer.trips.show', $order) }}"
                                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" title="View Details">
                                    <i class='bx bx-detail text-lg'></i>
                                </a>
                                <button type="button" onclick="showQrCode('{{ $order->id }}')"
                                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                                    title="QR Code">
                                    <i class='bx bx-qr text-lg'></i>
                                </button>

                                <!-- Hidden QR Code Content -->
                                <div id="qr-content-{{ $order->id }}" class="hidden">
                                    <div class="flex flex-col items-center justify-center p-2 text-center">
                                        <div
                                            class="bg-white p-2 rounded-lg border border-gray-100 shadow-sm inline-block mb-4">
                                            {!! QrCode::size(200)->color(0, 0, 0)->generate($order->id) !!}
                                        </div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Scan this code to verify
                                            your trip</p>

                                        <div class="w-full border-t border-gray-100 dark:border-gray-700 pt-4 mt-2">
                                            <p
                                                class="text-xs font-mono font-bold text-gray-400 uppercase tracking-wider mb-1">
                                                Order #{{ substr($order->id, 0, 8) }}</p>
                                            <div class="flex flex-col gap-1 text-sm text-gray-900 dark:text-gray-200">
                                                <span class="truncate w-full px-4">{{ $order->pickup_address }}</span>
                                                <i class='bx bx-down-arrow-alt text-gray-400'></i>
                                                <span class="truncate w-full px-4">{{ $order->dropoff_address }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ route('customer.trips.print', $order) }}" target="_blank"
                                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" title="Preview PDF">
                                    <i class='bx bxs-file-pdf text-lg'></i>
                                </a>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="px-4 py-8 text-center sm:px-6">
                        <p class="text-sm text-gray-500 dark:text-gray-400">No orders found.</p>
                        <a href="{{ route('transport-rates') }}"
                            class="mt-2 text-sm font-medium text-primary-600 hover:text-primary-500">Book your first trip
                            &rarr;</a>
                    </li>
                @endforelse
            </ul>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
    <script>
        function showQrCode(orderId) {
            const content = document.getElementById('qr-content-' + orderId).innerHTML;

            Swal.fire({
                title: 'Driver Scan',
                html: content,
                showConfirmButton: false,
                showCloseButton: true,
                width: 400,
                padding: '1.5em',
                background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#fff',
                color: document.documentElement.classList.contains('dark') ? '#fff' : '#1f2937'
            });
        }
    </script>
</x-customer-layout>