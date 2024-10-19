@props([
    'label',
    'error'
])

<div class="w-full">
    <label :for="$id('select-input')" class="block mb-2 text-sm font-medium text-gray-500 dark:text-white">{{ $label }}</label>
    <select 
    {{ $attributes->whereDoesntStartWith('class') }}
    :id="$id('select-input')" class="bg-gray-50 text-gray-900 text-sm rounded-lg  block w-full p-2 dark:bg-gray-700  dark:placeholder-gray-400 dark:text-white 
    @error ($error)
    text-red-900 border-2 dark:text-red-300 border-red-300 dark:bg-red-600 dark:border-red-500 focus:border-red-500 focus:ring-red-500
    @else
    border-gray-300 border focus:ring-blue-500 focus:border-blue-500 dark:border-gray-600 dark:focus:ring-blue-500 dark:focus:border-blue-500
    @enderror
    ">
        {{ $slot }}
    </select>

    <div>
        @error($error) <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>
</div>
