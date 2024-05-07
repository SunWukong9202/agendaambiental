@props([
    'type' => 'button',
    'text'
])

<button type="{{ $type }}" 
{{ $attributes->class([
    //base styles
    'px-6 py-2 me-2 text-sm inline-block font-medium rounded-lg',
    //color styles
    'text-gray-700 bg-white',
    //hover styles
    'hover:text-marine-900 hover:bg-gray-100',
    //focus styles
    'focus:outline-none focus:z-10 focus:ring-4 focus:ring-gray-100',
    //dark styles
    'dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700'
]) }}
>
    @if ($slot->isEmpty())
        {{ $text }}
    @else
        {{ $slot }}
    @endif
</button>