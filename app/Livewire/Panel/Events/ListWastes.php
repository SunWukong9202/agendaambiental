<?php

namespace App\Livewire\Panel\Events;

use App\Livewire\Panel\Traits\HandlesWasteModel;
use App\Models\Waste;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\Layout\Stack;
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
                Stack::make([
                    TextColumn::make('category')
                    ->weight(FontWeight::SemiBold)
                    ->searchable()
                    ->label(__('form.category'))
                    ->wrap(),

                    SelectColumn::make('unit')
                        ->label(__('form.unit'))
                        ->grow()
                        ->width('100%')
                        ->options(__('form.units'))
                        ->rules(['required'])
                        ->afterStateUpdated(function ($record, $state) {
                            Notification::make()
                                ->success()
                                ->title(__('Saved!'))
                                ->send();
                        }),

                    TextColumn::make('created_at')
                        ->label(__('form.created at'))
                        ->formatStateUsing(fn(Waste $record) => $record->dateTime('created_at'))

                ])->space(2)
            ])
            ->contentGrid([
                'sm' => 2,
                'md' => 3,
                'xl' => 4,
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

    // public function render()
    // {
    //     return view('livewire.panel.events.list-wastes');
    // }

    public function render()
    {
        return <<<'HTML'
        <div>
            <div class="flex mb-4">
                <x-filament::breadcrumbs :breadcrumbs="[
                    route('admin.events.wastes') => __('ui.pages.Waste Managment'),
                    '' => __('ui.list'),
                    ]"
                />
                <x-filament::loading-indicator wire:loading class="inset-y-1/2 text-primary-600 inline-block ml-2 h-5 w-5" />
            </div>
            {{ $this->table }}
        </div>
        HTML;
    }
}
