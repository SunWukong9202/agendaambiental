@props([
    'active' => false,
    'text'
])

<button
{{ $attributes->class([
    'w-full rounded-lg py-1 text-sm font-medium leading-5 text-center',
    'ring-white/60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2', 
    'bg-white text-blue-700 shadow' => $active,
    'text-blue-100 hover:bg-white/[0.12] hover:text-white' => !$active
]) }}
>
    {{ $text }}
</button> 