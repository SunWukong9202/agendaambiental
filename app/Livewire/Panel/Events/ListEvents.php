<?php

namespace App\Livewire\Panel\Events;

use App\Livewire\Panel\Traits\HandlesWasteModel;
use App\Models\Event;
use App\Models\Waste;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class ListEvents extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    use HandlesWasteModel;
    
    public function table(Table $table): Table
    {
        return $table
            ->query(Event::query())
            ->headerActions([
                
                CreateAction::make()
                    ->label(__('form.create waste'))
                    ->modalHeading(__('form.create waste'))
                    ->createAnother(false)
                    ->model(Waste::class)
                    ->form($this->getWasteFormSchema())
            ])
            ->columns([
                TextColumn::make('name')
                    ->label(__('form.name'))
                    ->wrap(),
                TextColumn::make('faculty')
                    ->label(__('form.faculty')),
                // TextColumn::make('description')
                //     ->default(__('form.description.default'))
                //     ->label(__('form.description'))
                //     ->wrap(),

                TextColumn::make('start')
                    ->label(__('form.start date'))
                    ->date(),
                TextColumn::make('end')
                    ->label(__('form.end date'))
                    ->date(),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.panel.events.list-events');
    }
}
