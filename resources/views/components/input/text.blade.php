@props([
    'label' => 'label',
    'type' => 'text',
    'icon' => false,
    'error',
])  


<div 
x-id="['text-input']"    
{{ $attributes->class(['w-full']) }}>
    @if ($label instanceof \Illuminate\View\ComponentSlot)
        {{ $label }}
    @else
        <label :for="$id('text-input')" class="block mb-2 text-sm font-medium text-gray-500 dark:text-white">{{ $label }}</label>
    @endif

    <div class="relative">
        @if ($icon)
        <div class="absolute inset-y-0 start-0 flex items-center ps-2.5 pointer-events-none">
            @if ($icon instanceof \Illuminate\View\ComponentSlot)
                {{ $icon }}
            @else
                <x-icon :$icon />
            @endif
        </div>
        @endif
    
        <input 
        {{ $attributes->whereDoesntStartWith('class') }}
        type="{{ $type }}" name="{{ $label }}" :id="$id('text-input')"
            class="bg-gray-100 text-sm rounded-lg block w-full p-2 dark:placeholder-gray-400 
            @if ($icon)
            ps-10
            @endif
            @error($error)
            text-red-900 border-2 dark:text-red-300 border-red-300 dark:bg-red-600 dark:border-red-500 focus:border-red-500 focus:ring-red-500
            @else
            text-gray-900 dark:text-white border-gray-300 dark:bg-gray-600 dark:border-gray-500 border focus:border-blue-500 focus:ring-blue-500
            @enderror"/>
    </div>
    
    <div>
        @error($error) <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>
</div>