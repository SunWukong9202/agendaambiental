<?php

namespace App\Livewire\Panel;

use App\Enums\Movement;
use App\Models\CMUser;
use App\Models\Pivots\ReagentMovement;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class ListReagents extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public $tab = false;

    public function updatedTab(): void
    {
        $this->resetTable();
    }

    public function getQuery()
    {
        $query = ReagentMovement::whereIn('type', Movement::ofReagents());
            
        if($this->tab != null) {
            $query->where('type', Movement::tryFrom($this->tab));
        }

        return $query;
    }

    public function table(Table $table): Table
    {
        return $table
            // ->poll('5s')
            ->query($this->getQuery())
            ->columns([
                ImageColumn::make('photo_url')
                    ->label(__('Image')),

                TextColumn::make('reagent.name')
                    ->label(__('Reagent'))
                    ->searchable()
                    ->default(__('Not assigned to a reagent'))
                    ->visible(!isset($this->item) && 
                        $this->tab != Movement::Petition_By_Name->value
                    ),
    
                TextColumn::make('reagent_name')
                    ->translateLabel()
                    ->searchable()
                    ->visible($this->tab == Movement::Petition_By_Name->value),

                TextColumn::make('type')
                    ->badge()
                    ->visible(Movement::tryFrom($this->tab) == null)
                    ->formatStateUsing(fn($state) => $state->value)
                    ->color(fn ($state) => $state->getBagdeColor()),

                SelectColumn::make('status')
                    ->beforeStateUpdated(function (ReagentMovement $record, $state) {
                        dd($record, $state);
                    }),
                
                TextColumn::make('user.user.name')
                    ->label(__('Issued by'))
                    ->searchable(),

                TextColumn::make('created_at')
                ->label(__('Issued'))
                ->sortable()
                ->formatStateUsing(fn(ReagentMovement $record) => $record->dateTime('created_at'))

            ]);
    }

    public function render()
    {
        return <<<'HTML'
        <x-slot:title>
            {{ __('ui.pages.Manage Reagents') }}
        </x-slot>

        <div> 
            <div class="flex mb-4">
                <x-filament::breadcrumbs :breadcrumbs="[
                    route('admin.reagents') => __('ui.pages.Reagent Inventory'),
                    '' => __('ui.list'),
                    ]"
                />
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
                    :icon="$move::Donation->getIcon()"
                    :active="$tab === $move::Donation->value"
                    wire:click="$set('tab', '{{ $move::Donation->value }}')"
                >
                    {{ __('Donations') }}
                </x-filament::tabs.item>

                <x-filament::tabs.item
                    class="shrink-0"
                    :icon="$move::Petition->getIcon()"
                    :active="$tab === $move::Petition->value"
                    wire:click="$set('tab', '{{ $move::Petition->value }}')"
                >
                    {{ __('Petitions') }}
                </x-filament::tabs.item>

                <x-filament::tabs.item
                    class="shrink-0"
                    :icon="$move::Petition_By_Name->getIcon()"
                    :active="$tab === $move::Petition_By_Name->value"
                    wire:click="$set('tab', '{{ $move::Petition_By_Name->value }}')"
                >
                    {{ __('Petitions') }}
                </x-filament::tabs.item>
            
            </x-filament::tabs>
        </div>        

            {{ $this->table }}  
        </div>
        HTML;
    }
}
