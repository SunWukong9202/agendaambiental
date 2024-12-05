<?php

namespace Tables;

use App\Utils\BaseTableConfiguration;

class Test extends BaseTableConfiguration
{
    public function getDefaultColumns(): array
    {
        return [
            TextColumn::make('name')->label(__('Name')),
            TextColumn::make('price')->label(__('Price')),
        ];
    }

    public function getDefaultFilters(): array
    {
        return [];
    }

    public function getDefaultActions(): array
    {
        return [];
    }

    public function getDefaultBulkActions(): array
    {
        return [];
    }
}
