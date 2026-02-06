<x-app-layout>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">Driver Portal</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-400">View your trip schedule and track earnings.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none flex items-center gap-3">
            <button type="button" onclick="startScanner()"
                class="rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                <i class='bx bx-qr-scan align-middle mr-1'></i> Scan Passenger
            </button>
        </div>
    </div>

    <!-- Scanner Section (Hidden by default, toggled via Alpine or simple JS for MVP) -->
    <div id="scanner-container" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                Scan Customer QR</h3>
                            <div class="mt-4">
                                <div id="reader" style="width: 100%"></div>
                                <div id="scan-result" class="mt-2 text-sm text-center font-bold text-green-600"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="stopScanner()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        let html5QrcodeScanner;

        function startScanner() {
            document.getElementById('scanner-container').classList.remove('hidden');
            html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", { fps: 10, qrbox: 250 });

            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        }

        function stopScanner() {
            document.getElementById('scanner-container').classList.add('hidden');
            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear().catch(error => {
                    console.error("Failed to clear html5QrcodeScanner. ", error);
                });
            }
        }

        function onScanSuccess(decodedText, decodedResult) {
            // Handle on success condition with the decoded text: order ID
            console.log(`Scan result: ${decodedText}`);

            // Call API to verify
            fetch(`/orders/${decodedText}/verify`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('scan-result').innerText = "Verified! " + data.message;
                        setTimeout(() => {
                            stopScanner();
                            window.location.reload();
                        }, 2000);
                    } else {
                        alert('Verification Failed: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error processing scan.');
                });
        }

        function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning.
            // console.warn(`Code scan error = ${error}`);
        }
    </script>
    <!-- Stats Overview -->
    <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Earnings -->
        <div
            class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 p-5 shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700/40 sm:px-6 sm:pt-6">
            <dt>
                <div class="absolute rounded-md bg-primary-600/10 h-12 w-12 flex items-center justify-center">
                    <i class='bx bx-wallet text-primary-600 text-xl'></i>
                </div>
                <p class="ml-16 truncate text-sm font-medium text-gray-500 dark:text-gray-400">Today's Earnings</p>
            </dt>
            <dd class="ml-16 flex items-baseline pb-1 sm:pb-2">
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">RM{{ number_format($todayEarnings, 2) }}
                </p>
            </dd>
        </div>

        <!-- Total Orders -->
        <div
            class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 p-5 shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700/40 sm:px-6 sm:pt-6">
            <dt>
                <div class="absolute rounded-md bg-blue-600/10 h-12 w-12 flex items-center justify-center">
                    <i class='bx bx-list-ul text-blue-600 text-xl'></i>
                </div>
                <p class="ml-16 truncate text-sm font-medium text-gray-500 dark:text-gray-400">Total Orders</p>
            </dt>
            <dd class="ml-16 flex items-baseline pb-1 sm:pb-2">
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalOrders }}</p>
            </dd>
        </div>

        <!-- Trips Completed -->
        <div
            class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 p-5 shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700/40 sm:px-6 sm:pt-6">
            <dt>
                <div class="absolute rounded-md bg-green-600/10 h-12 w-12 flex items-center justify-center">
                    <i class='bx bx-check-circle text-green-600 text-xl'></i>
                </div>
                <p class="ml-16 truncate text-sm font-medium text-gray-500 dark:text-gray-400">Trips Completed</p>
            </dt>
            <dd class="ml-16 flex items-baseline pb-1 sm:pb-2">
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $tripsCompleted }}</p>
            </dd>
        </div>

        <!-- Rating -->
        <div
            class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 p-5 shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700/40 sm:px-6 sm:pt-6">
            <dt>
                <div class="absolute rounded-md bg-yellow-600/10 h-12 w-12 flex items-center justify-center">
                    <i class='bx bx-star text-yellow-600 text-xl'></i>
                </div>
                <p class="ml-16 truncate text-sm font-medium text-gray-500 dark:text-gray-400">Average Rating</p>
            </dt>
            <dd class="ml-16 flex items-baseline pb-1 sm:pb-2">
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $rating }} ★</p>
            </dd>
        </div>
    </div>

    <!-- Details Section -->
    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Driver Profile -->
        <div
            class="flex flex-col overflow-hidden rounded-xl bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700/40">
            <div class="border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 px-6 py-4">
                <div class="flex items-center gap-x-3">
                    <div
                        class="h-10 w-10 flex items-center justify-center bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                        <i class='bx bx-id-card text-purple-600 dark:text-purple-400 text-xl'></i>
                    </div>
                    <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white">Driver Profile</h3>
                </div>
            </div>
            <div class="flex-1 px-6 py-5">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Full Name</dt>
                        <dd class="mt-1 text-sm font-medium text-gray-900 dark:text-white">{{ auth()->user()->name }}
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Email Address</dt>
                        <dd class="mt-1 text-sm font-medium text-gray-900 dark:text-white truncate">
                            {{ auth()->user()->email }}
                        </dd>
                    </div>
                    <div class="sm:col-span-2 border-t border-gray-100 dark:border-gray-700 pt-4 flex gap-3">
                        <span
                            class="inline-flex items-center rounded-md bg-purple-50 dark:bg-purple-900/20 px-2.5 py-1 text-xs font-medium text-purple-700 dark:text-purple-400 ring-1 ring-inset ring-purple-600/20">
                            {{ ucfirst(auth()->user()->role) }}
                        </span>
                        <span
                            class="inline-flex items-center rounded-md bg-gray-50 dark:bg-gray-700/50 px-2.5 py-1 text-xs font-medium text-gray-600 dark:text-gray-400 ring-1 ring-inset ring-gray-500/10 dark:ring-gray-400/20">
                            Since {{ auth()->user()->created_at->format('M Y') }}
                        </span>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Vehicle Details -->
        <div
            class="flex flex-col overflow-hidden rounded-xl bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700/40">
            <div class="border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 px-6 py-4">
                <div class="flex items-center gap-x-3">
                    <div class="h-10 w-10 flex items-center justify-center bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <i class='bx bx-car text-blue-600 dark:text-blue-400 text-xl'></i>
                    </div>
                    <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white">Assigned Vehicle</h3>
                </div>
            </div>
            <div class="flex-1 px-6 py-5">
                @if($vehicle)
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">License Plate</dt>
                            <dd class="mt-1 text-lg font-bold text-gray-900 dark:text-white tracking-wide">
                                {{ $vehicle->license_plate }}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Vehicle Model</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-900 dark:text-white">{{ $vehicle->make }}
                                {{ $vehicle->model }}
                            </dd>
                        </div>
                        <div
                            class="sm:col-span-2 border-t border-gray-100 dark:border-gray-700 pt-4 flex justify-between items-center">
                            <span class="text-xs text-gray-500 dark:text-gray-400">Year: {{ $vehicle->year }}</span>
                            <span
                                class="inline-flex items-center rounded-md bg-green-50 dark:bg-green-900/20 px-2.5 py-1 text-xs font-medium text-green-700 dark:text-green-400 ring-1 ring-inset ring-green-600/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-600 mr-1.5"></span>
                                {{ ucfirst($vehicle->status) }}
                            </span>
                        </div>
                    </dl>
                @else
                    <div class="flex flex-col items-center justify-center h-full py-2 text-center">
                        <i class='bx bx-no-entry text-gray-300 text-4xl mb-2'></i>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">No Vehicle Assigned</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Please contact your manager to assign a
                            vehicle.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Trip Timeline -->
    <div class="mt-8">
        <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white mb-4">Today's Schedule</h3>
        <div class="space-y-6">
            @forelse($todaysTrips as $trip)
                    <div
                        class="group relative bg-white dark:bg-gray-800 rounded-2xl shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-700 transition-all hover:shadow-lg">
                        <!-- Status Indicator Strip -->
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 rounded-l-2xl 
                                {{ $trip->status === 'active' ? 'bg-blue-500' :
                ($trip->status === 'completed' ? 'bg-green-500' :
                    ($trip->status === 'cancelled' ? 'bg-red-500' : 'bg-amber-400')) }}">
                        </div>

                        <div class="p-5 pl-7 sm:p-6 sm:pl-8">
                            <!-- Header: Time & Status Badge -->
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <span
                                        class="text-xs font-bold tracking-wider text-gray-500 dark:text-gray-400 uppercase">Scheduled
                                        Time</span>
                                    <div class="flex items-baseline gap-2 mt-1">
                                        <h4 class="text-2xl font-bold text-gray-900 dark:text-white">
                                            {{ $trip->created_at->format('h:i') }}</h4>
                                        <span
                                            class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $trip->created_at->format('A') }}</span>
                                    </div>
                                </div>
                                <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-medium 
                                        {{ $trip->status === 'active' ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' :
                ($trip->status === 'completed' ? 'bg-green-50 text-green-700 dark:bg-green-900/30 dark:text-green-300' :
                    ($trip->status === 'cancelled' ? 'bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-300' :
                        'bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300')) }}">
                                    <span
                                        class="w-1.5 h-1.5 rounded-full {{ $trip->status === 'active' ? 'bg-blue-500' : ($trip->status === 'completed' ? 'bg-green-500' : ($trip->status === 'cancelled' ? 'bg-red-500' : 'bg-amber-500')) }}"></span>
                                    {{ ucfirst($trip->status) }}
                                </span>
                            </div>

                        <!-- Route Section -->
                        <div class="py-6 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex flex-col xl:flex-row xl:items-center gap-4">
                                <!-- Pickup (Left) -->
                                <div class="w-full xl:flex-none xl:max-w-[40%]">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-3 h-3 rounded-full border-[3px] border-blue-500 bg-white dark:bg-gray-900"></div>
                                        <p class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-widest">Pickup</p>
                                    </div>
                                    <p class="text-base font-medium text-gray-900 dark:text-white leading-snug" title="{{ $trip->pickup_address }}">
                                        {{ $trip->pickup_address }}
                                    </p>
                                </div>

                                <!-- Dotted Line (Flexible Fill) -->
                                <div class="hidden xl:flex items-center flex-1 px-4">
                                    <div class="w-full border-t-2 border-dotted border-gray-300 dark:border-gray-600 relative">
                                        <i class='bx bxs-right-arrow absolute -right-1.5 -top-1.5 text-gray-300 dark:text-gray-600 text-xs'></i>
                                    </div>
                                </div>

                                <!-- Dropoff (Right) -->
                                <div class="w-full xl:flex-none xl:max-w-[40%] xl:text-right">
                                    <div class="flex items-center xl:justify-end gap-3 mb-2">
                                        <div class="xl:hidden w-3 h-3 rounded-full bg-red-500 border-2 border-red-100"></div>
                                        <p class="text-xs font-bold text-red-600 dark:text-red-400 uppercase tracking-widest">Dropoff</p>
                                        <div class="hidden xl:block w-3 h-3 rounded-full bg-red-500 border-2 border-red-100"></div>
                                    </div>
                                    <p class="text-base font-medium text-gray-900 dark:text-white leading-snug" title="{{ $trip->dropoff_address }}">
                                        {{ $trip->dropoff_address }}
                                    </p>
                                </div>
                            </div>
                        </div>

                            <!-- Footer: Customer & ID & Action -->
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mt-6">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="h-10 w-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                        <i class='bx bxs-user text-gray-400 text-xl'></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $trip->customer->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">#{{ substr($trip->id, 0, 8) }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    @if($trip->status === 'completed')
                                        <div class="text-right mr-2">
                                            <span class="block text-[10px] text-gray-500 uppercase">Fare</span>
                                            <span
                                                class="text-lg font-bold text-gray-900 dark:text-white">RM{{ number_format($trip->total_price, 2) }}</span>
                                        </div>
                                    @else
                                        <a href="{{ route('orders.show', $trip->id) }}"
                                            class="inline-flex items-center justify-center rounded-lg bg-gray-900 dark:bg-white px-5 py-2.5 text-sm font-semibold text-white dark:text-gray-900 shadow-sm hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors w-full sm:w-auto">
                                            View Details <i class='bx bx-right-arrow-alt ml-2 text-lg'></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
            @empty
                <div
                    class="text-center py-16 bg-white dark:bg-gray-800 rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700">
                    <div
                        class="mx-auto h-16 w-16 bg-gray-50 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                        <i class='bx bx-calendar text-3xl text-gray-400'></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">No trips scheduled today</h3>
                    <p class="text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">Your schedule looks clear. Check back
                        later for new assignments.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>