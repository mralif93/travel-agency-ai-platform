@use('Illuminate\Support\Facades\Auth')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50 dark:bg-gray-900">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Customer Portal</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body { font-family: 'Outfit', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
    
    @include('layouts.theme-styles')
    
    <!-- Theme Script -->
    <script>
        (function() {
            function getThemeMode() {
                @if(Auth::guard('customer')->check())
                    return '{{ Auth::guard('customer')->user()->theme_mode ?? "system" }}';
                @else
                    return localStorage.getItem('theme_mode') || 'system';
                @endif
            }

            function getSystemPreference() {
                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }

            function applyTheme(mode) {
                var effectiveTheme = mode === 'system' ? getSystemPreference() : mode;
                
                if (effectiveTheme === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
                
                var metaThemeColor = document.querySelector('meta[name="theme-color"]');
                if (metaThemeColor) {
                    metaThemeColor.setAttribute('content', effectiveTheme === 'dark' ? '#1f2937' : '#ffffff');
                }
            }

            applyTheme(getThemeMode());

            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
                var currentMode = getThemeMode();
                if (currentMode === 'system') {
                    applyTheme('system');
                }
            });

            window.toggleTheme = function() {
                var isDark = document.documentElement.classList.contains('dark');
                var newMode = isDark ? 'light' : 'dark';
                
                @if(Auth::guard('customer')->check())
                    var csrfToken = document.querySelector('meta[name="csrf-token"]');
                    if (csrfToken) {
                        fetch('{{ route("customer.profile.update") }}', {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                            },
                            body: JSON.stringify({ theme_mode: newMode })
                        });
                    }
                @else
                    localStorage.setItem('theme_mode', newMode);
                @endif
                
                applyTheme(newMode);
                updateToggleButton();
            };

            function updateToggleButton() {
                var isDark = document.documentElement.classList.contains('dark');
                var btn = document.getElementById('theme-toggle-btn');
                if (btn) {
                    var icon = btn.querySelector('i');
                    if (icon) {
                        if (isDark) {
                            icon.classList.remove('bx-moon');
                            icon.classList.add('bx-sun');
                        } else {
                            icon.classList.remove('bx-sun');
                            icon.classList.add('bx-moon');
                        }
                    }
                    btn.setAttribute('title', isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode');
                }
            }

            document.addEventListener('DOMContentLoaded', updateToggleButton);
        })();
    </script>
</head>

