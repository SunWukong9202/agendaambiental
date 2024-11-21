<?php 

namespace App\Livewire\Panel\Traits;

use App\Enums\Movement;
use App\Enums\Permission;
use App\Enums\Role;
use App\Enums\Status;
use App\Forms\Components\Alert;
use App\Livewire\DBNotifications;
use Filament\Forms\Components\View;
use App\Models\CMUser;
use Filament\Tables\Actions\ReplicateAction;
use App\Models\Item;
use App\Models\Pivots\ItemMovement;
use Carbon\Carbon;
use Closure;
use Filament\Actions\Action;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Support\RawJs;
use Filament\Tables\Actions\ViewAction;
use Filament\Widgets\StatsOverviewWidget\Stat;

trait HandlesItem {

    public ?array $itemData = [];
    public ?CMUser $record;
    public ?Item $item = null;
    use DBNotifications;

    public function itemForm(Form $form): Form
    {  
        return $form
            ->schema([
               ...$this->getItemSchema()
            ])
            ->statePath('itemData')
            ;
    }

    private function itemNotification($action, $name): Notification
    {
        $action = __($action);

        return Notification::make()
            ->success()
            ->title(__('ui.notifications.items.title', compact('action')))
            ->body(__('ui.notifications.items.body', compact('action', 'name')));
    }

    public function getLogCommentableAction($asPanelUser = false): ViewAction
    {
        return 
        ViewAction::make('view_history')
        ->label(__('See history'))
        // ->modalSubmitActionLabel(__('Write log'))
        ->form([
            View::make('components.repair-log')
        ])
        ->extraModalFooterActions(fn (ItemMovement $record) => [
                ReplicateAction::make('write-log-comment')
                ->label(__('Write comment'))
                ->modalHeading(__('Write comment'))
                ->modalSubmitActionLabel(__('Publish'))
                ->form([
                    Alert::make()
                        ->info()
                        ->title(
                            $asPanelUser 
                            ? __("We will notify the technician of your comment")
                            : __('By default we notify to the assigner of your published comment: ')
                        ),

                    Textarea::make('comment')
                        ->required()
                        ->rows(5)
                        ->maxLength(255)
                        ->hint(__('form.hints.Max characters', ['max' => 255])),
                ])
                ->using(function ($data, $model) use ($record, $asPanelUser) {

                    // dd($record, $data, $model);

                    $current = auth()->user()->CMUser;
                    
                    $capture = ItemMovement::where('group_id', $record->group_id)
                        ->where('type', Movement::Capture)
                        ->first();

                    if(!$capture) return;

                    $log = $capture->replicate()->fill([
                        'type' => Movement::Reparation,
                        'status' => Status::RepairLog,
                        'observations' => $data['comment'],
                        'related_id' => $current->id,
                    ]);

                    $log?->save();

                    $assigner = $capture->user->user;
                    
                    $technician = $capture->related->user;
                    
                    $recipient = $asPanelUser ? $technician : $assigner;

                    $role = Role::tryFrom($current->roles()?->first()->name)->getTranslatedLabel() ?? __('User');

                    $this->buildDBNotification(
                        title: $role .
                         " {$current->user->name} has published a new comment in the repairment log",
                    )
                    ->iconColor(Status::RepairLog->getBagdeColor())
                    ->icon(Status::RepairLog->getIcon())
                    ->sendToDatabase($recipient);
                    
                    return $log;
                })->successNotificationTitle(__('Published!'))
        ])
        ->slideOver()
        ->extraAttributes(['class' => 'mr-auto']);
    }

    public function deleteItem(): Action
    {
        dd('disptatch');

        return Action::make('delete-item')
            ->requiresConfirmation()
            ->action(fn () => $this->item->delete());
    }

    public function getItemSchema(?Item $record = null)
    {
        return [
            $this->getSelectItemComponent()
                ->label(__('Selected item'))
                ->placeholder(__('All items'))
                ->reactive()
                ->afterStateUpdated(function ($state) {
                    $this->item = Item::find($state);
                    $this->resetTable();
                }),
        ];
    }

