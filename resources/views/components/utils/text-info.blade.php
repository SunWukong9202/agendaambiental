@props([
    'title',
    'content'
])

<dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">
    {{ $title }}
</dt>
<dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">
    @if ($slot->isEmpty())
        {{ $content }}
    @else
        {{ $slot }}
    @endif
</dd>