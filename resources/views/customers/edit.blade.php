<x-app-layout>
    <div class="sm:flex sm:items-center mb-8">
        <div class="sm:flex-auto">
            <nav class="flex items-center gap-x-2 text-sm text-gray-500 dark:text-gray-400 mb-2">
                <a href="{{ route('customers.index') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Customers</a>
                <i class='bx bx-chevron-right text-gray-300 dark:text-gray-600'></i>
                <span class="text-gray-900 dark:text-white font-medium">Edit</span>
            </nav>
            <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">Edit Customer</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-400">Update customer information.</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
        <form method="post" action="{{ route('customers.update', $customer) }}">
            @csrf
            @method('PUT')

            <div class="px-4 py-6 sm:p-8">
                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="name" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Full Name</label>
                        <div class="mt-2">
                            <input type="text" name="name" id="name" autocomplete="name"
                                value="{{ old('name', $customer->name) }}"
                                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 dark:text-white dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6">
                        </div>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Email</label>
                        <div class="mt-2">
                            <input type="email" name="email" id="email" autocomplete="email"
                                value="{{ old('email', $customer->email) }}"
                                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 dark:text-white dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6">
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="phone" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Phone</label>
                        <div class="mt-2">
                            <input type="text" name="phone" id="phone" autocomplete="tel"
                                value="{{ old('phone', $customer->phone) }}"
                                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 dark:text-white dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6">
                        </div>
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-6">
                        <label for="address" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Address</label>
                        <div class="mt-2">
                            <textarea id="address" name="address" rows="3"
                                class="block w-full rounded-lg border-0 py-2.5 text-gray-900 dark:text-white dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 sm:text-sm sm:leading-6">{{ old('address', $customer->address) }}</textarea>
                        </div>
                        @error('address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end border-t border-gray-900/10 dark:border-gray-700 px-4 py-4 sm:px-8">
                <div class="flex items-center gap-x-6">
                    <a href="{{ route('customers.index') }}" class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">Cancel</a>
                    <button type="submit" class="rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                        Save Changes
                    </button>
                </div>
            </div>
        </form>

        <!-- Reset Password Section -->
        <div class="border-t border-gray-900/10 dark:border-gray-700 px-4 py-6 sm:px-8 bg-gradient-to-r from-orange-50 to-amber-50 dark:from-orange-900/10 dark:to-amber-900/10">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class='bx bx-lock text-orange-500'></i>
                        Password Reset
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Reset the customer's password to the default: <code class="bg-orange-100 dark:bg-orange-900/30 px-1.5 py-0.5 rounded text-orange-700 dark:text-orange-400 font-mono text-xs">P@ssw0rd123</code>
                    </p>
                </div>
                <form action="{{ route('customers.reset-password', $customer) }}" method="POST" id="reset-password-form">
                    @csrf
                    <button type="button" 
                        class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-orange-700 dark:text-orange-400 bg-white dark:bg-gray-800 border border-orange-200 dark:border-orange-800 hover:bg-orange-50 dark:hover:bg-orange-900/20 rounded-lg transition-all shadow-sm"
                        data-customer-name="{{ $customer->name }}"
                        onclick="confirmResetPassword(this)">
                        <i class='bx bx-refresh text-lg'></i>
                        Reset Password
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        var isDark = document.documentElement.classList.contains('dark');

        function confirmResetPassword(button) {
            var customerName = button.getAttribute('data-customer-name');
            
            Swal.fire({
                title: 'Reset Password?',
                html: '<div style="text-align: center;">' +
                    '<div style="background: #f3f4f6; border-radius: 12px; padding: 16px; margin-bottom: 16px;">' +
                    '<p style="color: #6b7280; font-size: 13px; margin-bottom: 8px;">You are about to reset the password for</p>' +
                    '<p style="font-weight: 600; color: #111827; font-size: 16px;">' + escapeHtml(customerName) + '</p>' +
                    '</div>' +
                    '<p style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">The password will be reset to:</p>' +
                    '<code style="display: inline-block; padding: 8px 16px; background: #fef3c7; color: #92400e; border-radius: 8px; font-family: monospace; font-size: 15px; font-weight: 600;">P@ssw0rd123</code>' +
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
                    document.getElementById('reset-password-form').submit();
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