    public function createReparationFrom($capture, $data): void
    {
        if(!isset($capture->group_id) &&
            $data['status'] == Status::Repairable->value) {
            //to keep track of the repairment process
            $capture->group_id = $capture->id;
            $capture->saveQuietly();
        }

        $assign = null;

        if(isset($data['related_id'])) {

            $assign = $capture->replicate()->fill([
                'related_id' => $data['related_id'],
                'observations' => $data['comment'],
                'type' => Movement::Reparation,
                'status' => Status::Assigned,
            ]);
            
            $this->buildDBNotification(
                title: __('You have been assigned a new item for reparation'),
            )
            ->icon(Movement::Reparation->getIcon())
            ->iconColor('info')
            ->sendToDatabase(auth()->user());                    
            // ->sendToDatabase(CMUser::find($technician)->user);                    
        }

        //if distinct of null save
        $assign?->saveQuietly();
    }


    public function getEditAssignSchema(ItemMovement $record)
    {
        // $unassign = $this->peek(by: Status::Unassigned, with: $record->group_id)->first()
        // ? 
        
        return [
            $this->getSelectTechnician()
                ->reactive()
                ->required()
                ->disableOptionWhen(function ($value) use($record) {
                    $unassigned = ItemMovement::where('group_id', $record->group_id)
                        ->where('status', Status::Unassigned)->first();
                    
                    return $unassigned?->related_id == $value; 
                }),
            
            Alert::make()
                ->warning()
                ->title(__('ui.helpers.unassign_title'))
                ->description(__('ui.helpers.unique_unassign', ['name' => $record->related?->user->name]))
                ->visible(fn(Get $get) => filled($record->related_id) && $get('related_id') != $record->related_id),

            $this->getTextArea('comment')
                ->placeholder(fn(Get $get) => __('ui.helpers.assign', ['name' => CMUser::find($get('related_id'))?->user->name]))
                ->visible(fn (Get $get) => $get('related_id') != $record->related_id),

            $this->getTextArea('reason')
                ->placeholder(__('ui.helpers.unassign', ['name' => $record->related?->user->name]))
                ->visible(fn(Get $get) => filled($record->related_id) && $get('related_id') != $record->related_id),
        ];
    }

    public function handleEditAssignment(ItemMovement $record, array $data) {
        $old = $record->related_id;
        $new = $data['related_id'] ?? null;
        $unassign = null;
        // dump('handle-edit');

        // dump($record, $new, $data);

        if(filled($old) && $old != $new){
            //if there was already assigned we add the unassign movement to that user

            $unassign = $record->replicate()->fill([
                'related_id' => $old,
                'type' => Movement::Reparation,
                'status' => Status::Unassigned,
                'observations' => $data['reason']
            ]);

            $this->buildDBNotification(
                title: __('You have been unassigned from an item reparation'),
            )
            ->icon(Movement::Reparation->getIcon())
            ->iconColor('danger')
            ->sendToDatabase(CMUser::find($old)?->user);

            $unassign->save();
        } 
        if(!isset($new)) return $record;
        // dump('before update - handle edit');
        // dump($record, $new, $data);

        $record->update([
            'related_id' => (int) $new
        ]);
        
        $assign = $record->replicate()->fill([
            'type' => Movement::Reparation,
            'status' => Status::Assigned,
            'observations' => $data['comment'],
        ]);

        // dump('after update - handle edit');
        // dump($record, $new, $assign);

        $this->buildDBNotification(
            title: __('You have been assigned a new item for reparation'),
        )
        ->icon(Movement::Reparation->getIcon())
        ->iconColor('info')
        ->sendToDatabase(CMUser::find($new)->user);

        $assign->save();

        return $record;
    }

