<x-public-layout>
    <!-- Hero Section -->
    <div class="relative pt-12 pb-20 sm:pt-20 sm:pb-24 overflow-hidden">
        <div class="absolute inset-0 hero-glow"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10">
            <div
                class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-200 dark:border-indigo-500/30 text-indigo-600 dark:text-indigo-300 text-sm font-medium mb-8 backdrop-blur-sm transition-colors duration-300">
                <span class="flex h-2 w-2 rounded-full bg-indigo-500 animate-pulse"></span>
                Next Gen Travel Platform
            </div>

            <h1
                class="text-5xl sm:text-7xl font-extrabold tracking-tight mb-8 text-gray-900 dark:text-white transition-colors duration-300">
                The Future of <br class="hidden sm:block" />
                <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 dark:from-indigo-400 dark:via-purple-400 dark:to-pink-400 animate-gradient">Travel
                    Management</span>
            </h1>

            <p
                class="mt-4 max-w-2xl mx-auto text-xl text-gray-600 dark:text-gray-400 mb-10 leading-relaxed transition-colors duration-300">
                Seamlessly connect drivers, partners, and travelers with an AI-driven ecosystem designed for the modern
                age.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('login') }}"
                    class="group relative inline-flex items-center justify-center px-8 py-4 text-base font-bold text-white transition-all duration-200 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl hover:from-indigo-700 hover:to-purple-700 shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:-translate-y-0.5">
                    Start Your Journey
                    <svg class="ml-2 -mr-1 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
                <a href="#features"
                    class="inline-flex items-center justify-center px-8 py-4 text-base font-bold text-gray-700 dark:text-gray-300 transition-all duration-200 bg-white/60 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-2xl hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white hover:border-gray-300 dark:hover:border-gray-600 backdrop-blur-sm shadow-sm dark:shadow-none">
                    Explore Features
                </a>
            </div>
        </div>

        <!-- Decorative background elements -->
        <div
            class="absolute top-1/2 left-0 -translate-y-1/2 w-96 h-96 bg-purple-200/40 dark:bg-purple-500/20 rounded-full blur-3xl -z-10 transition-colors duration-300">
        </div>
        <div
            class="absolute top-10 right-0 w-72 h-72 bg-blue-200/40 dark:bg-blue-500/10 rounded-full blur-3xl -z-10 transition-colors duration-300">
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="py-24 bg-white dark:bg-gray-900 relative transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white sm:text-4xl transition-colors duration-300">
                    Platform Capabilities</h2>
                <p class="mt-4 text-xl text-gray-600 dark:text-gray-400 transition-colors duration-300">Everything you
                    need to run a modern travel agency.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div
                    class="relative group p-8 bg-gray-50 dark:bg-gray-800/40 border border-gray-200 dark:border-gray-700/50 rounded-3xl hover:bg-white dark:hover:bg-gray-800/60 transition-all duration-300 hover:shadow-xl dark:hover:shadow-none hover:border-indigo-500/30 dark:hover:border-indigo-500/30">
                    <div
                        class="w-14 h-14 rounded-2xl bg-indigo-100 dark:bg-indigo-500/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 transition-colors duration-300">AI
                        Intelligence</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed transition-colors duration-300">
                        Smart itinerary generation and dynamic pricing engine powered by advanced LLMs to optimize every
                        trip.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="relative group p-8 bg-gray-50 dark:bg-gray-800/40 border border-gray-200 dark:border-gray-700/50 rounded-3xl hover:bg-white dark:hover:bg-gray-800/60 transition-all duration-300 hover:shadow-xl dark:hover:shadow-none hover:border-purple-500/30 dark:hover:border-purple-500/30">
                    <div
                        class="w-14 h-14 rounded-2xl bg-purple-100 dark:bg-purple-500/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 transition-colors duration-300">
                        Partner Ecosystem</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed transition-colors duration-300">
                        Seamlessly onboard and manage vehicle suppliers, verifying documents and tracking performance in
                        real-time.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="relative group p-8 bg-gray-50 dark:bg-gray-800/40 border border-gray-200 dark:border-gray-700/50 rounded-3xl hover:bg-white dark:hover:bg-gray-800/60 transition-all duration-300 hover:shadow-xl dark:hover:shadow-none hover:border-pink-500/30 dark:hover:border-pink-500/30">
                    <div
                        class="w-14 h-14 rounded-2xl bg-pink-100 dark:bg-pink-500/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 transition-colors duration-300">
                        Growth Analytics</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed transition-colors duration-300">
                        Comprehensive dashboards for admins, drivers, and partners to track revenue, trips, and ratings.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>