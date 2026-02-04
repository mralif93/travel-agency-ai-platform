@use('Illuminate\Support\Facades\Auth')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="h-full bg-gray-50 dark:bg-gray-900 {{ (Auth::user()->theme_mode === 'dark' || (Auth::user()->theme_mode === 'system' && request()->cookie('theme_preference') === 'dark')) ? 'dark' : '' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
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
    </style>
    @include('layouts.theme-styles')

    <!-- System Theme Detection -->
    @if(Auth::user()->theme_mode === 'system')
        <script>
            if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.classList.add('dark');
            }
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
                if (event.matches) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            });
        </script>
    @endif
</head>

<body class="h-full font-sans antialiased text-gray-900 dark:text-gray-100" x-data="{ sidebarOpen: false }">
    <!-- Off-canvas menu for mobile -->
    <div class="relative z-50 lg:hidden" role="dialog" aria-modal="true" x-show="sidebarOpen" x-cloak>
        <div class="fixed inset-0 bg-gray-900/80" aria-hidden="true" x-show="sidebarOpen"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

        <div class="fixed inset-0 flex">
            <div class="relative mr-16 flex w-full max-w-xs flex-1" x-show="sidebarOpen"
                x-transition:enter="transition ease-in-out duration-300 transform"
                x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in-out duration-300 transform"
                x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">

                <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                    <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
                        <span class="sr-only">Close sidebar</span>
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Mobile Sidebar Content -->
                <div
                    class="flex grow flex-col gap-y-5 overflow-y-auto bg-white dark:bg-gray-800 px-6 pb-4 ring-1 ring-white/10">
                    <div class="flex h-16 shrink-0 items-center">
                        <span
                            class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary-500 to-purple-600">TravelAI</span>
                    </div>
                    <nav class="flex flex-1 flex-col">
                        <ul role="list" class="flex flex-1 flex-col gap-y-7">
                            <li>
                                <ul role="list" class="-mx-2 space-y-1">
                                    @include('layouts.sidebar-links')
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Static sidebar for desktop -->
    <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
        <div
            class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-6 pb-4">
            <div class="flex h-16 shrink-0 items-center gap-2">
                <div
                    class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary-500 to-purple-600 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
                <span class="text-xl font-bold text-gray-900 dark:text-white">TravelAI</span>

                <!-- Role Badge -->
                @php
                    $roleConfig = [
                        'superadmin' => ['bg' => 'bg-primary-100 text-primary-700 dark:bg-primary-900/30 dark:text-primary-400', 'label' => 'Super'],
                        'admin' => ['bg' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400', 'label' => 'Admin'],
                        'driver' => ['bg' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400', 'label' => 'Driver'],
                        'company' => ['bg' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400', 'label' => 'Corp'],
                    ];
                    $currentRole = Auth::user()->role;
                    $badge = $roleConfig[$currentRole] ?? ['bg' => 'bg-gray-100 text-gray-700', 'label' => 'User'];
                @endphp
                <span
                    class="ml-auto inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset ring-black/10 {{ $badge['bg'] }}">
                    {{ $badge['label'] }}
                </span>
            </div>
            <nav class="flex flex-1 flex-col">
                <ul role="list" class="flex flex-1 flex-col gap-y-7">
                    <li>
                        <ul role="list" class="-mx-2 space-y-1">
                            @include('layouts.sidebar-links')
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Main content -->
    <div class="lg:pl-72">
        <!-- Top bar -->
        <div
            class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
            <button type="button" class="-m-2.5 p-2.5 text-gray-700 dark:text-gray-200 lg:hidden"
                @click="sidebarOpen = true">
                <span class="sr-only">Open sidebar</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>

            <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                <div class="flex flex-1"></div> <!-- Spacer -->
                <div class="flex items-center gap-x-4 lg:gap-x-6">
                    <!-- Profile dropdown trigger (static for now) -->
                    <!-- Profile dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button type="button" class="-m-1.5 flex items-center p-1.5" id="user-menu-button"
                            aria-expanded="false" aria-haspopup="true" @click="open = !open" @click.away="open = false">
                            <span class="sr-only">Open user menu</span>
                            <div
                                class="h-8 w-8 rounded-full bg-primary-500 flex items-center justify-center text-white text-xs">
                                {{ substr(Auth::user()->name, 0, 2) }}
                            </div>
                            <span class="hidden lg:flex lg:items-center">
                                <span class="ml-4 text-sm font-semibold leading-6 text-gray-900 dark:text-white"
                                    aria-hidden="true">{{ Auth::user()->name }}</span>
                                <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        </button>
                        <div class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white dark:bg-gray-800 py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none"
                            role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1"
                            x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95" x-cloak>

                            <!-- Settings Link -->
                            <a href="{{ route('settings.edit') }}"
                                class="block px-3 py-1 text-sm leading-6 text-gray-900 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-700"
                                role="menuitem" tabindex="-1">Settings</a>

                            <!-- Profile Link -->
                            <a href="{{ route('profile.edit') }}"
                                class="block px-3 py-1 text-sm leading-6 text-gray-900 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-700"
                                role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>

                            <!-- Logout Button -->
                            <button type="button" onclick="confirmLogout()"
                                class="block w-full text-left px-3 py-1 text-sm leading-6 text-gray-900 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-700"
                                role="menuitem" tabindex="-1" id="user-menu-item-1">Sign out</button>
                        </div>
                    </div>

                    <!-- Hidden Logout Form -->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>

                    <script>
                        function confirmLogout() {
                            Swal.fire({
                                title: 'Ready to Leave?',
                                text: "You will be logged out of your session.",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#4f46e5', // Indigo-600
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, log out',
                                cancelButtonText: 'Cancel',
                                background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#fff',
                                color: document.documentElement.classList.contains('dark') ? '#fff' : '#1f2937'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    document.getElementById('logout-form').submit();
                                }
                            })
                        }

                        // Flash Messages
                        @if (session('success'))
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'success',
                                title: "{{ session('success') }}",
                                background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#fff',
                                color: document.documentElement.classList.contains('dark') ? '#fff' : '#1f2937'
                            })
                        @endif

                        @if (session('error'))
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'error',
                                title: "{{ session('error') }}",
                                background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#fff',
                                color: document.documentElement.classList.contains('dark') ? '#fff' : '#1f2937'
                            })
                        @endif
                    </script>
                </div>
            </div>
        </div>

        <main class="py-10">
            <div class="px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>

</html>