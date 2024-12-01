<div>
    <div class="flex mb-2">
        <x-filament::breadcrumbs :breadcrumbs="[
            route('admin.suppliers') => __('ui.pages.Manage Suppliers'),
            '' => __('ui.deliveries'),
            ]"
        />
        <x-filament::loading-indicator wire:loading class="inset-y-1/2 text-primary-600 inline-block ml-2 h-5 w-5" />
    </div>
    <h1 class="font-bold mb-4 leading-snug tracking-tight bg-gradient-to-tr from-gray-800 to-gray-500 bg-clip-text text-transparent mx-auto w-full text-xl lg:max-w-2xl lg:text-3xl">
        {{ $supplier?->name }}
    </h1>

    <div class="mb-8 mx-auto max-w-4xl flex justify-center">
        <x-filament::tabs 
            custom-scrollbar="x-sm"
        >
            @php
                $move = \App\Enums\Movement::class;
            @endphp

            <x-filament::tabs.item
                class="shrink-0"
                icon="heroicon-o-truck"
                :active="$tab === 'deliveries'"
                wire:click="$set('tab', 'deliveries')"
            >
                {{ __('Deliveries') }}
            </x-filament::tabs.item>

            <x-filament::tabs.item
                class="shrink-0"
                icon="heroicon-o-document-chart-bar"
                :active="$tab === 'reports'"
                wire:click="$set('tab', 'reports')"
            >
                {{ __('Reports') }}
            </x-filament::tabs.item>                
        </x-filament::tabs>
    </div>        

    @if($tab == 'deliveries')
        {{ $this->table }}
    @else
        @livewire('panel.events.list-reports', ['supplier' => $supplier])
    @endif
</div>