<?php

namespace App\Livewire\Panel\Events;

use App\Enums\Permission;
use App\Livewire\Panel\Traits\HandlesEvent;
use App\Models\Event;
use App\Models\Waste;
use Filament\Tables\Columns\Layout\Split;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class ListEvents extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    use HandlesEvent;

    public function table(Table $table): Table
    {
        $cm_user = auth()->user()->CMUser;
        
        return $table
            ->query(Event::query())
            ->headerActions([
                
                CreateAction::make()
                    ->label(__('ui.buttons.event', ['action' => __('ui.create')]))
                    ->modalHeading(__('ui.buttons.event', ['action' => __('ui.create')]))
                    ->createAnother(false)
                    ->form($this->getEventFormSchema())
                    ->mutateFormDataUsing(function ($data) {
                        $data['cm_user_id'] = auth()->user()->CMUser->id;

                        return $data;
                    })
                    ->successNotification(fn(Event $record) => $this->notification('added', $record->name)),
            ])
            ->columns([
                TextColumn::make('name')
                ->label(__('form.name'))
                ->wrap(),

                TextColumn::make('faculty')
                    ->label(__('form.faculty')),

                TextColumn::make('cmUser.user.name')
                    ->label(__('form.created by')),
                // TextColumn::make('description')
                //     ->default(__('form.description.default'))
                //     ->label(__('form.description'))
                //     ->wrap(),

                TextColumn::make('start')
                    ->label(__('form.start date'))
                    ->since(),
                TextColumn::make('end')
                    ->label(__('form.end date'))
                    ->since()
                    // ->dateTime('M d, Y h:i A')
                    ,
                    
            ])
            ->filters([
                // ...
            ])
            ->actions([
                EditAction::make()
                    ->modalHeading(__('ui.buttons.event', ['action' => __('ui.edit')]))
                    ->hidden(!$cm_user->can(Permission::EditEvents->value))
                    ->form(fn(Event $record) => $this->getEventFormSchema($record))
                    ->successNotification(fn(Event $record) => $this->notification('updated', $record->name)),
                
                DeleteAction::make()
                    ->modalHeading(__('ui.buttons.event', ['action' => __('ui.delete')]))
                    ->hidden(!$cm_user->can(Permission::DeleteEvents->value))
                    ->successNotification(fn(Event $record) => $this->notification('deleted', $record->name))
            ])
            ->bulkActions([
                // ...
            ]);
    }

    private function notification($action, $name): Notification
    {
        return Notification::make()
            ->success()
            ->title(__('ui.notifications.events.title', compact('action')))
            ->body(__('ui.notifications.events.body', compact('action', 'name')));
    }

    // public function render()
    // {
    //     return view('livewire.panel.events.list-events');
    // }

    public function render()
    {
        return <<<'HTML'
        <x-slot:title>
            {{ __('ui.pages.Event History') }}
        </x-slot>
        <div>
            <div class="flex mb-4">
                <x-filament::breadcrumbs :breadcrumbs="[
                    route('admin.events.history') => __('ui.pages.Event History'),
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