    //Working?
    public function getCaptureSchema($auth_user = null)
    {
        $cm_user = $auth_user ?? auth()->user()->CMUser;

        return [
            Split::make([
                $this->getSelectItemComponent($cm_user)
                    ->label(__('Item'))
                    ->placeholder(__('ui.placeholders.item-capture'))
                    ->helperText(__('ui.helpers.item-not-found'))
                    ->required()
                    ->afterStateUpdated(fn($state) => 
                        $this->selectedItem = Item::find($state)
                    ),                  

                $this->getStatusComponent(Status::by(Movement::Capture))
                ->reactive(),

            ])->from('sm'),

            $this->getTextArea('observations')
                ->placeholder(__('ui.helpers.item-capture')),

            Grid::make(['sm' => 2])
            ->schema([
                Alert::make()
                    ->info()
                    ->title(__('ui.helpers.assign-technician-title'))
                    ->description(__('ui.helpers.assign-technician'))
                    ->columnSpanFull(),

                $this->getSelectTechnician()
                    ->columnSpanFull(),

                $this->getTextArea('comment')
                    ->placeholder(__('ui.helpers.repair-assign'))
                    ->columnSpanFull()
            ])
            ->visible(fn(Get $get) => 
                isset($this->selectedItem->id) &&  
                $get('status') == Status::Repairable->value
                && $cm_user->can(Permission::AssignRepairments->value)
            )                
        ];
    }
    //I think working
    public function getSettleSchema(ItemMovement $record): array
    {
        $additionals = $record->type == Movement::Petition_By_Name 
        ? [
            Alert::make()
                ->info()
                ->title(__('ui.helpers.named-petition-title'))
                ->description(__('ui.helpers.named-petition-description'))
                ->addListOption(__('ui.helpers.named-petition-op1'))
                ->addListOption(__('ui.helpers.named-petition-op2')),

            Split::make([
                $this->getSelectItemComponent()
                ->reactive()
                ->afterStateUpdated(fn($state) => 
                    $this->selectedItem = Item::find($state)
                )
                ->label(__('Item'))
                ->helperText(__('ui.helpers.item-not-found'))
                ->required(),

                $this->getStatusComponent([
                    Status::Accepted, Status::Rejected
                ]),     
            ])->from('md')
        ] : [
            $this->getStatusComponent([
                Status::Accepted, Status::Rejected
            ]),     
        ];

        return [
            $this->applyCopyable($this->getNamePetitionComponent())
                ->readOnly(),

            $this->getTextArea('observations', 'User comment')
                ->readOnly(),

            ...$additionals,

            $this->getTextArea('comment')
                ->required()
                ->placeholder(
                    __('ui.placeholders.resolve-petition-reason')
                ),
        ];

    }

    //Working
    public function getItemPetitionSchema()
    {
        return [
            Select::make('item_id')
                ->label(__('Item'))
                ->options(Item::all()->pluck('name', 'id'))
                ->placeholder(__('I can\'t find the item im looking for.'))
                ->required(fn(Get $get) => !filled($get('item_name')))
                ->native(false)
                ->searchable()
                ->reactive(),

            $this->getNamePetitionComponent()
                ->visible(fn(Get $get) => !filled($get('item_id')))
                ->required(fn(Get $get) => !filled($get('item_id')))
                ->unique('items', 'name')
                ->validationMessages([
                    'unique' => __('The :attribute already exists. Please search in the select.'),
                ]),

            $this->getTextArea('observations')
                ->placeholder(__('ui.helpers.item-petition')),
        ];
    }

    private function peek(Movement $movement, $by, ?Status $with = null)
    {
        $query = ItemMovement::where('group_id', $by);

        if($movement == Movement::LastRepairLog) {
            $query->orderBy('created_at', 'desc');
        } else if ($movement) {
            $query->where('type', $movement);
        }

        if($with) {
            $query->where('status', $with);
        }

        return $query;
    }

    public function getStatusComponent($options)
    {
        $select = Select::make('status')
            ->required()
            ->label(__('Status'));


        if(count($options) == 1) {
            $select
                ->extraAttributes(['style' => 'pointer-events: none; opacity: 0.6;'])
                ->selectablePlaceholder(false)
                ->helperText(__('By default we set this value because is the only selectable option'))
                ->formatStateUsing(fn() => $options[0]->value)
                ;
        }

        $select->options(
            Status::buildSelect($options)
        );

        return $select;
    }

    public function getTextArea($state, $label = null)
    {
        $label = $label ?? ucfirst($state);

        return Textarea::make($state)
            ->label(__($label))
            ->hint(__('form.hints.Max characters', ['max' => 255]))
            ->maxLength(255);
    }

