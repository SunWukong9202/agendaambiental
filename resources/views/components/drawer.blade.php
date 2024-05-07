@props([
    'outsideTrigger' => false,
    'title' => 'Title'
])

<div x-data="{open: false}"
x-modelable="open"
{{ $attributes->whereDoesntStartWith('class') }}
x-cloak
@click.outside="open = false"
x-on:keydown.escape.prevent.stop="open = false"
>
    @if (!$outsideTrigger)
        <span x-on:click="open = true">
            {{ $button }}
        </span>
    @endif

     <!-- drawer component -->
    <div 
    {{ $attributes->class([
        'fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform bg-white w-80 dark:bg-gray-800'
    ]) }}
    x-bind:class="open || 'translate-x-full'"
    tabindex="-1">
        <div class="flex items-center py-4">
            <h5 id="drawer-right-label" class="inline-flex items-center text-base font-semibold text-gray-500 dark:text-gray-400">
                {{ $title }}
            </h5>
            <x-icon.button @click="open = false" class="ml-auto">
                <x-icon.close />
            </x-icon>
        </div>
        {{ $slot }}
    </div>
</div>
 

 