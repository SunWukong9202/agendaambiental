@props([
    'title',
    'subtitle',
    'footerClasses' => '',
])

<div 
{{ $attributes->class([
    'border border-t-4 border-t-blue-600',
    'bg-white shadow-md',
    'max-w-md flex flex-col rounded-xl'
    // 'dark:bg-neutral-900 dark:border-neutral-700 dark:border-t-blue-500 dark:shadow-neutral-700/70'
]) }}

{{-- class="max-w-md" --}}
>
    <div class="p-4 md:p-5">
        @if (isset($title))
            @if ($title instanceof \Illuminate\View\ComponentSlot)
            {{ $title }}
            @else
                <h6
                class="block mb-4 font-sans text-base antialiased font-semibold leading-relaxed tracking-normal text-gray-700 uppercase">
                    {{ $title }}
                </h6>
            @endif
        @endif

        @if (isset($subtitle))
            @if ($subtitle instanceof \Illuminate\View\ComponentSlot)
            {{ $subtitle }}
            @else
                <h4 class="block mb-2 font-sans text-2xl antialiased font-semibold leading-snug tracking-normal text-blue-gray-900">
                    {{ $subtitle }}
                </h4>
            @endif
        @endif

      <p class="mt-2 text-gray-500 dark:text-neutral-400">
        With supporting text below as a natural lead-in to additional content.
        {{ $slot }}
      </p>
    </div>
    @if (isset($footer))
        <div class="bg-neutral-100 border-t rounded-b-xl py-3 px-4 md:py-4 md:px-5 dark:bg-neutral-900 dark:border-neutral-700 {{ $footerClasses }}"
        >
            {{ $footer }}
        </div>
    @endif
</div>
