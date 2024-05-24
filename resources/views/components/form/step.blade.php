@props([
    'option',
    'isLastOne' => false,
    'isActive' => false,
])

<li {{ $attributes->class([
    'flex items-center',
    'w-full after:content-[\'\'] after:w-full after:h-0 after:border-b after:border-2 after:inline-block after:mx-3 xl:after:mx-10 dark:after:border-gray-700 after:border-gray-300' => !$isLastOne,

]) }}>

    {{-- <span class="me-2">{{ $step }}</span> --}}
    <span 
    
    @class([
        'flex items-center me-2 justify-center px-4 py-2 rounded-full shrink-0',
        'text-marine-800 bg-gray-100' => !$isActive,
        'bg-marine-200 text-marine-800' => $isActive
    ])
    {{-- class=" dark:bg-gray-700 " --}}
    >
        @if ($slot->isNotEmpty())
            {{ $slot }}
        @else
            {{ $option }}
        @endif
    </span> 
</li>
