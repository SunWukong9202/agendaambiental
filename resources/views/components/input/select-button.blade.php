@props([
    'text'
])

<button id="states-button" data-dropdown-toggle="dropdown-states" class="flex-shrink-0 z-10 inline-flex items-center py-2 px-4 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600" type="button">
    @if ($slot->isEmpty())
        {{ $text }}
    @else
        {{ $slot }}
    @endif
    <x-icon.angle-down class="!w-2.5 !h-2.5 ms-2.5" />
</button>