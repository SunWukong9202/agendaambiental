@props(['column', 'sortCol', 'sortAsc'])

<button wire:click="sortBy('{{ $column }}')" {{ $attributes->merge(['class' => 'flex items-center gap-2 group']) }}>
    {{ $slot }}

    @if ($sortCol === $column)
        <div class="text-gray-400">
            @if ($sortAsc)
            <x-icon.arrow-up class="!w-4 !h-4"/>
            @else
                <x-icon.arrow-down class="!w-4 !h-4"/>
            @endif
        </div>
    @else
        <div class="text-gray-400 opacity-0 group-hover:opacity-100">
            <x-icon.arrow-up-down class="!w-4 !h-4"/>
        </div>
    @endif
</button>