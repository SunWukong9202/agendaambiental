@props([
    'breadcrumbs' => [],
])

@php
    $iconClasses = 'fi-breadcrumbs-item-separator flex h-5 w-5 text-gray-400 dark:text-gray-500';
    $itemLabelClasses = 'fi-breadcrumbs-item-label text-sm font-medium text-gray-500 dark:text-gray-400';
@endphp

<nav {{ $attributes->class(['fi-breadcrumbs']) }}>
    <ol class="fi-breadcrumbs-list flex flex-wrap items-center gap-x-2">
        @foreach ($breadcrumbs as $url => $label)
            <li class="fi-breadcrumbs-item flex items-center gap-x-2">
                @if (! $loop->first)
                    @if(app()->getLocale() === 'ar' || app()->isLocale('rtl')) {{-- assuming Arabic or RTL setting --}}
                        <x-filament::icon
                            :alias="['breadcrumbs.separator.rtl', 'breadcrumbs.separator']"
                            icon="heroicon-m-chevron-left"
                            class="{{ $iconClasses }}"
                        />
                    @else
                        <x-filament::icon
                            alias="breadcrumbs.separator"
                            icon="heroicon-m-chevron-right"
                            class="{{ $iconClasses }}"
                        />
                    @endif
                @endif

                @if (is_int($url))
                    <span class="{{ $itemLabelClasses }}">
                        {{ $label }}
                    </span>
                @else
                    <a
                        {{ $attributes->whereDoesntStartWith('class')  }}
                        {{ \Filament\Support\generate_href_html($url) }}
                        class="{{ $itemLabelClasses }} transition duration-75 hover:text-gray-700 dark:hover:text-gray-200"
                    >
                        {{ $label }}
                    </a>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
