@php
    $user = Auth::user();
    $role = $user?->role;
@endphp

@if($role)
    <li>
        <a href="{{ route('dashboard.' . $role) }}" 
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
            {{ request()->routeIs('dashboard.' . $role) 
                ? 'bg-primary-50 dark:bg-primary-600/10 text-primary-700 dark:text-primary-400' 
                : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
            <i class="bx bx-grid-alt text-xl"></i>
            <span>Dashboard</span>
        </a>
    </li>

    @if($role === 'superadmin')
        <li class="pt-4 mt-4 border-t border-gray-100 dark:border-gray-700/50">
            <span class="px-3 text-[10px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Management</span>
        </li>
        <li>
            <a href="{{ route('users.index') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('users.*') 
                    ? 'bg-primary-50 dark:bg-primary-600/10 text-primary-700 dark:text-primary-400' 
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                <i class="bx bx-user-circle text-xl"></i>
                <span>Users</span>
            </a>
        </li>
        <li>
            <a href="{{ route('customers.index') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('customers.*') 
                    ? 'bg-primary-50 dark:bg-primary-600/10 text-primary-700 dark:text-primary-400' 
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                <i class="bx bx-group text-xl"></i>
                <span>Customers</span>
            </a>
        </li>
        <li>
            <a href="{{ route('companies.index') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('companies.*') 
                    ? 'bg-primary-50 dark:bg-primary-600/10 text-primary-700 dark:text-primary-400' 
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                <i class="bx bx-building text-xl"></i>
                <span>Companies</span>
            </a>
        </li>
        <li>
            <a href="{{ route('vehicles.index') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('vehicles.*') 
                    ? 'bg-primary-50 dark:bg-primary-600/10 text-primary-700 dark:text-primary-400' 
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                <i class="bx bx-car text-xl"></i>
                <span>Vehicles</span>
            </a>
        </li>
        <li>
            <a href="{{ route('orders.index') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('orders.*') 
                    ? 'bg-primary-50 dark:bg-primary-600/10 text-primary-700 dark:text-primary-400' 
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                <i class="bx bx-receipt text-xl"></i>
                <span>Orders</span>
            </a>
        </li>

        <li class="pt-4 mt-4 border-t border-gray-100 dark:border-gray-700/50">
            <span class="px-3 text-[10px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Content</span>
        </li>
        <li>
            <a href="{{ route('admin.tour-packages.index') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('admin.tour-packages.*') 
                    ? 'bg-primary-50 dark:bg-primary-600/10 text-primary-700 dark:text-primary-400' 
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                <i class="bx bx-map-pin text-xl"></i>
                <span>Tour Packages</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.attractions.index') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('admin.attractions.*') 
                    ? 'bg-primary-50 dark:bg-primary-600/10 text-primary-700 dark:text-primary-400' 
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                <i class="bx bx-landscape text-xl"></i>
                <span>Attractions</span>
            </a>
        </li>

    @elseif($role === 'admin')
        <li class="pt-4 mt-4 border-t border-gray-100 dark:border-gray-700/50">
            <span class="px-3 text-[10px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Operations</span>
        </li>
        <li>
            <a href="{{ route('orders.index') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('orders.*') 
                    ? 'bg-primary-50 dark:bg-primary-600/10 text-primary-700 dark:text-primary-400' 
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                <i class="bx bx-receipt text-xl"></i>
                <span>Bookings</span>
            </a>
        </li>
        <li>
            <a href="{{ route('vehicles.index') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('vehicles.*') 
                    ? 'bg-primary-50 dark:bg-primary-600/10 text-primary-700 dark:text-primary-400' 
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                <i class="bx bx-car text-xl"></i>
                <span>Fleet</span>
            </a>
        </li>

    @elseif($role === 'driver')
        <li class="pt-4 mt-4 border-t border-gray-100 dark:border-gray-700/50">
            <span class="px-3 text-[10px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Trips</span>
        </li>
        <li>
            <a href="{{ route('orders.index') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('orders.*') 
                    ? 'bg-primary-50 dark:bg-primary-600/10 text-primary-700 dark:text-primary-400' 
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                <i class="bx bx-receipt text-xl"></i>
                <span>Orders</span>
            </a>
        </li>

    @elseif($role === 'company')
        <li class="pt-4 mt-4 border-t border-gray-100 dark:border-gray-700/50">
            <span class="px-3 text-[10px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Corporate</span>
        </li>
        <li>
            <a href="{{ route('users.index') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('users.*') 
                    ? 'bg-primary-50 dark:bg-primary-600/10 text-primary-700 dark:text-primary-400' 
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                <i class="bx bx-user-circle text-xl"></i>
                <span>Users</span>
            </a>
        </li>
        <li>
            <a href="{{ route('vehicles.index') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('vehicles.*') 
                    ? 'bg-primary-50 dark:bg-primary-600/10 text-primary-700 dark:text-primary-400' 
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                <i class="bx bx-car text-xl"></i>
                <span>Vehicles</span>
            </a>
        </li>
        <li>
            <a href="{{ route('orders.index') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('orders.*') 
                    ? 'bg-primary-50 dark:bg-primary-600/10 text-primary-700 dark:text-primary-400' 
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                <i class="bx bx-receipt text-xl"></i>
                <span>Orders</span>
            </a>
        </li>
        <li>
            <a href="{{ route('invoices.index') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('invoices.*') 
                    ? 'bg-primary-50 dark:bg-primary-600/10 text-primary-700 dark:text-primary-400' 
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                <i class="bx bx-file text-xl"></i>
                <span>Invoices</span>
            </a>
        </li>
    @endif

    <li class="pt-4 mt-4 border-t border-gray-100 dark:border-gray-700/50">
        <a href="{{ route('settings.edit') }}" 
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
            {{ request()->routeIs('settings.*') 
                ? 'bg-primary-50 dark:bg-primary-600/10 text-primary-700 dark:text-primary-400' 
                : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
            <i class="bx bx-cog text-xl"></i>
            <span>Settings</span>
        </a>
    </li>
@endif
