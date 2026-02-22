<x-app-layout>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">Customers</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-400">A list of all the customers in your account.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <a href="{{ route('customers.create') }}"
                class="block rounded-md bg-primary-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                <i class='bx bx-plus align-middle mr-1'></i>Create Customer
            </a>
        </div>
    </div>

    <div class="mt-8 bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
        <div class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700 px-4 py-3 sm:px-6">
            <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white">Search and Filter</h3>
        </div>
        <div class="p-4 sm:p-6">
            <form action="{{ route('customers.index') }}" method="GET">
                <div class="flex flex-col sm:flex-row gap-4 items-end">
                    <div class="w-full sm:flex-1">
                        <label for="search" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                        <div class="relative rounded-md">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class='bx bx-search text-gray-400 text-lg'></i>
                            </div>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                class="block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 dark:ring-gray-600 pl-10 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-gray-900 dark:text-white h-10"
                                placeholder="Name, Email or Phone">
                        </div>
                    </div>
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-md bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 h-10">
                        Filter
                    </button>
                    <a href="{{ route('customers.index') }}"
                        class="inline-flex items-center justify-center rounded-md bg-white dark:bg-gray-700 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 h-10"
                        title="Reset Filters">
                        <i class='bx bx-reset text-lg'></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 sm:pl-6">Name</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Email</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Phone</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Password</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                            @forelse ($customers as $customer)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-white sm:pl-6">
                                        {{ $customer->name }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $customer->email }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $customer->phone ?? 'N/A' }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                                        @if($customer->force_password_change)
                                            <span class="inline-flex items-center gap-1 rounded-md bg-amber-50 dark:bg-amber-900/20 px-2 py-1 text-xs font-medium text-amber-700 dark:text-amber-400 ring-1 ring-inset ring-amber-600/20">
                                                <i class='bx bx-lock-alt'></i> Force Change
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 rounded-md bg-green-50 dark:bg-green-900/20 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-400 ring-1 ring-inset ring-green-600/20">
                                                <i class='bx bx-check'></i> Updated
                                            </span>
                                        @endif
                                    </td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <div class="flex items-center justify-end gap-1">
                                            @if(in_array(auth()->user()->role, ['superadmin', 'admin']))
                                                <form action="{{ route('customers.toggle-force-password', $customer) }}" method="POST" id="toggle-form-{{ $customer->id }}" class="inline-block">
                                                    @csrf
                                                    <button type="submit"
                                                        class="p-2 rounded-lg text-amber-600 hover:text-amber-900 hover:bg-amber-50 dark:text-amber-400 dark:hover:bg-amber-900/20 transition-colors"
                                                        title="{{ $customer->force_password_change ? 'Disable force password change' : 'Force password change on next login' }}"
                                                        onclick="return confirm('{{ $customer->force_password_change ? 'Disable force password change?' : 'Force customer to change password on next login?' }}')">
                                                        <i class='bx bx-key text-lg'></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('customers.show', $customer) }}"
                                                class="p-2 rounded-lg text-blue-600 hover:text-blue-900 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-900/20 transition-colors"
                                                title="View">
                                                <i class='bx bx-show text-lg'></i>
                                            </a>
                                            <a href="{{ route('customers.edit', $customer) }}"
                                                class="p-2 rounded-lg text-indigo-600 hover:text-indigo-900 hover:bg-indigo-50 dark:text-indigo-400 dark:hover:bg-indigo-900/20 transition-colors"
                                                title="Edit">
                                                <i class='bx bx-pencil text-lg'></i>
                                            </a>
                                            <button type="button"
                                                class="p-2 rounded-lg text-orange-600 hover:text-orange-900 hover:bg-orange-50 dark:text-orange-400 dark:hover:bg-orange-900/20 transition-colors"
                                                title="Reset Password"
                                                data-customer-id="{{ $customer->id }}"
                                                data-customer-name="{{ $customer->name }}"
                                                onclick="handleResetPassword(this)">
                                                <i class='bx bx-refresh text-lg'></i>
                                            </button>
                                            <button type="button"
                                                class="p-2 rounded-lg text-red-600 hover:text-red-900 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20 transition-colors"
                                                title="Delete"
                                                data-customer-id="{{ $customer->id }}"
                                                data-customer-name="{{ $customer->name }}"
                                                onclick="handleDelete(this)">
                                                <i class='bx bx-trash text-lg'></i>
                                            </button>

                                            <!-- Hidden Forms -->
                                            <form action="{{ route('customers.reset-password', $customer) }}" method="POST" id="reset-form-{{ $customer->id }}" class="hidden">
                                                @csrf
                                            </form>
                                            <form action="{{ route('customers.destroy', $customer) }}" method="POST" id="delete-form-{{ $customer->id }}" class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-3">
                                                <i class='bx bx-user text-2xl text-gray-400'></i>
                                            </div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">No customers found.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <x-card-pagination :items="$customers" />
                </div>
            </div>
        </div>
    </div>

    <script>
        var isDark = document.documentElement.classList.contains('dark');

        function handleResetPassword(button) {
            var customerId = button.getAttribute('data-customer-id');
            var customerName = button.getAttribute('data-customer-name');
            confirmResetPassword(customerId, customerName);
        }

        function handleDelete(button) {
            var customerId = button.getAttribute('data-customer-id');
            var customerName = button.getAttribute('data-customer-name');
            confirmDelete(customerId, customerName);
        }

        function confirmResetPassword(customerId, customerName) {
            Swal.fire({
                title: 'Reset Password?',
                html: '<div style="text-align: center;">' +
                    '<div style="background: #f3f4f6; border-radius: 12px; padding: 16px; margin-bottom: 16px;">' +
                    '<p style="color: #6b7280; font-size: 13px; margin-bottom: 8px;">You are about to reset the password for</p>' +
                    '<p style="font-weight: 600; color: #111827; font-size: 16px;">' + escapeHtml(customerName) + '</p>' +
                    '</div>' +
                    '<p style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">The password will be reset to:</p>' +
                    '<code style="display: inline-block; padding: 8px 16px; background: #fef3c7; color: #92400e; border-radius: 8px; font-family: monospace; font-size: 15px; font-weight: 600;">password</code>' +
                    '</div>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ea580c',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, reset it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                focusCancel: true,
                background: isDark ? '#1f2937' : '#fff',
                color: isDark ? '#f3f4f6' : '#1f2937',
                width: '380px',
                padding: '24px'
            }).then(function(result) {
                if (result.isConfirmed) {
                    document.getElementById('reset-form-' + customerId).submit();
                }
            });
        }

        function confirmDelete(customerId, customerName) {
            Swal.fire({
                title: 'Delete Customer?',
                html: '<div style="text-align: center;">' +
                    '<div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; padding: 16px; margin-bottom: 16px;">' +
                    '<p style="color: #6b7280; font-size: 13px; margin-bottom: 8px;">You are about to delete</p>' +
                    '<p style="font-weight: 600; color: #dc2626; font-size: 16px;">' + escapeHtml(customerName) + '</p>' +
                    '</div>' +
                    '<p style="font-size: 13px; color: #dc2626; font-weight: 600; margin-bottom: 4px;">This action cannot be undone!</p>' +
                    '<p style="font-size: 12px; color: #6b7280;">All associated data will be permanently removed.</p>' +
                    '</div>',
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                focusCancel: true,
                background: isDark ? '#1f2937' : '#fff',
                color: isDark ? '#f3f4f6' : '#1f2937',
                width: '380px',
                padding: '24px'
            }).then(function(result) {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + customerId).submit();
                }
            });
        }

        function escapeHtml(text) {
            if (!text) return '';
            var div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    </script>
</x-app-layout>
