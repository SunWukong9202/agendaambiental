<?php 

namespace App\Livewire\Panel\Traits;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

trait HasDateFilters {

    public function getDateIntervalFilter()
    {
        return Filter::make('created_at')
        ->form([
            DatePicker::make('created_from'),
            DatePicker::make('created_until'),
        ])
        ->query(function (Builder $query, array $data): Builder {
            return $query
                ->when(
                    $data['created_from'],
                    fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                )
                ->when(
                    $data['created_until'],
                    fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                );
        });
    }

    public function getTimeIntervalFilter()
    {
        return Filter::make('created_at')
        ->form([
            TimePicker::make('created_from'),
            TimePicker::make('created_until'),
        ])
        ->query(function (Builder $query, array $data): Builder {
            return $query
                ->when(
                    $data['created_from'],
                    fn (Builder $query, $date): Builder => $query->whereTime('created_at', '>=', $date),
                )
                ->when(
                    $data['created_until'],
                    fn (Builder $query, $date): Builder => $query->whereTime('created_at', '<=', $date),
                );
        });
    }

}