<x-app-layout>
    <div class="sm:flex sm:items-center mb-8">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">Settings</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-400">Manage your workspace preferences and appearance.
            </p>
        </div>
    </div>

    @if (session('status') === 'settings-updated')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                Swal.fire({
                    icon: 'success',
                    title: 'Saved!',
                    text: 'Your settings have been updated.',
                    timer: 2000,
                    showConfirmButton: false,
                    background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#fff',
                    color: document.documentElement.classList.contains('dark') ? '#fff' : '#1f2937'
                });
            });
        </script>
    @endif

    <form method="post" action="{{ route('settings.update') }}">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 gap-x-8 gap-y-8 lg:grid-cols-2">

            <!-- Appearance Settings -->
            <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                <div class="px-4 py-6 sm:p-8">
                    <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Appearance</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-gray-400">Customize how the dashboard looks
                        on your device.</p>

                    <div class="mt-8 space-y-10">

                        <!-- Theme Mode -->
                        <div>
                            <label
                                class="text-sm font-medium leading-6 text-gray-900 dark:text-white mb-4 block">Interface
                                Theme</label>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                <!-- Light -->
                                <label class="cursor-pointer group relative">
                                    <input type="radio" name="theme_mode" value="light" class="peer sr-only" {{ $user->theme_mode === 'light' ? 'checked' : '' }}>
                                    <div
                                        class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white p-6 shadow-sm transition-all duration-200 hover:border-primary-500/50 peer-checked:border-primary-600 peer-checked:ring-2 peer-checked:ring-primary-600 peer-checked:bg-primary-50/10">
                                        <div class="flex items-center justify-between">
                                            <div class="flex flex-col">
                                                <span class="block text-sm font-semibold text-gray-900">Light</span>
                                                <span class="mt-1 text-xs text-gray-500">Clean and bright</span>
                                            </div>
                                            <svg class="h-5 w-5 text-primary-600 opacity-0 transition-opacity duration-200 peer-checked:opacity-100"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div
                                        class="absolute inset-0 border-2 border-primary-600 rounded-xl opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity duration-200">
                                    </div>
                                </label>

                                <!-- Dark -->
                                <label class="cursor-pointer group relative">
                                    <input type="radio" name="theme_mode" value="dark" class="peer sr-only" {{ $user->theme_mode === 'dark' ? 'checked' : '' }}>
                                    <div
                                        class="rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-900 p-6 shadow-sm transition-all duration-200 hover:border-primary-500/50 peer-checked:border-primary-600 peer-checked:ring-2 peer-checked:ring-primary-600">
                                        <div class="flex items-center justify-between">
                                            <div class="flex flex-col">
                                                <span class="block text-sm font-semibold text-white">Dark</span>
                                                <span class="mt-1 text-xs text-gray-400">Easy on the eyes</span>
                                            </div>
                                            <svg class="h-5 w-5 text-primary-600 opacity-0 transition-opacity duration-200 peer-checked:opacity-100"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div
                                        class="absolute inset-0 border-2 border-primary-600 rounded-xl opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity duration-200">
                                    </div>
                                </label>

                                <!-- System -->
                                <label class="cursor-pointer group relative">
                                    <input type="radio" name="theme_mode" value="system" class="peer sr-only" {{ $user->theme_mode === 'system' ? 'checked' : '' }}>
                                    <div
                                        class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 shadow-sm transition-all duration-200 hover:border-primary-500/50 peer-checked:border-primary-600 peer-checked:ring-2 peer-checked:ring-primary-600 peer-checked:bg-primary-50/10 dark:peer-checked:bg-primary-900/10">
                                        <div class="flex items-center justify-between">
                                            <div class="flex flex-col">
                                                <span
                                                    class="block text-sm font-semibold text-gray-900 dark:text-white">System</span>
                                                <span class="mt-1 text-xs text-gray-500 dark:text-gray-400">Sync with
                                                    OS</span>
                                            </div>
                                            <svg class="h-5 w-5 text-primary-600 opacity-0 transition-opacity duration-200 peer-checked:opacity-100"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div
                                        class="absolute inset-0 border-2 border-primary-600 rounded-xl opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity duration-200">
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Accent Color -->
                        <div>
                            <label class="text-sm font-medium leading-6 text-gray-900 dark:text-white block mb-4">Accent
                                Color</label>
                            <div class="flex flex-wrap items-center gap-6">
                                @php
                                    $colors = [
                                        ['id' => 'primary', 'label' => 'Indigo', 'bg' => 'bg-indigo-500', 'border' => 'border-indigo-500', 'ring' => 'ring-indigo-500', 'focus' => 'peer-focus:ring-indigo-500'],
                                        ['id' => 'rose', 'label' => 'Rose', 'bg' => 'bg-rose-500', 'border' => 'border-rose-500', 'ring' => 'ring-rose-500', 'focus' => 'peer-focus:ring-rose-500'],
                                        ['id' => 'blue', 'label' => 'Blue', 'bg' => 'bg-blue-500', 'border' => 'border-blue-500', 'ring' => 'ring-blue-500', 'focus' => 'peer-focus:ring-blue-500'],
                                        ['id' => 'green', 'label' => 'Green', 'bg' => 'bg-green-500', 'border' => 'border-green-500', 'ring' => 'ring-green-500', 'focus' => 'peer-focus:ring-green-500'],
                                        ['id' => 'orange', 'label' => 'Orange', 'bg' => 'bg-orange-500', 'border' => 'border-orange-500', 'ring' => 'ring-orange-500', 'focus' => 'peer-focus:ring-orange-500'],
                                        ['id' => 'violet', 'label' => 'Violet', 'bg' => 'bg-violet-500', 'border' => 'border-violet-500', 'ring' => 'ring-violet-500', 'focus' => 'peer-focus:ring-violet-500'],
                                    ];
                                @endphp

                                @foreach($colors as $color)
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="theme_color" value="{{ $color['id'] }}"
                                            class="peer sr-only" {{ $user->theme_color === $color['id'] ? 'checked' : '' }}>
                                        <div
                                            class="h-12 w-12 rounded-full {{ $color['bg'] }} shadow-sm ring-1 ring-gray-200 dark:ring-gray-700 group-hover:scale-110 transition-all duration-200 peer-focus:ring-2 peer-focus:ring-offset-2 {{ $color['focus'] }}">
                                        </div>
                                        <div
                                            class="absolute -inset-1 rounded-full border-2 {{ $color['border'] }} opacity-0 peer-checked:opacity-100 transition-all duration-200 scale-105">
                                        </div>
                                        <div
                                            class="absolute -bottom-8 left-1/2 -translate-x-1/2 opacity-0 peer-checked:opacity-100 transition-opacity duration-200">
                                            <span
                                                class="text-xs font-medium text-gray-600 dark:text-gray-300">{{ $color['label'] }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            <p class="mt-12 text-sm text-gray-500 dark:text-gray-400">This will update the primary brand
                                color across your dashboard.</p>
                        </div>

                    </div>
                </div>
                <div
                    class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 dark:border-gray-700 px-4 py-4 sm:px-8 bg-gray-50/50 dark:bg-gray-800/50 rounded-b-xl">
                    <button type="button" onclick="window.location.reload()"
                        class="text-sm font-semibold leading-6 text-gray-900 dark:text-white hover:text-gray-700 dark:hover:text-gray-300 transition-colors">Cancel</button>
                    <button type="submit"
                        class="rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 transition-all active:scale-95">Save
                        Preferences</button>
                </div>
            </div>

        </div>
    </form>

</x-app-layout>