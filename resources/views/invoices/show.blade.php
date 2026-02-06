<x-app-layout>
    <div class="sm:flex sm:items-center mb-8">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">Invoice Details</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-400">View detailed information about the invoice.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <a href="{{ route('invoices.edit', $invoice) }}"
                class="block rounded-md bg-primary-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                <i class='bx bx-pencil align-middle mr-1'></i>Edit Invoice
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
        <div class="px-4 py-6 sm:p-0">
            <dl class="divide-y divide-gray-100 dark:divide-gray-700">
                <!-- Description -->
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Description</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                        {{ $invoice->description }}
                    </dd>
                </div>

                <!-- Issue Date -->
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Issue Date</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                        {{ $invoice->issue_date->format('M d, Y') }}
                    </dd>
                </div>

                <!-- Due Date -->
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Due Date</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                        {{ $invoice->due_date->format('M d, Y') }}
                    </dd>
                </div>

                <!-- Amount -->
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Amount</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                        ${{ number_format($invoice->amount, 2) }}
                    </dd>
                </div>

                <!-- Status -->
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Status</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                        @php
                            $statusClasses = [
                                'paid' => 'bg-green-50 text-green-700 ring-green-600/20',
                                'pending' => 'bg-yellow-50 text-yellow-800 ring-yellow-600/20',
                                'overdue' => 'bg-red-50 text-red-700 ring-red-600/20',
                            ];
                            $statusClass = $statusClasses[$invoice->status] ?? $statusClasses['pending'];
                        @endphp
                        <span
                            class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $statusClass }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </dd>
                </div>

                <!-- Created At -->
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Created At</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                        {{ $invoice->created_at->format('M d, Y H:i A') }}
                    </dd>
                </div>
            </dl>
        </div>
        <div
            class="bg-gray-50 dark:bg-gray-800/50 px-4 py-4 sm:px-8 border-t border-gray-100 dark:border-gray-700 flex justify-end">
            <a href="{{ route('invoices.index') }}"
                class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white flex items-center">
                <i class='bx bx-arrow-back mr-1'></i>Back to Invoices</a>
        </div>
    </div>
</x-app-layout>