@props([
    'routes' => []
])

<ol 
{{ $attributes->class(['flex items-center whitespace-nowrap']) }}
>
    @if ($slot->isEmpty())
        @foreach ($routes as $text => $route)
            @if ($loop->last)
                <li class="inline-flex items-center text-lg font-semibold text-gray-800 truncate dark:text-neutral-200" aria-current="page">
                    {{ $route }}
                </li>
            @else
            <li class="inline-flex items-center">
                <a class="flex items-center text-lg text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500"
                wire:navigate 
                href="{{ route($route) }}">
                {{ $text }}
                </a>
                <svg class="flex-shrink-0 size-5 text-gray-400 dark:text-neutral-600 mx-2" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M6 13L10 3" stroke="currentColor" stroke-linecap="round"></path>
                  </svg>
            </li>
            @endif
        @endforeach
    @else
        {{ $slot }}
    @endif
</ol>