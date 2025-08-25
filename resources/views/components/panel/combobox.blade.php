@props([
    'label' => 'Label',
    'placeholder' => 'Please Select',
    'options' => [],
    'error',
])

<div 
x-data="combobox({
    options: {{ json_encode($options) }},
})" 
x-id="['combobox']"
{{ $attributes->class([
    'flex w-full max-w-xs flex-col gap-1'
]) }}
x-on:keydown="handleKeydownOnOptions($event)" x-on:keydown.esc.window="isOpen = false, openedWithKeyboard = false">
    @if ($label instanceof \Illuminate\View\ComponentSlot)
        {{ $label }}
    @else
        <label :for="$id('combobox')" class="w-fit pl-0.5 text-sm text-neutral-600 dark:text-neutral-300">{{ $label }}</label>
    @endif
    <div class="relative">
        <!-- trigger button  -->
        <button type="button" class="
        peer w-full px-3 py-2 transition duration-300 ease inline-flex items-center justify-between gap-2" role="combobox" x-on:click="isOpen = ! isOpen" 
        x-on:keydown.down.prevent="openedWithKeyboard = true" x-on:keydown.enter.prevent="openedWithKeyboard = true" x-on:keydown.space.prevent="openedWithKeyboard = true" x-bind:aria-expanded="isOpen || openedWithKeyboard" x-bind:aria-label="selectedOption ? selectedOption.filter : 'Please Select'" >
            <span x-text="selectedOption ? selectedOption.filter : '{{ $placeholder }}'"></span>
            <!-- Chevron  -->
            <x-heroicon-s-chevron-down class="size-5"/>
        </button>

        <!-- Hidden Input To Grab The Selected Value  -->
        <input 
        {{ $attributes->whereDoesntStartWith('class') }}
        :id="$id('combobox')" name="make" x-ref="hiddenTextField" hidden=""/>

        <div x-show="isOpen || openedWithKeyboard" id="makesList" class="absolute left-0 top-11 z-10 w-full overflow-hidden rounded-md border border-neutral-300 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900" role="listbox" aria-label="industries list" x-on:click.outside="isOpen = false, openedWithKeyboard = false" x-on:keydown.down.prevent="$focus.wrap().next()" x-on:keydown.up.prevent="$focus.wrap().previous()" x-transition x-trap="openedWithKeyboard">

            <!-- Search  -->
            <div class="relative">
                <x-heroicon-s-magnifying-glass class="absolute left-4 top-1/2 size-5 -translate-y-1/2 text-neutral-600/50 dark:text-neutral-300/50" />
                <input type="text" class="w-full border-b borderneutral-300 bg-neutral-50 py-2.5 pl-11 pr-4 text-sm text-neutral-600 focus:outline-none focus-visible:border-black disabled:cursor-not-allowed disabled:opacity-75 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300 dark:focus-visible:border-white" name="searchField" x-ref="searchField" aria-label="Search" x-on:input="getFilteredOptions($el.value)" placeholder="Search" />
            </div>

            <!-- Options  -->
            <ul class="flex max-h-44 flex-col overflow-y-auto" x-ref="options">
                <li class="hidden px-4 py-2 text-sm text-neutral-600 dark:text-neutral-300" x-ref="noResultsMessage">
                    <span>No matches found</span>
                </li>

                <template x-for="(item, index) in options" :key="index">
                    <li class="combobox-option inline-flex cursor-pointer justify-between gap-6 bg-neutral-50 px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-900/5 hover:text-neutral-900 focus-visible:bg-neutral-900/5 focus-visible:text-neutral-900 focus-visible:outline-none dark:bg-neutral-900 dark:text-neutral-300 dark:hover:bg-neutral-50/5 dark:hover:text-white dark:focus-visible:bg-neutral-50/10 dark:focus-visible:text-white" role="option" x-on:click="setSelectedOption(item)" x-on:keydown.enter="setSelectedOption(item)" x-bind:id="'option-' + index" tabindex="0">
                        <span x-bind:class="selectedOption == item ? 'font-bold' : null" x-text="item.filter"></span>
                        <span class="sr-only" x-text="selectedOption == item ? 'selected' : null"></span>
                        <x-heroicon-s-check x-cloak x-show="selectedOption == item" class="size-4"/>
                    </li>
                </template>
            </ul>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('combobox', (comboboxData = {
            options: [],
        },) => ({
            options: comboboxData.options,
            isOpen: false,
            openedWithKeyboard: false,
            selectedOption: null,

            init() {
                console.log('options')
                console.log(this.options);
                const initVal = this.$wire.get('{{ $attributes->whereStartsWith('wire:model')->first() }}')
                let option = this.options.find(option => option.value == initVal)
                if(option) {
                    this.setSelectedOption(option)
                }
            },

            
            setSelectedOption(option) {
                this.selectedOption = option
                this.isOpen = false
                this.openedWithKeyboard = false
                this.$refs.hiddenTextField.value = option.value
                this.$wire.set('{{ $attributes->whereStartsWith('wire:model')->first() }}', option.value);
            },

            getFilteredOptions(query) {
                this.options = comboboxData.options.filter((option) =>
                        option.filter.toLowerCase().includes(query.toLowerCase()),
                )
                
                if (this.options.length === 0) {
                    this.$refs.noResultsMessage.classList.remove('hidden')
                } else {
                    this.$refs.noResultsMessage.classList.add('hidden')
                }
            },

            // if the user presses backspace or the alpha-numeric keys, focus on the search field
            handleKeydownOnOptions(event) {
                if ((event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode >= 48 && event.keyCode <= 57) || event.keyCode === 8) {
                    this.$refs.searchField.focus()
                }
            },
        }))
    })
</script>
