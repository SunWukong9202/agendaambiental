@props([
    'type' => 'button',
    'text',
    'href' => false,
])

@if (!$href)
<button type="{{ $type }}" 
{{ $attributes->class([
    'focus:outline-none focus:ring-4 focus:ring-marine-800 dark:focus:ring-marine-900',
    'hover:bg-marine-800',
    'font-medium rounded-lg px-6 py-2',
    'text-white bg-marine-900'
]) }}>
    @if ($slot->isEmpty())
        {{ $text }}
    @else
        {{ $slot }}
    @endif
</button>

@else
<a href="{{ $href }}" 
{{ $attributes->class([
    'focus:outline-none',
    'hover:bg-marine-800',
    'font-medium rounded-lg text-sm px-6 py-2',
    'text-white bg-marine-900'
]) }}>
    @if ($slot->isEmpty())
        {{ $text }}
    @else
        {{ $slot }}
    @endif
</a>
@endif
