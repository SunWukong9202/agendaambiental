<?php

namespace App\Livewire\Panel\Events;

use App\Enums\Movement;
use App\Enums\Permission;
use App\Enums\Status;
use App\Livewire\DBNotifications;
use App\Livewire\Panel\Traits\HandlesItem;
use App\Models\CMUser;
use App\Models\Item;
use App\Models\Pivots\ItemMovement;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Livewire;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\View;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Component;

class ListItems extends Component implements HasForms, HasTable, HasActions
{
    use InteractsWithTable;
    use InteractsWithForms;
    use InteractsWithActions;
    use DBNotifications;//trait to avoid repetition

    use HandlesItem;
    #[Url(as: 'movement')]
    public $tab = null;
    public $status = null;

    protected $previousTab = null;

    public function mount(): void
    {
        $this->record = new CMUser;
        $this->itemForm->fill();
    }

    public function updatedTab(): void
    {
        $this->resetTable();
    }

    public function getForms(): array
    {
        return [
            'itemForm',
        ];
    }

    public function getQuery() 
    {       
        $query = ItemMovement::query()
            ->whereIn('type', Movement::ofItems());
            
        if(isset($this->tab)) {
            $move = Movement::tryFrom($this->tab);
            $status = [];

            if($move != Movement::Capture) {
                $status = Status::by($move); 
            } else {
                $status = Status::by(null);
            }

            $query->whereIn('status', $status);

            if($move != Movement::Reparation) {
                $query->where('type', $move);
            } else {
                $query = ItemMovement::select('group_id', DB::raw('MAX(id) as latest_id'));
                    
                if(isset($this->item)) {
                    $query->where('item_id', $this->item->id);
                }

                $lastones = $query->groupBy('group_id')
                    ->pluck('latest_id');

                return ItemMovement::whereIn('id', $lastones)->whereIn('status', $status);
            }
                
        }

        if(isset($this->item)) {
            $query->where('item_id', $this->item->id);
        }

        return $query->orderBy('updated_at', 'desc');
    }

    public function table(Table $table): Table
    {
        $cm_user = auth()->user()->CMUser;

        $related = [];

        if($this->tab == Movement::Reparation->value) {
            $related = [TextColumn::make('related.user.name')
            ->default(__('For determine'))
            ->visible()
            ->label(__('Technician'))
            ->searchable()];
        }        

        if($this->tab == Movement::Petition->value ||
           $this->tab == Movement::Petition_By_Name->value) {
            $related = [TextColumn::make('related.user.name')
                ->default(__('For determine'))
                ->label(__('Closed by'))
                ->searchable()];
        }

        $columns = [
            TextColumn::make('item.name')
                // ->formatStateUsing(fn ($state) => Item::find($state)?->name)
                ->translateLabel()
                ->searchable()
                ->default(__('Not assigned to an item'))
                ->visible(!isset($this->item) && 
                    $this->tab != Movement::Petition_By_Name->value
                ),

            TextColumn::make('item_name')
                ->translateLabel()
                ->searchable()
                ->visible($this->tab == Movement::Petition_By_Name->value),

            TextColumn::make('type')
                ->translateLabel()
                ->badge()
                ->visible(Movement::tryFrom($this->tab) == null)
                ->formatStateUsing(fn($state) => $state->value)
                ->color(fn ($state) => $state->getBagdeColor()),
            
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

            ...$related,

            TextColumn::make('created_at')
                ->label(__('Issued'))
                ->sortable()
                ->formatStateUsing(fn(ItemMovement $record) => $record->dateTime('created_at'))
        ];
        
        return $table
            // ->poll('10s')
            ->query($this->getQuery())
            ->paginated([4, 8, 15, 25, 50, 100, 'all'])
            ->defaultPaginationPageOption(8)
            ->searchPlaceholder(__('Search by item/user name'))
            ->headerActions([
                
            ])
            ->columns($columns)
            ->filters([
                    Filter::make('status')
                        ->form([
                            Select::make('status')
                                ->disabled($this->tab == Movement::Reparation->value)
                                ->placeholder(__('All'))
                                // ->options(fn ($livewire) => 
                                //     dd($livewire)
                                // )
                                ->options(Status::buildSelect(
                                        $this->tab != Movement::Capture->value 
                                         ? Status::by($this->tab)
                                         : [ Status::Accepted ]
                                    )
                                )
                                ->default($this->status)
                        ])
                        ->query(function ($query, $data) {
                            return $query->
                                when(
                                    $data['status'],
                                    fn($query) => $query->where('status', $data['status'])
                                );
                        })
                ], 
                // layout: FiltersLayout::AboveContentCollapsible
            )
            ->filtersTriggerAction(
                fn (Action $action) => $action
                    ->button()
                    ->label(__('Filter')),
            )
            ->actions([
                ActionGroup::make([
                    $this->getResolvePetitionAction(),
                    $this->getUpdateAssignAction(),
                    $this->getLogCommentableAction(asPanelUser: true)
                        ->visible(
                        $this->tab == Movement::Reparation->value
                    ),
                ])
            ])
            ->bulkActions([
                // ...
            ]);
    }

