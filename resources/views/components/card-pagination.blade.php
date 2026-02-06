@props(['items'])

<div class="bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700 px-4 py-3 sm:px-6">
    {{ $items->links() }}
</div>