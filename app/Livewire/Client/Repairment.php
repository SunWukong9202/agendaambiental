<?php

namespace App\Livewire\Client;

use App\Models\Pivots\ItemMovement;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\VerticalAlignment;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.client')]
class Repairment extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public ItemMovement $record;

    public function table(Table $table): Table
    {
        return $table
            ->relationship(fn() => auth()->user()->CMUser
                ->repairments()
                ->where('group_id', $this->record->group_id)
            )
            ->columns([
                Stack::make([

                    Split::make([
                        TextColumn::make('type')
                        ->label(__('Stage'))
                        ->badge()
                        ->color(fn($state) => $state->getBagdeColor())
                        ->extraAttributes(['class' => 'uppercase tracking-wide'])
                        // ->icon(fn($state) => $state->getIcon())

                        ,
                        TextColumn::make('created_at')
                        ->label(__('Assigned'))
                        ->formatStateUsing(fn(ItemMovement $record) => $record->dateTime('created_at'))
                        ->alignment(Alignment::End)
                        ->verticalAlignment(VerticalAlignment::End)
                        ->extraAttributes(['class' => 'uppercase'])
                    ]),

                    TextColumn::make('observations')
                        ->translateLabel(),
            
                ])->space(3)
            ]);
    }
    

    public function render()
    {
        return <<<'HTML'
        <div>
            {{ $this->table }}
        </div>
        HTML;
    }
}
