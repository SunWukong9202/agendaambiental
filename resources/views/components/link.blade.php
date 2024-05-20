@props([
    'text' => false,
    'icon' => false,
    'iconRTL' => false,
    'page' => false,
    'routes' => []
])

<a 
    @if ($page)
    href="{{ route($page) }}"
    @endif
    {{ $attributes->class([
        'cursor-pointer flex items-center p-2 text-gray-900 rounded-lg dark:text-white group',
        'hover:bg-gray-100 dark:hover:bg-gray-700' => !request()->routeIs(...[$page, ...$routes]),
        'bg-marine text-white' => request()->routeIs(...[$page, ...$routes])
    ]) }}
>

    @if($icon) <x-icon :icon="$icon"/> @endif
    
    @if($text) <span class="ms-3 {{ $iconRTL ? 'flex-1': '' }}">{{ $text }}</span> @endif

       
    @if($iconRTL) <x-icon  :icon="$iconRTL"/> @endif
    
    {{ $slot }}
 </a>