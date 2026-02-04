@php
    $role = Auth::user()->role;
@endphp

<!-- Common Dashboard Link -->
<li>
    <a href="{{ route('dashboard.' . $role) }}"
        class="{{ request()->routeIs('dashboard.' . $role) ? 'bg-primary-50 dark:bg-primary-900/10 text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-400 hover:text-primary-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
        <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
        </svg>
        Dashboard
    </a>
</li>

@if($role === 'superadmin')
    <li class="mt-4 text-xs font-semibold leading-6 text-gray-400 dark:text-gray-500">System Management</li>
    <li>
        <a href="{{ route('users.index') }}"
            class="{{ request()->routeIs('users.*') ? 'bg-primary-50 dark:bg-primary-900/10 text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-400 hover:text-primary-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
            <svg class="h-6 w-6 shrink-0 text-gray-400 group-hover:text-primary-600" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
            </svg>
            User Management
        </a>
    </li>
    <li>
        <a href="{{ route('customers.index') }}"
            class="{{ request()->routeIs('customers.*') ? 'bg-primary-50 dark:bg-primary-900/10 text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-400 hover:text-primary-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
            <svg class="h-6 w-6 shrink-0 text-gray-400 group-hover:text-primary-600" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
            </svg>
            Customers
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
        <a href="#"
            class="text-gray-700 dark:text-gray-400 hover:text-primary-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
            <svg class="h-6 w-6 shrink-0 text-gray-400 group-hover:text-primary-600" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
            </svg>
            Agency Analytics
        </a>
    </li>
@endif

@if($role === 'admin')
    <li class="mt-4 text-xs font-semibold leading-6 text-gray-400 dark:text-gray-500">Operation Control</li>
    <li>
        <a href="#"
            class="text-gray-700 dark:text-gray-400 hover:text-primary-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
            <svg class="h-6 w-6 shrink-0 text-gray-400 group-hover:text-primary-600" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v4.072c0 .37.144.722.4 1.01l7.25 8.192a1.125 1.125 0 001.69 0l8.192-7.25a1.125 1.125 0 000-1.69L10.5 4.375a1.125 1.125 0 00-1.011-.4h-4.072z" />
            </svg>
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
        <a href="{{ route('vehicles.index') }}"
            class="{{ request()->routeIs('vehicles.*') ? 'bg-primary-50 dark:bg-primary-900/10 text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-400 hover:text-primary-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
            <i class='bx bx-car text-xl shrink-0 text-gray-400 group-hover:text-primary-600 transition-colors'></i>
            My Vehicle
        </a>
    </li>
    <li>
        <a href="#"
            class="text-gray-700 dark:text-gray-400 hover:text-primary-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
            <svg class="h-6 w-6 shrink-0 text-gray-400 group-hover:text-primary-600" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
            </svg>
            Schedule
        </a>
    </li>
@endif

@if($role === 'company')
    <li class="mt-4 text-xs font-semibold leading-6 text-gray-400 dark:text-gray-500">Corporate Tools</li>
    <li>
        <a href="#"
            class="text-gray-700 dark:text-gray-400 hover:text-primary-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
            <svg class="h-6 w-6 shrink-0 text-gray-400 group-hover:text-primary-600" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Invoices
        </a>
    </li>
@endif

<!-- Common Settings Link -->
<li>
    <a href="{{ route('settings.edit') }}"
        class="{{ request()->routeIs('settings.*') ? 'bg-primary-50 dark:bg-primary-900/10 text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-400 hover:text-primary-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
        <svg class="h-6 w-6 shrink-0 text-gray-400 group-hover:text-primary-600" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 018.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.795c0 1.987-.25 3.97-.737 5.922" />
        </svg>
        Settings
    </a>
</li>