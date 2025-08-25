<?php

namespace App\Livewire\Panel\Tables;

trait ConfigureDelivery
{
    public function getDefaultColumns(): array
    {
        return [
            \Filament\Tables\Columns\TextColumn::make('id')->sortable(),
            \Filament\Tables\Columns\TextColumn::make('name')->searchable(),
        ];
    }

    public function getDefaultFilters(): array
    {
        return [
            \Filament\Tables\Filters\Filter::make('active')->toggle(),
        ];
    }

    public function getDefaultActions(): array
    {
        return [
            \Filament\Tables\Actions\Action::make('edit')->url(fn ($record) => route('edit', $record)),
        ];
    }

    public function getDefaultBulkActions(): array
    {
        return [
            \Filament\Tables\Actions\BulkAction::make('delete')->action(fn ($records) => $records->each->delete()),
        ];
    }
}
