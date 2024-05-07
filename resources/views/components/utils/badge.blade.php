@props([
    'type' => 'accepted', //accepted, in-progress, declined
    'text',
])

<span 
{{ $attributes->class([
    'text-sm font-medium me-2 px-2.5 py-0.5 rounded-full',
    'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
        => $type == 'accepted',
    'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300'
        => $type == 'in-progress',
    'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' 
        => $type == 'declined'
]) }}

class="  ">
    @if ($slot->isEmpty())
        {{ $text }}
    @else
        {{ $slot }}
    @endif
</span>
