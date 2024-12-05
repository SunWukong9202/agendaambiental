<?php

namespace App\Livewire\Panel\Events;

use App\Enums\EloquentRelation;
use App\Enums\EventDonation;
use App\Enums\Movement;
use App\Enums\Permission;
use App\Enums\Status;
use App\Filament\Exports\DonationExporter;
use App\Filament\Imports\DonationImporter;
use App\Livewire\DBNotifications;
use App\Livewire\Panel\Traits\HandlesActiveEvent;
use App\Livewire\Panel\Traits\HandlesItem;
use App\Livewire\Panel\Traits\HandlesModelUser;
use App\Livewire\Panel\Traits\HandlesUserDonations;
use App\Models\CMUser;
use App\Models\Event;
use App\Models\Pivots\Donation;
use App\Models\Pivots\ItemMovement;
use App\Models\User;
use App\Models\Waste;
// use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Split as InfoSplit;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Actions\Action as NotificationAction;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Validation\Rules\File;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class ListActives extends Component 
// implements HasForms
 implements HasForms, HasTable, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithTable;
    use InteractsWithForms;
    use HandlesUserDonations;
    use HandlesItem;

    public $action = 'list';
    public $data = [];
    public $tab = false;

    public ?Event $event = null;

    public function mount(): void
    {
        $this->donator = new CMUser;
        // $this->testForm->fill($this->test->donations->toArray());
        $this->userForm->fill();
        // $this->donationsForm->fill();
        $this->selectActive->fill();
    }

    public function send(): void
    {
        Notification::make()
            ->title('hey')
            ->send();
    }

    public function sendDBNotification(): void
    {
        $recipient = auth()->user();
        
        Notification::make()
            ->title('Saved successfully')
            ->actions([
                NotificationAction::make('markAsRead')
                    ->translateLabel()
                    ->link()
                    ->markAsRead(),
                
                NotificationAction::make('markAsUnread')
                    ->translateLabel()
                    ->link()
                    ->markAsUnread(),
            ])
            ->sendToDatabase($recipient);
    }

    public function getForms()
    {
        return [
            // 'donationsForm',
            'userForm',
            'selectActive',
            // 'testForm'
        ];
    }

    public function updatedTab(): void
    {
        $this->resetTable();
    }

    private function queryActives()
    {
        return Event::where('start', '<=', now())
            ->where('end', '>=', now());
    }

    private function getSelectActive()
    {
        return Select::make('event_id')
        ->label(__('Evento'))
        ->native(false)
        ->placeholder(__('All'))
        ->options($this->queryActives()->pluck('name', 'id'))
        ->searchable()
        ->reactive();
    }

    public function selectActive(Form $form): Form
    {
        $actives = $this->getSelectActive()
            ->afterStateUpdated(fn($state) => 
                $this->event = Event::find($state)
            );    
        return $form
            ->schema([$actives])
            ->statePath('data');
    }

    public function eventInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->event ?? new Event) 
            ->schema([
                Section::make('Event details')
                ->translateLabel()
                ->collapsible()
                ->collapsed()
                ->schema([
                    InfoSplit::make([
                        TextEntry::make('faculty')
                            ->grow(),

                        TextEntry::make('start')
                            ->since(),
    
                        TextEntry::make('end')
                            ->since(),
                    ])->columnSpan(2),

                    TextEntry::make('description')
                    ->columnSpan(2),
                ])
                ->visible(fn() => isset($this->event))
            ]);
    }
    
    public function getQuery()
    {
        $query = Donation::where('type', EventDonation::tryFrom($this->tab)?->value);
        $actives = $this->queryActives()->pluck('id')->toArray();
        // dd($actives);
        
        return isset($this->event) 
            ? $query->where('event_id', $this->event->id)
            : $query->whereIn('event_id', $actives);
    }

    private function bookDonation($record): bool
    {
        return EventDonation::Books->value == $record?->type;
    }

    public function table(Table $table): Table
    {
        $cm_user = auth()->user()->CMUser;
        //type,books_taken, books_donated, quantity, waste_id, event_id,
        //cm_user_id, donator_id
        $columns = [
            TextColumn::make('type')
                ->label(__('Donation'))
                ->formatStateUsing(
                    fn($state) => EventDonation::tryFrom($state)?->getTranslatedLabel()
                )
                ->color(fn($state) => EventDonation::tryFrom($state)?->getBadgeColor())
                ->icon(fn($state) => EventDonation::tryFrom($state)?->getIcon())
                ->iconColor('primary')
                ->badge(),

            TextColumn::make('books_donated')
                ->label(__('Books donated'))
                ->visible($this->tab == EventDonation::Books->value)
                ->icon('heroicon-m-arrow-trending-up'),

            TextColumn::make('books_taken')
                ->label(__('Books taken'))
                ->visible($this->tab == EventDonation::Books->value)
                ->icon('heroicon-m-arrow-trending-down'),

            TextColumn::make('waste.category')
                ->label(__('Waste'))
                ->searchable()
                ->visible($this->tab == EventDonation::Waste->value)
                ->extraAttributes(['class' => 'uppercase']),

            TextColumn::make('quantity')
                ->label(__('Quantity'))
                ->sortable()
                ->visible($this->tab == EventDonation::Waste->value)
                ->formatStateUsing(fn(Donation $record) => 
                    "{$record->quantity} {$record->waste->unit}"
                ),

            TextColumn::make('donator_id')
                ->label(__('Donator'))
                ->formatStateUsing(function ($state) {
                    $user = CMUser::find($state);

                    return $user->name ?? $user->user->name;
                })
                ->searchable(
                    query: function ($query, $search) {
                        $query = $query->whereHas('donator', function ($query) use ($search) {
                            $query->where('name', 'like', '%'.$search.'%')
                                ->orWhere(function ($query) use ($search) {
                                    $query->whereHas('user', fn($q) => $q->where('name', 'like', '%' . $search . '%'));
                                });                            
                        });
                        
                        return $query;
                        // dd($query->toSql(), $query->getBindings());
                    }
                ),
            
            TextColumn::make('capturist.user.name')
                ->searchable()
                ->label(__('Capturist')),
            
            TextColumn::make('created_at')
                ->sortable()
                ->label(__('Registered'))
                ->formatStateUsing(fn(Donation $record) => $record->dateTime('created_at'))
            
        ];
        
        $header_actions = [
            $this->getRegisterItemAction($cm_user),            
            $this->getRegisterDonation($cm_user),
            ImportAction::make()
                ->importer(DonationImporter::class),
            ExportAction::make()
                ->exporter(DonationExporter::class)
        ];

        return $table
            // ->poll('5s')
            ->query($this->getQuery())
            ->columns($columns)
            ->headerActions($header_actions)
            ->filters([

            ])
            ->actions([
                EditAction::make()
                    ->label(__('Edit donation'))
                    ->modalHeading(__('Edit donation'))
                    ->disabled(!$cm_user->can(Permission::EditEventDonations->value))
                    ->stickyModalFooter()
                    ->form(
                        $this->getDonationComponent()
                    )
                    ->successNotificationTitle(__('Saved!')),

                DeleteAction::make()
                    ->disabled(!$cm_user->can(Permission::DeleteventDonations->value))
                    ->modalHeading(__('Delete donation'))

            ])

            ;
    }


    private function getRegisterDonation($cm_user = null): CreateAction
    {
        $cm_user = $cm_user ?? auth()->user()->CMUser;

        return CreateAction::make()
        ->label(__('Register donation'))
        ->modalHeading(__('Register donation'))
        ->disabled(!$cm_user->can(Permission::AddEventDonations->value))
        ->createAnother(false)
        ->stickyModalFooter()
        ->modalWidth(MaxWidth::FiveExtraLarge)
        ->closeModalByClickingAway(false)
        ->form($this->getUserDonationsSchema(
            $this->getSelectActive()
                ->disabled(isset($this->event))
                ->default($this->event?->id)
                ->required()
        ))
        ->beforeFormFilled(function ($data) {
            $data['event_id'] = $this->event?->id;

            return $data;
        })
        ->mutateFormDataUsing(function ($data) {
            if($data['is_intern']) {
                $data['donator_id'] = User::find($data['donator_id'])->CMUser->id;
                unset($data['is_intern']);
            }
            //ensure to maintain data consistency
            $data['donations'] = collect($data['donations'])->map(function ($donation) {
                if ($donation['type']) {
                    $donation['books_donated'] = $donation['books_taken'] = null;
                } else {
                    $donation['waste_id'] = $donation['quantity'] = null;
                    //ensure that event when an empty string is passed default to 0
                    if(blank($donation['books_taken'])) {
                        $donation['books_taken'] = 0;
                    }
                }
                return $donation;
            })->toArray();
            
            return $data;
        })
        ->using(function ($data, string $model) {
            $data['cm_user_id'] = auth()->user()->CMUser->id;
            if (!isset($data['event_id'])) {
                $data['event_id'] = $this->event->id;
            }

            $createdModels = [];
            foreach ($data['donations'] as $donation) {
                $donation['cm_user_id'] = $data['cm_user_id'];
                $donation['event_id'] = $data['event_id'];
                $donation['donator_id'] = $data['donator_id'];

                $createdModels[] = $model::create($donation);
            }
        
            return $createdModels[0] ?? null;
        })
        ->successNotificationTitle(__('Saved!'));
    }

    public function render()
    {
        return view('livewire.panel.events.list-actives');
    }
}