    private function applyCopyable(Component $component): Component
    {
        return $component
            ->suffixAction(
                FormAction::make('copy')
                    ->icon('heroicon-s-clipboard')
                    ->action(function ($livewire, $state) {
                        $livewire->dispatch('copy-to-clipboard', text: $state);
                    })
            )
            ->extraAttributes([
                'x-data' => '{
                    copyToClipboard(text) {
                        if (navigator.clipboard && navigator.clipboard.writeText) {
                            navigator.clipboard.writeText(text).then(() => {
                                $tooltip("Copied to clipboard", { timeout: 1500 });
                            }).catch(() => {
                                $tooltip("Failed to copy", { timeout: 1500 });
                            });
                        } else {
                            const textArea = document.createElement("textarea");
                            textArea.value = text;
                            textArea.style.position = "fixed";
                            textArea.style.opacity = "0";
                            document.body.appendChild(textArea);
                            textArea.select();
                            try {
                                document.execCommand("copy");
                                $tooltip("Copied to clipboard", { timeout: 1500 });
                            } catch (err) {
                                $tooltip("Failed to copy", { timeout: 1500 });
                            }
                            document.body.removeChild(textArea);
                        }
                    }
                }',
                'x-on:copy-to-clipboard.window' => 'copyToClipboard($event.detail.text)',
            ]);
    }

    public function getNamePetitionComponent()
    {
        return TextInput::make('item_name')
            ->label(__('Item name'))
            ->maxLength(80)
            ->hint(__('form.hints.Max characters', ['max' => 80]))
            ;
    }

    public function getSelectTechnician()
    {
        return Select::make('related_id')
            ->label(__('Technician'))
            ->searchable()
            ->helperText(__('ui.helpers.technician'))
            ->options(CMUser::select('id', 'user_id')
                ->role(Role::RepairTechnician->value)
                ->with('user:id,name')
                ->get()
                ->mapWithKeys(fn($row) => [$row->id => $row->user->name])
                ->toArray()
            );
    }

    public $selectedItem = null;

    public function getSelectItemComponent($auth = null, CMUser $creator = null)
    {
        $cm_user = $auth ?? auth()->user()->CMUser;

        return Select::make('cm_user_id')
            ->relationship('hasItems', 'name')
            ->native(false)
            ->searchable()
            ->preload()
            ->optionsLimit(20)
            //warning: this will make an unpersisted user and set that to cm_user_id
            ->model($creator ?? new CMUser)//allow all or filter by creator
            ->createOptionForm(
                $cm_user->can(Permission::AddItems->value)
                ? [
                    $this->getNameComponent()
                        ->unique(
                            table: Item::class,
                        )
                        ->validationMessages([
                            'unique' => __('The :attribute already exists. Please search in the select.'),
                        ]),
                  ]
                : []
            )
            ->createOptionUsing(function ($data) use ($cm_user) {
                $data['cm_user_id'] = $cm_user->id;
                // dd($data);
                return Item::create($data)->id;
            })  
            ->editOptionForm(
                $cm_user->can(Permission::EditItems->value)
                ? [
                    $this->getNameComponent()
                        ->unique(
                            table: Item::class,
                            ignorable: $this->selectedItem ?? $this->item
                        )
                  ]
                : []
            )
            ;
    }

    public function getNameComponent()
    {
        return TextInput::make('name')
            ->label(__('form.name'))
            ->hint(__('form.hints.Max characters', ['max' => 80]))
            ->maxLength(80)
            ->required();
    }
}


// public function getSelectItem($auth = null)
// {
//     $cm_user = $auth ?? auth()->user()->CMUser;

//     return Select::make('item_id')
//         ->options(
//             Item::all()->pluck('name', 'id')
//         )
//         ->native(false)
//         ->searchable()
//         ->preload()
//         ->optionsLimit(20)
//         ->createOptionForm(
//             $cm_user->can(Permission::AddItems->value)
//             ? [
//                 $this->getNameComponent()
//                     ->unique(
//                         table: Item::class,
//                     ),
//               ]
//             : null
//         )
//         ->editOptionForm(
//             [
//                 $this->getNameComponent()
//                     // ->disabled(!$cm_user->can(Permission::EditItems->value))
//                     ->unique(
//                         table: Item::class,
//                         ignorable: $this->selectedItem
//                     ),
//             ]
//         )
        
//         ;
// }

// public function getQuantityComponent()
// {
//     return TextInput::make('quantity')
//         ->label(__('form.Quantity'))
//         ->default(1)
//         ->minValue(1)
//         ->maxValue(255);
// }

// public function getStockComponent()
// {
//     return TextInput::make('stock')
//         ->label(__('form.stock'))
//         ->numeric()
//         ->minValue(0)
//         ->maxValue(255)
//         ->required();
// }