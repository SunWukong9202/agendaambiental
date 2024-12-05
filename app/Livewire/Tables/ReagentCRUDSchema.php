<?php

namespace App\Livewire\Tables;

use App\Models\Reagent;
use App\Utils\BaseTableConfiguration;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;

class ReagentCRUDSchema extends BaseTableConfiguration
{
    public function getDefaultOptions(): array
    {
        return [];
    }

    public function getDefaultColumns(): array
    {
        return [
            TextColumn::make('name')->label(__('Name'))
                ->searchable(),
            TextColumn::make('group')->label(__('Chemical group'))
                ->searchable(),
            TextColumn::make('chemical_formula')->label(__('Chemical formula'))
                ->sortable(),
            ToggleColumn::make('visible')->label(__('Visible'))
                ->sortable()
                ->afterStateUpdated(function ($record, $state) {
                    Notification::make()->success()
                        ->title(__('Saved'))
                        ->send();
                }),
            TextColumn::make('user.user.name')->label(__('Added by')),
            TextColumn::make('created_at')
                ->label(__('Created at'))
                ->sortable()
                ->formatStateUsing(fn (Reagent $record) =>  
                    $record->dateTime('created_at')
                )
        ];
    }

    public function defaultGroups(): array
    {
        return [
            
        ];
    }

    public function defaultHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalHeading(__('Create reagent'))
                ->label(__('Create reagent'))
                ->createAnother(false)
                ->form($this->reagentSchema())
                
        ];
    }

    protected function reagentSchema($record = null): array
    {
        return [
            //name max:80, group max:16, chem_f max:16, visible bool
            Split::make([
                TextInput::make('name')
                    ->label(__('Name'))
                    ->maxLength(80)
                    ->required()
                    ->unique(
                        table: Reagent::class,
                        ignorable: $record
                    )
                    ->hint(__('form.hints.Max characters', ['max' => 80])),

                TextInput::make('group')
                    ->label(__('Chemical group'))
                    ->maxLength(16)
                    ->required()
                    ->hint(__('form.hints.Max characters', ['max' => 16])),
            ])->from('md'),

            Split::make([
                TextInput::make('chemical_formula')
                    ->label(__('Chemical formula'))
                    ->maxLength(16)
                    ->required()
                    ->hint(__('form.hints.Max characters', ['max' => 16])),
                
                ToggleButtons::make('visible')
                    ->label(__('Want to make this reagent visible?'))
                    ->boolean()
                    ->grouped()
            ])->from('md')
        ];
    }

    public function getDefaultFilters(): array
    {
        return [];
    }

    public function getDefaultActions(): array
    {
        return [
            EditAction::make()
                ->modalHeading(__('Edit reagent'))
                ->form(fn(Reagent $record) => $this->reagentSchema($record)),

            DeleteAction::make()
                ->modalHeading(__('Delete reagent'))
        ];
    }

    public function getDefaultBulkActions(): array
    {
        return [

        ];
    }
}
