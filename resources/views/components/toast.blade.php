@props([
    'type' => 'success',
    'message' => 'Custom message notification'
])

<div 
x-data="{show: false}"
x-show="show"
x-modelable="show"

{{ $attributes->class([
    'flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800',
]) }}

{{-- class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" --}}
>
    <div 
    @class([
        //base
        'inline-flex items-center justify-center flex-shrink-0 w-8 h-8',

        'text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200' => $type == 'success',

        'text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200' => $type == 'danger',
    
        'text-orange-500 bg-orange-100 rounded-lg dark:bg-orange-700 dark:text-orange-200' => $type == 'warning',
    ])>
        <x-icon.check />
        <span class="sr-only">Check icon</span>
    </div>
    <div class="ms-3 text-base font-normal">
    @if ($slot->isEmpty())
        {{ $message }}
    @else
        {{ $slot }}
    @endif
    </div>
    <x-icon.button x-on:click="show = false">
        <x-icon.close />
        <span class="sr-only">Close</span>
    </x-icon>
</div>
