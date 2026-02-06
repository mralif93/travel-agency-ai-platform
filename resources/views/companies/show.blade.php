<x-app-layout>
    <div class="sm:flex sm:items-center mb-8">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">Company Details</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-400">View detailed information about the company.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <a href="{{ route('companies.edit', $company) }}"
                class="block rounded-md bg-primary-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                <i class='bx bx-pencil align-middle mr-1'></i>Edit Company
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
        <div class="px-4 py-6 sm:p-0">
            <dl class="divide-y divide-gray-100 dark:divide-gray-700">
                <!-- Company Name -->
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Company Name</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                        {{ $company->name }}
                    </dd>
                </div>

                <!-- Email Address -->
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Email Address</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                        {{ $company->email }}
                    </dd>
                </div>

                <!-- Registration Number -->
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Registration Number</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                        {{ $company->registration_number ?? 'N/A' }}
                    </dd>
                </div>

                <!-- Phone -->
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Phone</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                        {{ $company->phone ?? 'N/A' }}
                    </dd>
                </div>

                <!-- Status -->
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Status</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                        @php
                            $statusClasses = [
                                'active' => 'bg-green-50 text-green-700 ring-green-600/20',
                                'inactive' => 'bg-gray-50 text-gray-600 ring-gray-500/10',
                            ];
                            $statusClass = $statusClasses[$company->status] ?? $statusClasses['inactive'];
                        @endphp
                        <span
                            class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $statusClass }}">
                            {{ ucfirst($company->status) }}
                        </span>
                    </dd>
                </div>

                <!-- Address -->
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Address</dt>
                    <dd
                        class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0 max-w-prose text-wrap">
                        {{ $company->address ?? 'N/A' }}
                    </dd>
                </div>

                <!-- Joined On -->
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-8">
                    <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Joined On</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-400 sm:col-span-2 sm:mt-0">
                        {{ $company->created_at->format('M d, Y') }}
                    </dd>
                </div>
            </dl>
        </div>
        <div
            class="bg-gray-50 dark:bg-gray-800/50 px-4 py-4 sm:px-8 border-t border-gray-100 dark:border-gray-700 flex justify-end">
            <a href="{{ route('companies.index') }}"
                class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white flex items-center">
                <i class='bx bx-arrow-back mr-1'></i>Back to Companies</a>
        </div>
    </div>
</x-app-layout>