@props([
    'label'
])

<div 
x-id="['radio-input']"
{{ $attributes->class(['flex items-center me-4']) }}
{{-- class="" --}}
>
    <input :id="$id('radio-input')" type="radio" 
    {{ $attributes->whereDoesntStartWith('class') }}
    class="w-4 h-4 text-marine-600 bg-gray-100 border-gray-300 focus:ring-marine-500 dark:focus:ring-marine-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
    @if ($slot || $label)
        @if ($slot->isEmpty())
            <label :for="$id('radio-input')" 
                class="ms-2 block text-sm font-medium text-gray-500 dark:text-white">
                {{ $label }}
            </label>
        @else
            {{ $label }}       
        @endif
    @endif  
</div>