<div custom-scrollbar>
    <div class="flex mb-4 justify-between">
        <div class="flex">
            <x-filament::breadcrumbs :breadcrumbs="[
                route('admin.events.actived') => __('ui.pages.Active Events'),
                '' => __('ui.'.$action),
                ]"
            />
            {{-- <x-filament::loading-indicator wire:loading  class="inset-y-1/2 text-primary-600 inline-block ml-2 h-5 w-5" />     --}}
        </div>

        <x-filament::link 
            :href="route('admin.events.inventory', [
                'status' => \App\Enums\Status::Repairable->value,
                'tab' => \App\Enums\Movement::Capture->value
            ])" 
            wire:navigate
        >
            {{ __('Unassigned items') }}
        </x-filament::link>
    </div>

    <div class="flex flex-col gap-4 mb-4">
        {{ $this->eventInfolist }}

        {{ $this->selectActive }}
    </div>

    
    <x-filament::tabs class="flex mb-4 items-center">
        {{-- <x-filament::loading-indicator wire:loading wire:target="tab" class="inset-y-1/2 text-primary-600 inline-block h-5 w-5" /> --}}
        <x-filament::tabs.item
            class="flex-1 text-center flex"
            :active="!$tab"
            wire:click="$set('tab', false)"
        >
            {{ __('Book donations') }}
        </x-filament::tabs.item>

        <x-filament::tabs.item
            class="flex-1"
            :active="$tab"
            wire:click="$set('tab', true)"
        >
            {{ __('Waste donations') }}
        </x-filament::tabs.item>    
    </x-filament::tabs>

    {{ $this->table }}
</div>


{{-- 

@if (str_starts_with('selected', $action))
{{ $event->name }}
{{ $donator->name ?? 'Intern' }}
{{ $this->table }}
<div class="mt-4 flex flex-col gap-4">
    <div class="ml-auto">
        <x-filament::modal width="lg" id="create-user"
        >
            <x-slot name="trigger">
                <x-filament::button>
                    {{ __('ui.buttons.user', ['action' => __('ui.create')]) }}
                </x-filament::button>
            </x-slot>

            <x-slot name="heading">
                {{ __('ui.buttons.user', ['action' => __('ui.create')]) }}
            </x-slot>

            <form wire:submit="createUser" class="flex flex-col gap-6">
                {{ $this->userForm }}

                <x-filament::button type="submit" outlined size="sm">
                    <div class="flex items-center">
                        <x-filament::loading-indicator wire:loading wire:target="createUser" class="inline-block mr-2 h-5 w-5" />
                        {{ __('ui.create') }}
                    </div>
                </x-filament::button>
            </form>

        </x-filament::modal>

    </div>
    <form wire:submit="saveDonations" class="flex flex-col gap-4">
        {{ $this->donationsForm }}

        <x-filament::button type="submit" outlined size="sm">
            <div class="flex items-center">
                <x-filament::loading-indicator wire:loading wire:target="saveDonations" class="inline-block mr-2 h-5 w-5" />
                {{ __('ui.create') }}
            </div>
        </x-filament::button>
    </form>
</div>
@endif --}}