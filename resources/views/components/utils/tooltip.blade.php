@props([
    'type' => 'dark',
    'content' => 'default'
])

<div
x-id="['tooltip']">
    <span 
    :data-tooltip-target="$id('tooltip')" 
    data-tooltip-style="{{ $type }}" 
    >
        {{ $trigger }}
    </span>

    <div 
    :id="$id('tooltip')" 
    role="tooltip" 
    {{ $attributes->class([
        'absolute z-10 invisible inline-block px-3 py-2 rounded-lg shadow-sm opacity-0 tooltip text-sm font-medium',
        'text-gray-900 bg-white border border-gray-200' => $type != 'dark',
        'text-white bg-gray-900 dark:bg-gray-700' => $type == 'dark'
    ]) }}
    >
        @if ($slot || $content)
        @if ($slot->isEmpty())
            {{ $content }}
        @else
            {{ $slot }}
        @endif
        @endif
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
</div>