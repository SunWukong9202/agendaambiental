<?php

namespace App\Filament\Imports;

use App\Models\Pivots\Donation;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class DonationImporter extends Importer
{
    protected static ?string $model = Donation::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('type')
                ->label(__('Donation type'))
                ->requiredMapping()
                ->rules(['required']),

            ImportColumn::make('books_taken')
                ->label(__('Books taken'))
                ->requiredMapping()
                ->integer()
                ->rules(['max:255', 'min:0']),

            ImportColumn::make('books_donated')
                ->label(__('Books donated'))
                ->requiredMapping()
                ->integer()
                ->rules(['max:255', 'min:0']),

            ImportColumn::make('quantity')
                ->label(__('Quantity'))
                ->requiredMapping()
                ->numeric(decimalPlaces: 3)
                ->rules(['max:999.999', 'min:0.100']),

            ImportColumn::make('waste')
                ->label(__('waste'))
                ->relationship(resolveUsing: ['category', 'id']),

            ImportColumn::make('event')
                ->label(__('Event'))
                ->relationship(resolveUsing: ['name', 'id']),
        ];
    }

    public function resolveRecord(): ?Donation
    {
        // return Donation::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Donation();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your donation import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
