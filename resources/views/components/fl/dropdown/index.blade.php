@props([
    'key' => 'default',
    'initiallyOpen' => false,
    'persisted' => false,
])

<div
    x-cloak
    x-modelable="expanded"
    class="fi-sidebar-group flex flex-col gap-y-1"
    {{ $attributes->whereDoesntStartWith('class') }}
    @if ($persisted)
        x-data="{ expanded: $persist(@js($initiallyOpen)).as('{{ $key }}').using(sessionStorage) }"
    @else
        x-data="{ expanded: @js(!isset($trigger)) }"
    @endif
> 
    @isset($trigger)
        <span
            class="cursor-pointer relative"
            @click="expanded = !expanded">
            {{ $trigger }}
        </span>
    @endisset
        
    <ul
        x-show="expanded"
        x-transition
        x-collapse.duration.350ms
        class="flex flex-col gap-y-1"
    >
        {{ $slot }}
    </ul>
</div>
