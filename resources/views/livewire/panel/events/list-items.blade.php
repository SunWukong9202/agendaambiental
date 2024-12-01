<div>
    <div class="flex mb-4">
        <x-filament::breadcrumbs :breadcrumbs="[
            route('admin.events.inventory') => __('ui.pages.Event Inventory'),
            '' => __('ui.list'),
            ]"
        />
        <x-filament::loading-indicator wire:loading class="inset-y-1/2 text-primary-600 inline-block ml-2 h-5 w-5" />
    </div>

    <div class="mb-8">
        <div class="flex justify-end " x-bind:class="{{ json_encode(isset($item)) }} ? '' : 'hidden'">
            <x-filament::link
                wire:click="deleteItem"
                color="danger" 
                icon="heroicon-m-trash" 
                tag="button"
            >
                {{ __('delete') }}
            </x-filament::link>
        </div>

        {{ $this->itemForm }}
    </div>

    <div class="mb-8 mx-auto max-w-4xl flex justify-center">
        <x-filament::tabs 
            custom-scrollbar="x-sm"
            {{-- class="" --}}
        >
            @php
                $move = \App\Enums\Movement::class;
            @endphp

            <x-filament::tabs.item
                class="shrink-0"
                icon="heroicon-m-rectangle-stack"
                :active="$tab === null"
                wire:click="$set('tab', null)"
            >
                {{ __('All') }}
            </x-filament::tabs.item>

            <x-filament::tabs.item
                class="shrink-0"
                :icon="$move::Petition->getIcon()"
                :active="$tab === $move::Petition->value"
                wire:click="$set('tab', '{{ $move::Petition->value }}')"
            >
                {{ Str::plural($move::Petition->getTranslatedLabel()) }}
            </x-filament::tabs.item>
{{-- 
            <x-filament::tabs.item
                class="shrink-0"
                :icon="$move::Petition_By_Name->getIcon()"
                :active="$tab === $move::Petition_By_Name->value"
                wire:click="$set('tab', '{{ $move::Petition_By_Name->value }}')"
            >
                {{ Str::plural($move::Petition_By_Name->getTranslatedLabel()) }}
            </x-filament::tabs.item> --}}

            <x-filament::tabs.item
                class="shrink-0"
                :icon="$move::Capture->getIcon()"
                :active="$tab === $move::Capture->value"
                wire:click="$set('tab', '{{ $move::Capture->value }}')"
            >
                {{ Str::plural($move::Capture->getTranslatedLabel()) }}
            </x-filament::tabs.item>


            <x-filament::tabs.item
                class="shrink-0"
                :icon="$move::Reparation->getIcon()"
                :active="$tab === $move::Reparation->value"
                wire:click="$set('tab', '{{ $move::Reparation->value }}')"
            >
                {{ Str::plural($move::Reparation->getTranslatedLabel()) }}
            </x-filament::tabs.item>

        
        </x-filament::tabs>
    </div>        

    {{ $this->table }}

</div>
