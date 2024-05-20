<button
    type="button"
    class="flex w-full justify-between rounded-lg bg-marine-100 px-4 py-3 text-left text-sm font-medium text-marine-900 hover:bg-marine-200 focus:outline-none focus-visible:ring focus-visible:ring-marine-500/75"
    >
        <span>{{ $slot }}</span>

        <x-icon.angle-down
        x-bind:class="expanded ? '-rotate-180': 'rotate-0'"   
        class="text-marine-500"
        />
</button>