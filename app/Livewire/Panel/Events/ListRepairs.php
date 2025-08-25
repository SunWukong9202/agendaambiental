<?php

namespace App\Livewire\Panel\Events;

use App\Enums\Movement;
use App\Enums\Status;
use App\Livewire\Panel\Traits\HandlesItem;
use App\Livewire\Panel\Traits\HandlesItemMovement;
use App\Models\Pivots\ItemMovement;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Livewire\Component;

class ListRepairs extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    use HandlesItemMovement;

    public function getQuery() 
    {        
        return ItemMovement::query()
            ->whereIn(
                'status', 
                [
                    // Status::Repaired, 
                    // Status::Unrepairable,
                    Status::Repairable, 
                ]
            );
    }

    public function table(Table $table): Table
    {
        $cm_user = auth()->user()->CMUser;
        
        return $table
            ->query($this->getQuery())
            ->searchPlaceholder(__('Search by item/user name'))
            ->recordUrl(
                fn (ItemMovement $record) => route('admin.events.repairmentLog', ['movement' => $record]) 
            )
            // ->groups([
            //     Group::make('group_id')
            //         ->label(__('Repairment'))
            //         ,
            // ])
            // ->defaultGroup('group_id')
            ->columns([
                TextColumn::make('item.name')
                    ->searchable()
                    ->visible(!isset($this->item))
                    ,
                
                TextColumn::make('status')
                    ->badge()
                    ->icon(fn($state) => $state->getIcon())
                    ->color(fn ($state) => $state->getBagdeColor())
                    ->tooltip(fn (ItemMovement $record) => 
                        $record->status == Status::Repairable 
                            ? ($record->related?->user?->name ?? 'Not Assigned')
                            : null 
                    ),

                TextColumn::make('user.user.name')
                    ->label(__('Issued by'))
                    ->searchable()
                    ,

                TextColumn::make('created_at')
                    ->label(__('Issued'))
                    ->formatStateUsing(fn(ItemMovement $record) => $record->dateTime('created_at'))

            ])->actions([
                EditAction::make()
                    ->modalHeading('Edit assigned technician')
                    ->disabled(function (ItemMovement $record) {
                        $alreadyStarted = ItemMovement::where('group_id', $record->group_id)
                        ->where('type', Movement::Repair_Started)
                        ->first();

                        return $alreadyStarted;
                    })
                    ->form(fn(ItemMovement $record) => $this->getEditReparimentSchema($record))
                    ->using(function (ItemMovement $record, array $data) {
                        $old = $record->related_id;
                        $new = $data['related_id'];
                        $unassign = null;

                        if(filled($old) && $old != $new){
                            //if there was already assigned we add the unassign movement to that user
                    
                            $unassign = $record->replicate()->fill([
                                'related_id' => $old,
                                'type' => Movement::Assignment,
                                'status' => Status::Unassigned,
                                'observations' => $data['reason']
                            ]);
    
                            $unassign->save();
                        } 

                        $record->update([
                            'related_id' => (int) $new
                        ]);
                        
                        $assign = $record->replicate()->fill([
                            'type' => Movement::Assignment,
                            'status' => Status::Assigned,
                            'observations' => $data['comment'],
                        ]);

                        $assign->save();

                        return $record;
                    })
                    
            ]);
    }

    // ->readOnly(function () use ($record) {
    //     if(!$record) return false;

    //     $started = ItemMovement::where('group_id', $record->id)
    //         ->where('type', Movement::Repair_Started)
    //         ->first();
        
    //     return isset($started);
    // })

    public function render()
    {
        return <<<'HTML'
        <div>
            <div class="flex mb-4">
                <x-filament::breadcrumbs :breadcrumbs="[
                    route('admin.events.repairments') => __('ui.pages.Repairment Managment'),
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
