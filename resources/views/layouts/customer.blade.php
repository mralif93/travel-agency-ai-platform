@use('Illuminate\Support\Facades\Auth')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="h-full bg-gray-50 dark:bg-gray-900 {{ (Auth::guard('customer')->user()->theme_mode ?? 'light' === 'dark') ? 'dark' : '' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Customer Portal</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
    @include('layouts.theme-styles')
</head>

<body class="h-full font-sans antialiased text-gray-900 dark:text-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Top Navigation (Distinct from Admin Sidebar) -->
        <nav class="sticky top-0 z-50 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm"
            x-data="{ mobileMenuOpen: false }">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex">
                        <div class="flex flex-shrink-0 items-center gap-2">
                            <div
                                class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center shadow-md">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                            <span
                                class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-purple-600 to-indigo-600">TravelAI
                                Portal</span>
                        </div>
                        <div class="hidden sm:ml-8 sm:flex sm:space-x-8">
                            <!-- Current: "border-primary-500 text-gray-900", Default: "border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700" -->
                            <a href="{{ route('dashboard.customer') }}"
                                class="{{ request()->routeIs('dashboard.customer') ? 'border-primary-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-400 hover:border-gray-300 hover:text-gray-700 dark:hover:text-gray-300' }} inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium transition-colors duration-150">
                                Dashboard
                            </a>
                            <a href="{{ route('customer.trips') }}"
                                class="{{ request()->routeIs('customer.trips') ? 'border-primary-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-400 hover:border-gray-300 hover:text-gray-700 dark:hover:text-gray-300' }} inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium transition-colors duration-150">
                                My Trips
                            </a>
                            <a href="{{ route('transport-rates') }}"
                                class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-500 dark:text-gray-400 hover:border-gray-300 hover:text-gray-700 dark:hover:text-gray-300 transition-colors duration-150">
                                Book New Trip
                            </a>
                        </div>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:items-center">
                        <!-- Profile dropdown -->
                        <div class="relative ml-3" x-data="{ open: false }">
                            <div>
                                <button type="button" @click="open = !open" @click.away="open = false"
                                    class="relative flex rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:ring-offset-2 transition-all duration-200 hover:ring-2 hover:ring-primary-500/20"
                                    id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="absolute -inset-1.5"></span>
                                    <span class="sr-only">Open user menu</span>
                                    <div
                                        class="h-9 w-9 rounded-full bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/50 dark:to-purple-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold border border-indigo-100 dark:border-indigo-800 shadow-sm">
                                        {{ substr(Auth::guard('customer')->user()->name, 0, 1) }}
                                    </div>
                                </button>
                            </div>

                            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
                                x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                                x-transition:leave-end="transform opacity-0 scale-95 translate-y-2"
                                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-xl bg-white dark:bg-gray-800 py-1 shadow-xl border border-gray-100/50 dark:border-gray-700/50 focus:outline-none backdrop-blur-xl"
                                role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1"
                                x-cloak>
                                <div class="px-4 py-2 border-b border-gray-50 dark:border-gray-700/50 mb-1">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                        {{ Auth::guard('customer')->user()->name }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate mt-0.5">
                                        {{ Auth::guard('customer')->user()->email }}
                                    </p>
                                </div>
                                <a href="{{ route('customer.profile.edit') }}"
                                    class="group flex items-center px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-primary-900/10 hover:text-primary-600 dark:hover:text-primary-400 transition-colors"
                                    role="menuitem" tabindex="-1" id="user-menu-item-0">
                                    <i
                                        class='bx bx-user mr-3 text-lg text-gray-400 group-hover:text-primary-500 transition-colors'></i>
                                    Profile
                                </a>
                                <a href="#"
                                    class="group flex items-center px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-primary-900/10 hover:text-primary-600 dark:hover:text-primary-400 transition-colors"
                                    role="menuitem" tabindex="-1" id="user-menu-item-1">
                                    <i
                                        class='bx bx-cog mr-3 text-lg text-gray-400 group-hover:text-primary-500 transition-colors'></i>
                                    Settings
                                </a>

                                <div class="border-t border-gray-50 dark:border-gray-700/50 my-1"></div>

                                <button type="button" onclick="confirmLogout()"
                                    class="group flex w-full items-center px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/10 hover:text-red-700 transition-colors"
                                    role="menuitem" tabindex="-1" id="user-menu-item-2">
                                    <i
                                        class='bx bx-log-out mr-3 text-lg text-red-400 group-hover:text-red-600 transition-colors'></i>
                                    Sign out
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Mobile Login Button -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button type="button" @click="mobileMenuOpen = !mobileMenuOpen"
                            class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500"
                            aria-controls="mobile-menu" aria-expanded="false">
                            <span class="absolute -inset-0.5"></span>
                            <span class="sr-only">Open main menu</span>
                            <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu, show/hide based on menu state. -->
            <div class="sm:hidden" id="mobile-menu" x-show="mobileMenuOpen" x-collapse>
                <div class="space-y-1 pb-3 pt-2">
                    <a href="{{ route('dashboard.customer') }}"
                        class="block border-l-4 border-primary-500 bg-primary-50 py-2 pl-3 pr-4 text-base font-medium text-primary-700">Dashboard</a>
                    <a href="{{ route('customer.trips') }}"
                        class="block border-l-4 border-transparent py-2 pl-3 pr-4 text-base font-medium text-gray-500 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-700">My
                        Trips</a>
                    <a href="{{ route('transport-rates') }}"
                        class="block border-l-4 border-transparent py-2 pl-3 pr-4 text-base font-medium text-gray-500 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-700">Book
                        New Trip</a>
                </div>
                <!-- Mobile Profile -->
                <div class="border-t border-gray-200 pb-3 pt-4">
                    <div class="flex items-center px-4">
                        <div class="flex-shrink-0">
                            <div
                                class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold border border-indigo-200">
                                {{ substr(Auth::guard('customer')->user()->name, 0, 1) }}
                            </div>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-gray-800">{{ Auth::guard('customer')->user()->name }}
                            </div>
                            <div class="text-sm font-medium text-gray-500">{{ Auth::guard('customer')->user()->email }}
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 space-y-1">
                        <a href="{{ route('customer.profile.edit') }}"
                            class="block px-4 py-2 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800">Your
                            Profile</a>
                        <a href="#"
                            class="block px-4 py-2 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800">Settings</a>
                        <button onclick="confirmLogout()"
                            class="block w-full text-left px-4 py-2 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800">Sign
                            out</button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1">
            <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                <!-- Content Slot -->
                {{ $slot }}
            </div>
        </main>

        <!-- Simple Footer -->
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 mt-auto">
            <div class="mx-auto max-w-7xl px-6 py-4 md:flex md:items-center md:justify-between lg:px-8">
                <div class="md:order-1">
                    <p class="text-center text-xs leading-5 text-gray-500 dark:text-gray-400">&copy; {{ date('Y') }}
                        TravelAI. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Hidden Logout Form -->
    <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Ready to Leave?',
                text: "You will be logged out of your session.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, log out',
                background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#fff',
                color: document.documentElement.classList.contains('dark') ? '#fff' : '#1f2937'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            })
        }
    </script>
    @include('components.sweetalert')
</body>

</html>