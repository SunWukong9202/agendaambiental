@props([
    'useTALL' => false, 
    'text'
])

<a
{{ $attributes->class([
    'cursor-pointer text-gray-900 bg-white focus:outline-none hover:bg-gray-100 focus:ring-gray-100 rounded-2xl px-5 py-1 me-2  dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700' => $useTALL,
    'btn btn-sm rounded-pill me-2 px-4 py-0' => !$useTALL,
]) }}
>
    @if ($slot->isEmpty())
        {{ $text }}
    @else
        {{ $slot }}
    @endif
</a>