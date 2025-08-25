<x-slot:title>
    {{ __('pages.list users') }}
</x-slot>

<div x-data>
    <div class="flex mb-4">
        <x-filament::breadcrumbs :breadcrumbs="[
            route('admin.users') => __('ui.pages.Users Managment'),
            '' => __('ui.list'),
            ]"
        />
        <x-filament::loading-indicator wire:loading class="inset-y-1/2 text-primary-600 inline-block ml-2 h-5 w-5" />
    </div>

    <x-filament::tabs class="flex mb-4 items-center">
        <x-filament::tabs.item
            class="flex-1 text-center flex"
            :active="!$tab"
            wire:click="$set('tab', false)"
        >
            {{ __('form.Internal Users') }}
        </x-filament::tabs.item>

        <x-filament::tabs.item
            class="flex-1"
            :active="$tab"
            wire:click="$set('tab', true)"
        >
            {{ __('form.External Users') }}
        </x-filament::tabs.item>    
    </x-filament::tabs>

    {{ $this->table }}
</div>
