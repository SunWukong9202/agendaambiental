@props([
    'title' => 'Title',
    'subtitle' => 'Subtitle',
])

<div
x-id="['radio-input']"
{{ $attributes->class(['']) }}
>    
    <input {{ $attributes->whereDoesntStartWith('class') }}
    :id="$id('radio-input')"  
    type="radio" class="hidden peer" />
    <label :for="$id('radio-input')" class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-emerald-500 peer-checked:border-emerald-600 peer-checked:text-emerald-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">                           
        <div class="block">
            <div class="w-full text-lg font-semibold">{{ $title }}</div>
            @if ($slot->isEmpty())
                <div class="w-full">{{ $subtitle }}</div>
            @else
                {{ $slot }}
            @endif
        </div>
    </label>
</div>
 