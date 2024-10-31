@props([
    'active' => false
])
<li 
@class([
    'flex flex-col gap-y-1 fi-sidebar-item',
    // 'fi-active fi-sidebar-item-active' => $active
])
>
    <a  
        {{ $attributes->class([
            'fi-sidebar-item-button cursor-pointer relative flex items-center justify-center gap-x-3 rounded-lg px-2 py-2 outline-none transition duration-75 group
            hover:bg-gray-100 focus-visible:bg-gray-100 dark:hover:bg-white/5 dark:focus-visible:bg-white/5 bg-gray-100 dark:bg-white/5',
            'bg-transparent' => !$active,
            'bg-gray-100 dark:bg-white lg:bg-white lg:dark:bg-gray-950 lg:shadow-md' => $active
        ]) }}
        {{-- class="bg-transparent" --}}
        x-on:click="window.matchMedia(`(max-width: 1024px)`).matches &amp;&amp; $store.sidebar.close()" 
    >
        <span
            {{ $icon->attributes->class([
                'fi-sidebar-item-icon h-6 w-6 group-hover:text-primary-600',
                'text-primary-600 dark:text-primary-400' => $active,
                'text-gray-400 dark:text-gray-500' => !$active
            ]) }}
        > 
            {{ $icon }}
        </span>

        <span 
            {{ $attributes->class([
                'fi-sidebar-item-label flex-1 truncate text-sm font-medium',
                'text-primary-600 dark:text-primary-400' => $active,
                'text-gray-700 dark:text-gray-200' => ! $active,
            ]) }}
        >
            {{ $slot }}
        </span>
    </a>

</li>