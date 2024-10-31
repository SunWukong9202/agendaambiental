<?php

namespace App\Livewire\Panel\Events;

use App\Livewire\Panel\Traits\HandlesWasteModel;
use App\Models\Waste;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class ListWastes extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    use HandlesWasteModel;
    
    public function table(Table $table): Table
    {
        return $table
            ->query(Waste::query())
            ->headerActions([
                CreateAction::make()
                    ->label(__('form.create waste'))
                    ->modalHeading(__('form.create waste'))
                    ->createAnother(false)
                    ->model(Waste::class)
                    ->form($this->getWasteFormSchema())
            ])
            ->columns([
                TextColumn::make('category')
                    ->searchable()
                    ->label(__('form.category'))
                    ->wrap(),

                SelectColumn::make('unit')
                    ->label(__('form.unit'))
                    ->options(__('form.units'))
                    ->rules(['required']),

                TextColumn::make('created_at')
                    ->label(__('form.created at'))
                    ->date()
            ])
            ->filters([
                // ...
            ])
            ->actions([
                DeleteAction::make(),
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.panel.events.list-wastes');
    }
}
