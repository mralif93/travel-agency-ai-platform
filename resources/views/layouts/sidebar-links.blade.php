@php
    $user = Auth::user();
    $customer = Auth::guard('customer')->user();

    if ($user) {
        $role = $user->role;
    } elseif ($customer) {
        $role = 'customer';
    } else {
        $role = null;
    }
@endphp

@if($role === 'customer')
    <li>
        <a href="{{ route('dashboard.customer') }}"
            class="{{ request()->routeIs('dashboard.customer') ? 'bg-primary-50 dark:bg-primary-900/10 text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-400 hover:text-primary-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
            <i class='bx bx-home text-xl shrink-0 text-gray-400 group-hover:text-primary-600 transition-colors'></i>
            My Dashboard
        </a>
    </li>
    <li>
        <a href="#"
            class="text-gray-700 dark:text-gray-400 hover:text-primary-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
            <i class='bx bx-history text-xl shrink-0 text-gray-400 group-hover:text-primary-600 transition-colors'></i>
            Trip History
        </a>
    </li>
@endif

<!-- Common Dashboard Link (Hide for Customer as they have custom one above, and hide if no role) -->
@if($role && $role !== 'customer')
    <li>
        <a href="{{ route('dashboard.' . $role) }}"
            class="{{ request()->routeIs('dashboard.' . $role) ? 'bg-primary-50 dark:bg-primary-900/10 text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-400 hover:text-primary-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
            <i class='bx bx-home text-xl shrink-0 text-gray-400 group-hover:text-primary-600 transition-colors'></i>
            Dashboard
        </a>
    </li>
@endif

@if($role === 'superadmin')
    <li class="mt-4 text-xs font-semibold leading-6 text-gray-400 dark:text-gray-500">System</li>
    <li>
        <a href="{{ route('users.index') }}"
            class="{{ request()->routeIs('users.*') ? 'bg-primary-50 dark:bg-primary-900/10 text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-400 hover:text-primary-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
            <i class='bx bx-group text-xl shrink-0 text-gray-400 group-hover:text-primary-600 transition-colors'></i>
            Users
        </a>
    </li>
    <li>
        <a href="{{ route('customers.index') }}"
            class="{{ request()->routeIs('customers.*') ? 'bg-primary-50 dark:bg-primary-900/10 text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-400 hover:text-primary-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
            <i class='bx bx-user text-xl shrink-0 text-gray-400 group-hover:text-primary-600 transition-colors'></i>
            Customers
        </a>
    </li>
    <li>
        <a href="{{ route('companies.index') }}"
            class="{{ request()->routeIs('companies.*') ? 'bg-primary-50 dark:bg-primary-900/10 text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-400 hover:text-primary-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
            <i class='bx bx-building text-xl shrink-0 text-gray-400 group-hover:text-primary-600 transition-colors'></i>
            Companies
        </a>
    </li>
    <li>
        <a href="{{ route('vehicles.index') }}"
            class="{{ request()->routeIs('vehicles.*') ? 'bg-primary-50 dark:bg-primary-900/10 text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-400 hover:text-primary-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
            <i class='bx bx-car text-xl shrink-0 text-gray-400 group-hover:text-primary-600 transition-colors'></i>
            Vehicles
        </a>
    </li>
    <li>
        <a href="{{ route('orders.index') }}"
            class="{{ request()->routeIs('orders.*') ? 'bg-primary-50 dark:bg-primary-900/10 text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-400 hover:text-primary-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
            <i class='bx bx-trip text-xl shrink-0 text-gray-400 group-hover:text-primary-600 transition-colors'></i>
            Orders
        </a>
    </li>

@endif

@if($role === 'admin')
    <li class="mt-4 text-xs font-semibold leading-6 text-gray-400 dark:text-gray-500">Operation Control</li>
    <li>
        <a href="#"
            class="text-gray-700 dark:text-gray-400 hover:text-primary-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
            <i class='bx bx-book text-xl shrink-0 text-gray-400 group-hover:text-primary-600 transition-colors'></i>
            Bookings
        </a>
    </li>
    <li>
        <a href="{{ route('vehicles.index') }}"
            class="{{ request()->routeIs('vehicles.*') ? 'bg-primary-50 dark:bg-primary-900/10 text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-400 hover:text-primary-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
            <i class='bx bx-car text-xl shrink-0 text-gray-400 group-hover:text-primary-600 transition-colors'></i>
            Fleet
        </a>
    </li>
@endif

@if($role === 'driver')
    <li class="mt-4 text-xs font-semibold leading-6 text-gray-400 dark:text-gray-500">Trip Actions</li>

    <li>
        <a href="{{ route('orders.index') }}"
            class="{{ request()->routeIs('orders.*') ? 'bg-primary-50 dark:bg-primary-900/10 text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-400 hover:text-primary-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
            <i class='bx bx-trip text-xl shrink-0 text-gray-400 group-hover:text-primary-600 transition-colors'></i>
            Orders
        </a>
    </li>
@endif

@if($role === 'company')
    <li class="mt-4 text-xs font-semibold leading-6 text-gray-400 dark:text-gray-500">Corporate Tools</li>
    <li>
        <a href="{{ route('users.index') }}"
            class="{{ request()->routeIs('users.*') ? 'bg-primary-50 dark:bg-primary-900/10 text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-400 hover:text-primary-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
            <i class='bx bx-group text-xl shrink-0 text-gray-400 group-hover:text-primary-600 transition-colors'></i>
            Users
        </a>
    </li>
    <li>
        <a href="{{ route('vehicles.index') }}"
            class="{{ request()->routeIs('vehicles.*') ? 'bg-primary-50 dark:bg-primary-900/10 text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-400 hover:text-primary-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
            <i class='bx bx-car text-xl shrink-0 text-gray-400 group-hover:text-primary-600 transition-colors'></i>
            Vehicles
        </a>
    </li>
    <li>
        <a href="{{ route('invoices.index') }}"
            class="{{ request()->routeIs('invoices.*') ? 'bg-primary-50 dark:bg-primary-900/10 text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-400 hover:text-primary-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
            <i class='bx bx-receipt text-xl shrink-0 text-gray-400 group-hover:text-primary-600 transition-colors'></i>
            Invoices
        </a>
    </li>
    <li>
        <a href="{{ route('orders.index') }}"
            class="{{ request()->routeIs('orders.*') ? 'bg-primary-50 dark:bg-primary-900/10 text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-400 hover:text-primary-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
            <i class='bx bx-trip text-xl shrink-0 text-gray-400 group-hover:text-primary-600 transition-colors'></i>
            Orders
        </a>
    </li>
@endif

<!-- Common Settings Link -->
<li>
    <a href="{{ route('settings.edit') }}"
        class="{{ request()->routeIs('settings.*') ? 'bg-primary-50 dark:bg-primary-900/10 text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-400 hover:text-primary-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
        <i class='bx bx-cog text-xl shrink-0 text-gray-400 group-hover:text-primary-600 transition-colors'></i>
        Settings
    </a>
</li>