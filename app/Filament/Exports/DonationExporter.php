<?php

namespace App\Filament\Exports;

use App\Models\Pivots\Donation;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Filament\Support\Facades\FilamentColor;
use OpenSpout\Common\Entity\Style\CellAlignment;
use OpenSpout\Common\Entity\Style\CellVerticalAlignment;
use OpenSpout\Common\Entity\Style\Style;

class DonationExporter extends Exporter
{
    protected static ?string $model = Donation::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('type')
                ->label(__('Donation type')),
            ExportColumn::make('books_taken')
                ->label(__('Books taken')),
            ExportColumn::make('books_donated')
                ->label(__('Books donated')),
            ExportColumn::make('quantity')
                ->label(__('Quantity')),
            ExportColumn::make('waste.category')
                ->label(__('waste')),
                
            ExportColumn::make('donator_id')
                ->label(__('Donator'))
                ->formatStateUsing(function (Donation $record) {
                    return $record->donator->user?->name ?? $record->donator->name;
                }),

            ExportColumn::make('capturist.user.name')
                ->label(__('Capturist')),

            ExportColumn::make('event.name')
                ->label(__('Event')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your donation export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }

    public function getXlsxHeaderCellStyle(): ?Style
    {
        return (new Style())
            ->setFontBold()
            ->setFontItalic()
            ->setFontSize(14)
            ->setFontName('Consolas')
            ->setFontColor(FilamentColor::rgb(255, 255, 77))
            ->setBackgroundColor(FilamentColor::rgb(0, 0, 0))
            ->setCellAlignment(CellAlignment::CENTER)
            ->setCellVerticalAlignment(CellVerticalAlignment::CENTER);
    }
}
