<x-public-layout>
    <div class="py-24 bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 rounded-3xl p-8 sm:p-12 shadow-xl border border-gray-100 dark:border-gray-700 transition-colors duration-300">
                <div class="text-center mb-10">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Get in Touch</h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        Have questions or need support? We're here to help.
                    </p>
                </div>

                <form class="space-y-6">
                    <div>
                        <label for="name"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
                        <input type="text" id="name"
                            class="w-full px-4 py-3 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    </div>

                    <div>
                        <label for="email"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                        <input type="email" id="email"
                            class="w-full px-4 py-3 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    </div>

                    <div>
                        <label for="message"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Message</label>
                        <textarea id="message" rows="4"
                            class="w-full px-4 py-3 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 transition-colors"></textarea>
                    </div>

                    <button type="submit"
                        class="w-full py-4 px-6 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-lg transform transition hover:-translate-y-0.5">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-public-layout>