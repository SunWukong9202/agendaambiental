<div x-data="{ open: false }">
    <span class="inline-block" x-ref="trigger" @click="open = ! open">{{ $trigger }}</span>
 
    <div 
    class="bg-white divide-y z-30 divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600""
    x-show="open" 
    x-anchor.bottom-end.offset.10="$refs.trigger"
    @click.outside="open = false">
        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"> 
            {{ $slot }}
        </ul>
    </div>
</div>