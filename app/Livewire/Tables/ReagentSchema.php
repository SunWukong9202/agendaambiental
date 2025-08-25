<?php

namespace App\Livewire\Tables;

use App\Utils\BaseTableConfiguration;
use Filament\Tables\Columns\TextColumn;

class ReagentSchema extends BaseTableConfiguration
{
    public function getDefaultOptions(): array
    {
        return [];
    }

    public function getDefaultColumns(): array
    {
        return [
            TextColumn::make('name')->label(__('Name')),
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

        ];
    }

    public function getDefaultFilters(): array
    {
        return [

        ];
    }

    public function getDefaultActions(): array
    {
        return [

        ];
    }

    public function getDefaultBulkActions(): array
    {
        return [

        ];
    }
}