    private function getUpdateAssignAction(): EditAction
    {
        return EditAction::make()
        ->label(fn (ItemMovement $record) => 
        isset($record->related_id) ? __('Edit assignenment')
                                   : __('Assign technician'))
        ->modalHeading(fn (ItemMovement $record) => 
            isset($record->related_id) ? __('Edit assigned technician')
                                       : __('Assign technician')
        )
        ->hidden(function (ItemMovement $record) {
            //not in {capture,} 
            if(!isset($record->group_id)) return true;

            $alreadyStarted = ItemMovement::where('group_id', $record->group_id)
            ->where('status', Status::RepairLog)
            ->first();
            
            return $alreadyStarted;
        })
        ->form(fn(ItemMovement $record) => $this->getEditAssignSchema($record))
        ->using(function (ItemMovement $record, array $data) {

            return $this->handleEditAssignment($record, $data);
        });
    }

    private function getResolvePetitionAction($cm_user = null): EditAction
    {
        $cm_user = auth()->user()->CMUser;
        
        return EditAction::make('settle-petition')
        ->label(__('Resolve petition'))
        ->modalHeading(__('Resolve petition'))
        ->visible(function (ItemMovement $record) use ($cm_user) {
            $has_ability = $cm_user->can(Permission::SettleItemPetitions->value);
            $is_petition = in_array($record->type, [
                Movement::Petition, Movement::Petition_By_Name
            ]);

            $isnt_settled = $record->status == Status::In_Progress;

            return $is_petition && $has_ability && $isnt_settled;
        })
        ->mutateRecordDataUsing(function ($data) {

            $data['cm_user_id'] = null;

            if(isset($data['item_id'])) {
                $this->selectedItem = Item::find($data['item_id']);
                $data['item_name'] = $this->selectedItem->name;
            }
            
            return $data;
        })
        ->form(fn (ItemMovement $record) => $this->getSettleSchema($record))
        ->using(function ($record, $data) use($cm_user) {

            $status = Status::tryFrom($data['status']);
            
            $record->update([
                'status' => $status,
                'related_id' => $cm_user->id,
                'item_id' => $this->selectedItem?->id,
            ]);

            $item = $this->selectedItem?->name ?? $data['item_name'];

            $accepted = $status == Status::Accepted;
            $title = $accepted
                ? __('ui.notifications.p-accepted', compact('item'))
                : __('ui.notifications.p-rejected', compact('item'));
                                    
            $this->buildDBNotification(
                title: $title,
                body: $data['comment']
            )
            ->iconColor($status?->getBagdeColor())
            ->icon($status->getIcon())
            //for testing purpose we will notify me
            ->sendToDatabase(CMUser::find($cm_user->id)->user);
            // ->sendToDatabase(CMUser::find($record->cm_user_id)->user);
            
            return $record;
        });
    }
    //if no render provided livewire resolves by the convention with the component name
}




// Filter::make('type')
// ->form([
//     Select::make('type')
//         ->reactive()
//         ->placeholder(__('All'))
//         ->options(Movement::buildSelect(Movement::ofItems())),
    
//     Select::make('status')
//         ->placeholder(__('All'))
//         ->visible(fn (Get $get) => filled($get('type')))
//         ->options(fn(Get $get) => 
//             Status::buildSelect(Status::by($get('type')))
//         )

// ])
// ->query(function (Builder $query, array $data): Builder {
//     return $query
//         ->when(
//             $data['type'],
//             fn(Builder $query) => $query->where('type', $data['type'])
//         )
//         ->when(
//             $data['status'],
//             fn(Builder $query) => $query->where('status', $data['status'])
//         );
// })

// public function render()
// {
//     return <<<'HTML'
//     <div>
    
//     </div>
//     HTML;
// }

                    
// <!-- <div class="mt-8">
// @livewire(\App\Livewire\Widgets\ItemsOverview::class)
// </div>                     -->

// CreateAction::make()
//     ->label(__('Create Item'))
//     ->modalHeading(__('Create Item'))
//     ->createAnother(false)
//     ->form($this->getItemSchema())
//     ->successNotification(fn(Item $record) => $this->itemNotification('added', $record->name)),

// EditAction::make()
//     ->modalHeading(__('Edit item'))
//     ->hidden(!$cm_user->can(Permission::EditItems->value))
//     ->form(fn(Item $record) => $this->getEventFormSchema($record))
//     ->successNotification(fn(Item $record) => $this->itemNotification('updated', $record->name)),

// DeleteAction::make()
//     ->modalHeading(__('Delete item'))
//     ->hidden(!$cm_user->can(Permission::DeleteEvents->value))
//     ->successNotification(fn(Item $record) => $this->itemNotification('deleted', $record->name))
