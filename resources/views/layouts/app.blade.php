@use('Illuminate\Support\Facades\Auth')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50 dark:bg-gray-900">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'TravelAI') }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body { font-family: 'Outfit', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
    
    @include('layouts.theme-styles')
    
    <script>
        (function() {
            function getThemeMode() {
                @if(Auth::check())
                    return '{{ Auth::user()->theme_mode ?? "system" }}';
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
            }
            applyTheme(getThemeMode());
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function() {
                if (getThemeMode() === 'system') applyTheme('system');
            });
            window.toggleTheme = function() {
                var isDark = document.documentElement.classList.contains('dark');
                var newMode = isDark ? 'light' : 'dark';
                @if(Auth::check())
                    var csrfToken = document.querySelector('meta[name="csrf-token"]');
                    if (csrfToken) {
                        fetch('{{ route("settings.update") }}', {
                            method: 'PATCH',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken.getAttribute('content') },
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
                        icon.classList.toggle('bx-moon', !isDark);
                        icon.classList.toggle('bx-sun', isDark);
                    }
                }
            }
            document.addEventListener('DOMContentLoaded', updateToggleButton);
        })();
    </script>
</head>

<body class="h-full bg-gray-50 dark:bg-gray-900" x-data="{ sidebarOpen: false }">
    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen" x-cloak class="fixed inset-0 z-40 lg:hidden" @click="sidebarOpen = false">
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"></div>
    </div>

    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transform transition-transform duration-200 ease-in-out -translate-x-full lg:translate-x-0"
        :class="{ 'translate-x-0': sidebarOpen }">
        
        <div class="flex flex-col h-full">
            <!-- Logo -->
            <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary-500 to-purple-600 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-lg font-bold text-gray-900 dark:text-white">TravelAI</span>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden p-1.5 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                @include('layouts.sidebar-links')
            </nav>

            <!-- User Section -->
            <div class="relative p-3 border-t border-gray-200 dark:border-gray-700" x-data="{ userMenuOpen: false }">
                <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-colors cursor-pointer"
                    @click="userMenuOpen = !userMenuOpen">
                    <div class="w-9 h-9 rounded-full bg-primary-500 flex items-center justify-center text-white text-sm font-semibold">
                        {{ substr(Auth::user()->name, 0, 2) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate capitalize">{{ Auth::user()->role }}</p>
                    </div>
                    <i class='bx bx-dots-vertical-rounded text-gray-400 text-lg'></i>
                </div>
                <!-- Popup Menu (opens upward) -->
                <div x-show="userMenuOpen" 
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                    @click.away="userMenuOpen = false"
                    x-cloak
                    class="absolute bottom-full left-3 right-3 mb-2 p-3 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-3 pb-3 mb-2 border-b border-gray-100 dark:border-gray-700">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-500 to-purple-600 flex items-center justify-center text-white text-sm font-semibold shadow-md">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                            <i class='bx bx-user text-lg text-gray-400'></i> 
                            <span>My Profile</span>
                        </a>
                        <a href="{{ route('settings.edit') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                            <i class='bx bx-cog text-lg text-gray-400'></i> 
                            <span>Settings</span>
                        </a>
                        <div class="border-t border-gray-100 dark:border-gray-700 my-2"></div>
                        <button onclick="userMenuOpen = false; confirmLogout()" class="flex items-center gap-3 w-full px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                            <i class='bx bx-log-out text-lg'></i> 
                            <span>Sign out</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="lg:pl-64">
        <!-- Top Bar -->
        <header class="sticky top-0 z-30 flex h-16 items-center gap-x-4 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 sm:px-6">
            <button type="button" class="-m-2.5 p-2.5 text-gray-700 dark:text-gray-200 lg:hidden" @click="sidebarOpen = true">
                <i class='bx bx-menu text-2xl'></i>
            </button>

            <div class="flex-1"></div>

            <div class="flex items-center gap-2">
                <!-- Theme Toggle -->
                <button id="theme-toggle-btn" onclick="toggleTheme()"
                    class="flex items-center justify-center w-9 h-9 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <i class="bx bx-moon text-xl"></i>
                </button>

                @if(Auth::user()->role === 'driver')
                    <div x-data="{ online: navigator.onLine }" @online.window="online = true" @offline.window="online = false">
                        <span x-show="online" class="flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium text-green-700 dark:text-green-400 bg-green-50 dark:bg-green-900/20 rounded-full">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                            Online
                        </span>
                        <span x-show="!online" class="flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium text-red-700 dark:text-red-400 bg-red-50 dark:bg-red-900/20 rounded-full">
                            <i class='bx bx-wifi-off'></i> Offline
                        </span>
                    </div>
                @endif
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-4 sm:p-6 lg:p-8">
            {{ $slot }}
        </main>
    </div>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    @if(Auth::user()->force_password_change)
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
                                onfocus="this.style.borderColor='#4f46e5'" onblur="this.style.borderColor='#d1d5db'">
                        </div>
                        
                        <div style="margin-bottom: 16px;">
                            <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 6px;">New Password</label>
                            <div style="position: relative;">
                                <input type="password" id="swal-new-password" placeholder="Enter new password"
                                    style="width: 100%; padding: 10px 40px 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; outline: none;"
                                    onfocus="this.style.borderColor='#4f46e5'" onblur="this.style.borderColor='#d1d5db'">
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
                                    onfocus="this.style.borderColor='#4f46e5'" onblur="this.style.borderColor='#d1d5db'">
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
                confirmButtonColor: '#4f46e5',
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
                    
                    fetch('{{ route("password.change.update") }}', {
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
                title: 'Sign out?',
                text: 'You will be logged out of your session.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, sign out',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                background: isDark ? '#1f2937' : '#fff',
                color: isDark ? '#f3f4f6' : '#1f2937',
                width: '340px'
            }).then(function(result) {
                if (result.isConfirmed) document.getElementById('logout-form').submit();
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
