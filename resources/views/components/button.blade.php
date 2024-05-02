@props([
    'text'
])

<button type="button" 
{{ $attributes->class([
    'focus:outline-none focus:ring-4 focus:ring-amber-300 dark:focus:ring-amber-900',
    'hover:bg-amber-500',
    'font-medium rounded-lg text-sm px-4 py-2 me-2 mb-2',
    'text-white bg-amber-400'
]) }}>
    @if ($slot->isEmpty())
        {{ $text }}
    @else
        {{ $slot }}
    @endif
</button>