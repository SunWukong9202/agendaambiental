@props([
    'text'
    'options'
])

<div class="w-full">
    <label :for="$id('select-input')" class="block mb-2 text-sm font-medium text-gray-500 dark:text-white">{{ $label }}</label>
    
    <div class="flex">
        <x-table.dropdown>
            <x-slot:trigger>
                <x-input.select-button>
                    {{ $text }}
                </x-input>
                <x-table.closable>
                    <x-table.button 
                    wire:click="show({{ $reactivo->id }})"
                    text=""/>
                </x-table>
            </x-slot>
        </x-table>
        {{ $selectable }}
        <select :id="$id('select-input')" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-e-lg border-s-gray-100 dark:border-s-gray-700 border-s-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            {{ $slot }}
        </select>
    </div>
</div>
