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
        @error($error) <span class="text-red-600">{{ $message }}</span> @enderror
    </div>

    {{-- <label for="input-group-1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your Email</label>
    <div class="relative mb-6 w-32">
      <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
            <path d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z"/>
            <path d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z"/>
        </svg>
      </div>
      <input type="text" id="input-group-1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@flowbite.com">
    </div> --}}
</div>