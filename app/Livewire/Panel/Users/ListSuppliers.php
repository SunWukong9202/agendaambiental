<?php

namespace App\Livewire\Panel\Users;

use App\Models\Supplier;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class ListSuppliers extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    
    public function table(Table $table): Table
    {
        return $table
            ->query(Supplier::query())
            ->columns([
                TextColumn::make('name')
                    ->label(__('form.name')),

                // TextColumn::make('tax_id')
                //     ->label(__('form.tax id')),

                TextColumn::make('business_name')
                    ->label(__('form.business name')),
                
                TextColumn::make('business_activity')
                    ->label(__('form.business activity')),

                TextColumn::make('created_at')
                    ->label(__('form.created at'))
                    ->since()
                    ->dateTimeTooltip(),
                // TextColumn::make('update_at')
                //     ->label(__('form.name')),
                
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
        return view('livewire.panel.users.list-suppliers');
    }
}
