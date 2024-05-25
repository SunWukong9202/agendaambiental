@props([
    'title',
    'content' => null
])

<div
{{ $attributes->class(['']) }}
>
    <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">
        {{ $title }}
    </dt>
    @if ($slot || $content)
    <dd 
    {{ $attributes->whereDoesntStartWith('class') }}
    class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">
        @if ($slot->isEmpty())
            {{ $content }}
        @else
            {{ $slot }}
        @endif
    </dd>
    @endif
</div>