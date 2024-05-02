@props([
    'pages' => []
])

<div {{ $attributes->class([
    'w-full max-w-md px-2 sm:px-0 mx-auto',
]) }}>
    <div class="flex space-x-1 rounded-xl bg-white/20 p-1">
        @foreach ($pages as $text => $page)
            <a
            :key="$page .'-'.$text"
            wire:navigate
            href="{{ route($page) }}"
            @class([
                'w-full rounded-lg py-1 text-sm font-medium leading-5 text-center',
                'ring-white/60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2', 
                'bg-white text-blue-700 shadow' => request()->routeIs($page),
                'text-blue-100 hover:bg-white/[0.12] hover:text-white' => !request()->routeIs($page)
            ])
            >
                {{ $text }}
            </a>
        @endforeach
    </div>
</div>
  