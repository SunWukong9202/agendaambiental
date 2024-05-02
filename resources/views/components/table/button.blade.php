@props([
    'text'
])

<button {{ $attributes->class([
    'w-full text-start flex px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white',
]) }}>
    @if ($slot->isEmpty())
        {{ $text }}
    @else
        {{ $slot }}
    @endif
</button>