@props([
    'label'
])

<div class="w-full">
    <label :for="$id('select-input')" class="block mb-2 text-sm font-medium text-gray-500 dark:text-white">{{ $label }}</label>
    <select 
    {{ $attributes->whereDoesntStartWith('class') }}
    :id="$id('select-input')" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        {{ $slot }}
      </select>
</div>
