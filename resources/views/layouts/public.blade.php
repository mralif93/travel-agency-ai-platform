<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        // Check local storage or system preference
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .dark .glass-nav {
            background: rgba(17, 24, 39, 0.7);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .hero-glow {
            background: radial-gradient(circle at center, rgba(99, 102, 241, 0.15) 0%, rgba(17, 24, 39, 0) 70%);
        }

        /* Mobile menu transition */
        .mobile-menu {
            transition: max-height 0.3s ease-in-out, opacity 0.3s ease-in-out;
            max-height: 0;
            opacity: 0;
            overflow: hidden;
        }

        .mobile-menu.open {
            max-height: 400px;
            opacity: 1;
        }
    </style>
</head>

<body
    class="antialiased text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-900 selection:bg-indigo-500 selection:text-white overflow-x-hidden flex flex-col min-h-screen transition-colors duration-300">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 glass-nav transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <a href="{{ url('/') }}" class="flex-shrink-0 flex items-center gap-2 group">
                    <div
                        class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/20 group-hover:scale-105 transition-transform duration-200">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <span
                        class="font-bold text-xl tracking-tight text-gray-900 dark:text-white transition-colors">Travel<span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-500 dark:from-indigo-400 dark:to-purple-400">AI</span></span>
                </a>

                <div class="flex items-center gap-4">
                    <!-- Theme Toggle -->
                    <button id="theme-toggle"
                        class="p-2 rounded-xl text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <!-- Sun Icon -->
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        <!-- Moon Icon -->
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                            </path>
                        </svg>
                    </button>

                    @if (Route::has('login'))
                        <div class="hidden sm:block">
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="font-semibold text-gray-700 hover:text-indigo-600 dark:text-gray-300 dark:hover:text-white transition-colors">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-white/10 dark:hover:bg-white/20 dark:border-white/10 transition-all duration-200 backdrop-blur-sm shadow-md dark:shadow-none">
                                    Log in
                                </a>
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow pt-20">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer
        class="bg-gray-100 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 pt-6 pb-4 mt-auto transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center">
            <p class="text-gray-600 dark:text-gray-500 text-sm">
                &copy; {{ date('Y') }} TravelAI Platform. All rights reserved.
            </p>
        </div>
    </footer>

    <script>
        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        // Change the icons inside the button based on previous settings
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        var themeToggleBtn = document.getElementById('theme-toggle');

        themeToggleBtn.addEventListener('click', function () {

            // toggle icons inside button
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            // if set via local storage previously
            if (localStorage.theme) {
                if (localStorage.theme === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                }

                // if NOT set via local storage previously
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
            }

        });
    </script>
</body>

</html>