// ->hidden($this->event ?? true)
// ->groups([
    //             Group::make('donator_id')
    //                 ->label(__('Donator'))
    //                 ->collapsible()
    //                 ->getTitleFromRecordUsing(fn (CMUser $record) => ucfirst($record?->name ?? $record->user->name))
    // //                 ->getDescriptionFromRecordUsing(fn(Donation $record) => $record->getDonatorDescription())
                    
            // ])
            // ->groupingSettingsInDropdownOnDesktop()
            // ->defaultGroup('donator_id')

// TextColumn::make('donator_id')
                //         // ->hidden(true)
                //         ->extraAttributes(['class' => 'hidden scale-0'])
                //         ->searchable(query: function ($query, $search) {
                //             $q = CMUser::searchDonatorsByTerm($search);

                //             return $q;
                //         })->grow(false)
                //         ,

                // Split::make([
                
                //     TextColumn::make('type')
                //     ->label(__('Type of donation'))
                //     ->badge()
                //     ->formatStateUsing(fn($state) => $state ? __('Waste donation') : __('Book donation')),

                //     TextColumn::make('waste_id')
                //         ->formatStateUsing(fn($state) => 
                //             Waste::find($state)?->category
                //         )
                //         ->hidden(fn(Donation $donation) => !$donation->type),
                
                //     TextColumn::make('quantity')
                //     ->formatStateUsing(function ($state, Donation $donation){
                //         $waste = Waste::find($donation->waste_id);
                        
                //         return "$state {$waste->unit}";
                //     })
                //     ->hidden(fn(Donation $donation) => !$donation->type)
                //     ,

                //     TextColumn::make('books_donated')
                //         ->hidden(fn(Donation $donation) => $donation->type)
                //         ->icon('heroicon-m-arrow-trending-up')
                //         ->tooltip(__('Donate')),

                //     TextColumn::make('books_taken')
                //         ->hidden(fn(Donation $donation) => $donation->type)
                //         ->icon('heroicon-m-arrow-trending-down')
                //         ->tooltip(__('Take')),
                // ])







































    // public function table(Table $table): Table
    // {
    //     $cm_user = auth()->user()->CMUser;
        
    //     return $table
    //         ->query(Donation::query())
    //         // ->relationship(fn () => $this->event->donations())
    //         // ->hidden(!$this->event)
    //         ->groups([
    //             Group::make('donator.user_id')
    //                 ->label(__('Donator'))
    //                 ->collapsible()
    //                 ->getTitleFromRecordUsing(fn (Donation $record) => ucfirst($record->getDonatorName()))
    //                 ->getDescriptionFromRecordUsing(fn(Donation $record) => $record->getDonatorDescription())
    //         ])
    //         ->groupingSettingsInDropdownOnDesktop()
    //         // ->groupingSettingsHidden()
    //         ->defaultGroup('donator.user_id')
    //         ->headerActions([
                
    //         ])
    //         ->columns([
    //             TextColumn::make('donator_id')
    //                     // ->hidden(true)
    //                     ->extraAttributes(['class' => 'hidden scale-0'])
    //                     ->searchable(query: function ($query, $search) {
    //                         $q = CMUser::searchDonatorsByTerm($search);

    //                         return $q;
    //                     })->grow(false)
    //                     ,

    //             Split::make([
                
    //                 TextColumn::make('type')
    //                 ->label(__('Type of donation'))
    //                 ->badge()
    //                 ->formatStateUsing(fn($state) => $state ? __('Waste donation') : __('Book donation')),

    //                 TextColumn::make('waste_id')
    //                     ->formatStateUsing(fn($state) => 
    //                         Waste::find($state)?->category
    //                     )
    //                     ->hidden(fn(Donation $donation) => !$donation->type),
                
    //                 TextColumn::make('quantity')
    //                 ->formatStateUsing(function ($state, Donation $donation){
    //                     $waste = Waste::find($donation->waste_id);
                        
    //                     return "$state {$waste->unit}";
    //                 })
    //                 ->hidden(fn(Donation $donation) => !$donation->type)
    //                 ,

    //                 TextColumn::make('books_donated')
    //                     ->hidden(fn(Donation $donation) => $donation->type)
    //                     ->icon('heroicon-m-arrow-trending-up')
    //                     ->tooltip(__('Donate')),

    //                 TextColumn::make('books_taken')
    //                     ->hidden(fn(Donation $donation) => $donation->type)
    //                     ->icon('heroicon-m-arrow-trending-down')
    //                     ->tooltip(__('Take')),
    //             ])
    //         ])
    //         ->actions([
                
    //         ])
    //         ->bulkActions([
    //             // ...
    //         ]);
    // }