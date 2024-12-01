<?php

namespace App\Livewire\Tables;

use App\Enums\Movement;
use App\Enums\Permission;
use App\Enums\Status;
use App\Livewire\Panel\Traits\HandlesItem;
use App\Models\Item;
use App\Models\Pivots\ItemMovement;
use App\Utils\BaseTableConfiguration;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;

class ItemSchema extends BaseTableConfiguration
{
    use HandlesItem;

    public function __construct(
        public $tab,
        public $status,
    ){}

    public function getDefaultOptions(): array
    {
        return [];
    }

    public function getDefaultColumns(): array
    {
        $related = [];

        if($this->tab == Movement::Reparation->value) {
            $related = [TextColumn::make('related.user.name')
            ->default(__('Not assigned'))
            ->visible()
            ->label(__('Technician'))
            ->searchable()];
        }        

        $issuer = TextColumn::make('user.user.name');

        $related = $this->tab == Movement::Petition->value
            ? [
                $issuer
                ->label(__('Petitioner'))
                ->searchable(),

                TextColumn::make('related.user.name')
                ->label(__('Closed by'))
                ->default('pending')
                ->searchable()
            ]
            : [ 
                $issuer->label(__('Made by'))
                ->searchable()
            ];

        $columns = [
            TextColumn::make('id')
                ->label(__('Item'))
                ->visible(!isset($this->item))
                ->translateLabel()
                ->searchable(
                    query: function ($query, $search) {
                        return $query->search($search, ['item_name'])
                            ->orWhereHas('item', 
                                fn($q) => $q->search($search, ['name'])
                            );
                    }
                )
                ->formatStateUsing(function (ItemMovement $record) {
                    $name = $record->item?->name ?? $record->item_name;
                    // dump($name);
                    return $name; 
                })                
                ,

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


            ...$related,

            TextColumn::make('created_at')
                ->label(__('Issued'))
                ->sortable()
                ->formatStateUsing(fn(ItemMovement $record) => $record->dateTime('created_at'))
        ];

        return [
            $columns            
        ];
    }

    public function defaultGroups(): array
    {
        return [];
    }

    public function defaultHeaderActions(): array
    {
        return [];
    }

    public function getDefaultFilters(): array
    {
        return [
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
        ];
    }

    public function getDefaultActions(): array
    {
        return [
            ActionGroup::make([
                $this->getResolvePetitionAction(),
                $this->getUpdateAssignAction(),
                $this->getLogCommentableAction(asPanelUser: true)
                    ->visible(
                    $this->tab == Movement::Reparation->value
                ),
            ])
        ];
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
            $reparaible = Status::Repairable == $record->status;

            $alreadyEnded = ItemMovement::where('group_id', $record->group_id)
            ->whereIn('status',[Status::Successful, Status::Failed])
            ->first();
            
            return !$reparaible && $alreadyEnded == null;
        })
        ->form(fn(ItemMovement $record) => $this->getEditAssignSchema($record))
        ->using(function (ItemMovement $record, array $data) {

            return $this->handleEditAssignment($record, $data);
        });
    }

    private function outStockNotification(): void
    {
        Notification::make()
            ->warning()
            ->title(__('Out of stock'))
            ->body(__('Come again later. Check with other item or add one.'))
            ->persistent()
            ->send();
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
        ->afterFormFilled(function ($record, EditAction $action) {

            $stock = $this->calculateAvailableByItem($record->item_id);

            if($stock <= 0 && !$record->item_name) {
                $this->outStockNotification();

                $action->cancel();
            }
        })
        ->mutateRecordDataUsing(function ($data) {
            $data['cm_user_id'] = null;
            $this->selectedItem = null;
            if(isset($data['item_id'])) {
                $data['item_name'] = Item::find($data['item_id'])?->name;
            }
            
            return $data;
        })
        ->form(fn (ItemMovement $record) => $this->getSettleSchema($record))
        ->using(function ($record, $data, EditAction $action) use($cm_user) {
            $status = Status::tryFrom($data['status']);

            $stock = $this->calculateAvailableByItem($this->selectedItem?->id);
    
            if($stock <= 0 && $status != Status::Rejected && $record->item_id == null) {
                $this->outStockNotification();

                $action->halt();
            }
            
            $settled = $record->replicate()->fill([
                'status' => $status,
                'related_id' => $cm_user->id,
                'observations' => $data['comment'],
            ]);

            $settled->save();

            $item = $data['item_name'];

            $accepted = $status == Status::Accepted;

            $title = $accepted
                ? __('ui.notifications.p-accepted', compact('item'))
                : __('ui.notifications.p-rejected', compact('item'));
                                    
            $this->buildDBNotification(
                title: $title,
            )
            ->iconColor($status?->getBagdeColor())
            ->icon($status->getIcon())
            //for testing purpose we will notify me
            // ->sendToDatabase(CMUser::find($cm_user->id)->user);
            ->sendToDatabase($record->user->user);
            
            return $record;
        });
    }

    public function getDefaultBulkActions(): array
    {
        return [

        ];
    }


}