<body class="h-full font-sans antialiased text-gray-900 dark:text-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Top Navigation -->
        <nav class="sticky top-0 z-50 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm" x-data="{ mobileMenuOpen: false }">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex">
                        <div class="flex flex-shrink-0 items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center shadow-md">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-purple-600 to-indigo-600">TravelAI Portal</span>
                        </div>
                        <div class="hidden sm:ml-8 sm:flex sm:space-x-8">
                            <a href="{{ route('dashboard.customer') }}" class="{{ request()->routeIs('dashboard.customer') ? 'border-primary-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-400 hover:border-gray-300 hover:text-gray-700 dark:hover:text-gray-300' }} inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium transition-colors">
                                Dashboard
                            </a>
                            <a href="{{ route('customer.trips') }}" class="{{ request()->routeIs('customer.trips') ? 'border-primary-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-400 hover:border-gray-300 hover:text-gray-700 dark:hover:text-gray-300' }} inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium transition-colors">
                                My Trips
                            </a>
                            <a href="{{ route('transport-rates') }}" class="border-transparent text-gray-500 dark:text-gray-400 hover:border-gray-300 hover:text-gray-700 dark:hover:text-gray-300 inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium transition-colors">
                                Book New Trip
                            </a>
                        </div>
                    </div>
                    
                    <div class="hidden sm:ml-6 sm:flex sm:items-center gap-2">
                        <!-- Theme Toggle -->
                        <button type="button" id="theme-toggle-btn" onclick="toggleTheme()"
                            class="flex items-center justify-center w-9 h-9 rounded-lg text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                            title="Toggle theme">
                            <i class="bx bx-moon text-xl"></i>
                        </button>

                        <!-- Profile Dropdown -->
                        <div class="relative ml-3" x-data="{ open: false }">
                            <button type="button" @click="open = !open" @click.away="open = false"
                                class="relative flex rounded-full bg-white dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:ring-offset-2 transition-all duration-200 hover:ring-2 hover:ring-primary-500/20">
                                <span class="absolute -inset-1.5"></span>
                                <span class="sr-only">Open user menu</span>
                                <div class="h-9 w-9 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/50 dark:to-purple-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold border border-indigo-100 dark:border-indigo-800 shadow-sm">
                                    {{ substr(Auth::guard('customer')->user()->name, 0, 1) }}
                                </div>
                            </button>

                            <div x-show="open" x-transition x-cloak
                                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-xl bg-white dark:bg-gray-800 py-1 shadow-xl border border-gray-100 dark:border-gray-700 focus:outline-none">
                                <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-700">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ Auth::guard('customer')->user()->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate mt-0.5">{{ Auth::guard('customer')->user()->email }}</p>
                                </div>
                                <a href="{{ route('customer.profile.edit') }}" class="group flex items-center px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-primary-900/10 hover:text-primary-600 dark:hover:text-primary-400">
                                    <i class='bx bx-user mr-3 text-lg text-gray-400 group-hover:text-primary-500'></i>Profile
                                </a>
                                <div class="border-t border-gray-100 dark:border-gray-700 my-1"></div>
                                <button type="button" onclick="confirmLogout()" class="group flex w-full items-center px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/10">
                                    <i class='bx bx-log-out mr-3 text-lg text-red-400 group-hover:text-red-600'></i>Sign out
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button type="button" @click="mobileMenuOpen = !mobileMenuOpen"
                            class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
                            <span class="sr-only">Open main menu</span>
                            <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="sm:hidden overflow-hidden" x-show="mobileMenuOpen" 
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2 max-h-0"
                x-transition:enter-end="opacity-100 translate-y-0 max-h-96"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0 max-h-96"
                x-transition:leave-end="opacity-0 -translate-y-2 max-h-0"
                x-cloak>
                <div class="space-y-1 pb-3 pt-2 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('dashboard.customer') }}" class="{{ request()->routeIs('dashboard.customer') ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:border-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200' }} block border-l-4 py-2 pl-3 pr-4 text-base font-medium">Dashboard</a>
                    <a href="{{ route('customer.trips') }}" class="{{ request()->routeIs('customer.trips') ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:border-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200' }} block border-l-4 py-2 pl-3 pr-4 text-base font-medium">My Trips</a>
                    <a href="{{ route('transport-rates') }}" class="block border-l-4 border-transparent py-2 pl-3 pr-4 text-base font-medium text-gray-500 dark:text-gray-400 hover:border-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200">Book New Trip</a>
                </div>
                
                <!-- Mobile Theme Toggle -->
                <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-3">
                    <button type="button" onclick="toggleTheme()" class="flex items-center gap-3 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                        <i class="bx bx-moon text-xl"></i>
                        <span class="text-base font-medium">Toggle Dark Mode</span>
                    </button>
                </div>
                
                <!-- Mobile Profile -->
                <div class="border-t border-gray-200 dark:border-gray-700 pb-3 pt-4">
                    <div class="flex items-center px-4">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold border border-indigo-200 dark:border-indigo-800">
                                {{ substr(Auth::guard('customer')->user()->name, 0, 1) }}
                            </div>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-gray-800 dark:text-white">{{ Auth::guard('customer')->user()->name }}</div>
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ Auth::guard('customer')->user()->email }}</div>
                        </div>
                    </div>
                    <div class="mt-3 space-y-1">
                        <a href="{{ route('customer.profile.edit') }}" class="block px-4 py-2 text-base font-medium text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-800 dark:hover:text-gray-200">Your Profile</a>
                        <button onclick="confirmLogout()" class="block w-full text-left px-4 py-2 text-base font-medium text-red-500 hover:bg-red-50 dark:hover:bg-red-900/10">Sign out</button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1">
            <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 mt-auto">
            <div class="mx-auto max-w-7xl px-6 py-4 md:flex md:items-center md:justify-between lg:px-8">
                <div class="md:order-1">
                    <p class="text-center text-xs leading-5 text-gray-500 dark:text-gray-400">&copy; {{ date('Y') }} TravelAI. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Hidden Logout Form -->
    <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    @if(Auth::guard('customer')->user()->force_password_change)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var isDark = document.documentElement.classList.contains('dark');
            
            Swal.fire({
                title: 'Update Your Password',
                html: `
                    <div style="text-align: left;">
                        <p style="color: #6b7280; font-size: 14px; margin-bottom: 20px; text-align: center;">For security, please update your password to continue.</p>
                        
                        <div style="margin-bottom: 16px;">
                            <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 6px;">Current Password</label>
                            <input type="password" id="swal-current-password" placeholder="Enter current password"
                                style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; outline: none;"
                                onfocus="this.style.borderColor='#7c3aed'" onblur="this.style.borderColor='#d1d5db'">
                        </div>
                        
                        <div style="margin-bottom: 16px;">
                            <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 6px;">New Password</label>
                            <div style="position: relative;">
                                <input type="password" id="swal-new-password" placeholder="Enter new password"
                                    style="width: 100%; padding: 10px 40px 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; outline: none;"
                                    onfocus="this.style.borderColor='#7c3aed'" onblur="this.style.borderColor='#d1d5db'">
                                <button type="button" onclick="toggleSwalPassword('swal-new-password', this)"
                                    style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #9ca3af;">
                                    <i class='bx bx-hide'></i>
                                </button>
                            </div>
                        </div>
                        
                        <div style="margin-bottom: 8px;">
                            <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 6px;">Confirm Password</label>
                            <div style="position: relative;">
                                <input type="password" id="swal-confirm-password" placeholder="Confirm new password"
                                    style="width: 100%; padding: 10px 40px 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; outline: none;"
                                    onfocus="this.style.borderColor='#7c3aed'" onblur="this.style.borderColor='#d1d5db'">
                                <button type="button" onclick="toggleSwalPassword('swal-confirm-password', this)"
                                    style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #9ca3af;">
                                    <i class='bx bx-hide'></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#7c3aed',
                confirmButtonText: 'Update Password',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showCloseButton: false,
                background: isDark ? '#1f2937' : '#fff',
                color: isDark ? '#f3f4f6' : '#1f2937',
                width: '420px',
                padding: '24px',
                preConfirm: function() {
                    var currentPassword = document.getElementById('swal-current-password').value;
                    var newPassword = document.getElementById('swal-new-password').value;
                    var confirmPassword = document.getElementById('swal-confirm-password').value;
                    
                    if (!currentPassword) {
                        Swal.showValidationMessage('Please enter your current password');
                        return false;
                    }
                    if (newPassword.length < 8) {
                        Swal.showValidationMessage('New password must be at least 8 characters');
                        return false;
                    }
                    if (newPassword === currentPassword) {
                        Swal.showValidationMessage('New password must be different from current');
                        return false;
                    }
                    if (newPassword !== confirmPassword) {
                        Swal.showValidationMessage('Passwords do not match');
                        return false;
                    }
                    
                    return { currentPassword: currentPassword, newPassword: newPassword, confirmPassword: confirmPassword };
                }
            }).then(function(result) {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Updating...',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: function() {
                            Swal.showLoading();
                        }
                    });
                    
                    fetch('{{ route("customer.password.change.update") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            current_password: result.value.currentPassword,
                            password: result.value.newPassword,
                            password_confirmation: result.value.confirmPassword
                        })
                    })
                    .then(function(response) { return response.json(); })
                    .then(function(data) {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Your password has been updated.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'Failed to update password'
                            }).then(function() {
                                location.reload();
                            });
                        }
                    })
                    .catch(function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred. Please try again.'
                        }).then(function() {
                            location.reload();
                        });
                    });
                }
            });
        });
        
        window.toggleSwalPassword = function(inputId, button) {
            var input = document.getElementById(inputId);
            var icon = button.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bx-hide');
                icon.classList.add('bx-show');
            } else {
                input.type = 'password';
                icon.classList.remove('bx-show');
                icon.classList.add('bx-hide');
            }
        };
    </script>
    @endif

    <script>
        function confirmLogout() {
            var isDark = document.documentElement.classList.contains('dark');
            Swal.fire({
                title: 'Ready to Leave?',
                text: "You will be logged out of your session.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, log out',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                background: isDark ? '#1f2937' : '#fff',
                color: isDark ? '#f3f4f6' : '#1f2937',
                width: '380px',
                padding: '24px'
            }).then(function(result) {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }

        function togglePassword(inputId, button) {
            var input = document.getElementById(inputId);
            var icon = button.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bx-hide');
                icon.classList.add('bx-show');
            } else {
                input.type = 'password';
                icon.classList.remove('bx-show');
                icon.classList.add('bx-hide');
            }
        }
    </script>
    
    @include('components.sweetalert')
</body>
</html>
