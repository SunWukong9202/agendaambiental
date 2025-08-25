<div>
    {{-- Do your work, then step back. --}}
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
                :icon="$move::Petition->getIcon()"
                :active="$tab === $move::Petition->value"
                wire:click="$set('tab', '{{ $move::Petition->value }}'); $set('forReagents', false)"
            >
                {{ Str::plural($move::Petition->getTranslatedLabel()) }}
            </x-filament::tabs.item>

            <x-filament::tabs.item
                class="shrink-0"
                :icon="$move::Petition->getIcon()"
                :active="$tab === $move::Petition->value"
                wire:click="$set('tab', '{{ $move::Petition->value }}'); $set('forReagents', true)"
            >
                {{ __('Reagents petititions') }}
            </x-filament::tabs.item>


            <x-filament::tabs.item
                class="shrink-0"
                :icon="$move::Donation->getIcon()"
                :active="$tab === $move::Capture->value"
                wire:click="$set('tab', '{{ $move::Donation->value }}'); $set('forReagents', true)"
            >
                {{ Str::plural($move::Donation->getTranslatedLabel()) }}
            </x-filament::tabs.item>

        </x-filament::tabs>
    </div>        

</div>
