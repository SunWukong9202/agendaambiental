<?php 

namespace App\Livewire\Panel\Traits;

use App\Enums\Permission;
use App\Models\CMUser;
use App\Models\Event;
use App\Models\Pivots\Donation;
use App\Models\User;
use App\Models\Waste;
use Carbon\Carbon;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Support\RawJs;

trait HandlesUserDonations {
    use HandlesModelUser;
    use HandlesWasteModel;

    public ?CMUser $donator;
    public ?array $donations = [];
    private array $searchables = ['name', 'email'];

    // public function donationsForm(Form $form): Form
    // {
    //     return $form
    //         ->schema($this->getUserDonationsSchema())
    //         ->statePath('donations')
    //         ->model($this->donator)
    //         ;
    // }

    public function saveDonations(): void
    {
        // dump("in save donation");
        $data = $this->donationsForm->getState();
        dd($data);
        // dd("afer in save");
    }

    private function donationNotification($action, $type): Notification
    {
        return Notification::make()
            ->success()
            ->title(__('ui.notifications.donations.title', compact('action')))
            ->body(__('ui.notifications.donations.body', compact('action', 'type')));
    }

    public function getUserDonationsSchema($selectEvent = null)
    {        
        return [
            // Section::make(__('Donator'))
            //     ->description(__('Please select the type of donator for what you want to register the donation for.'))
            //     ->schema([
                    $selectEvent?->required(),

                    ...$this->getSelectDonatorComponent(),
                // ]),
            
                    
            Repeater::make('donations')
            ->label(__('Donations'))
            ->schema([
                ...$this->getDonationComponent(),
            ])
            ->reorderable(false)
            ->collapsible()
            ->visible(fn (Get $get) => filled($get('donator_id')))
            ->itemLabel(fn($state) => $this->formatItemLabel($state))
            ->minItems(1)
            // ->grid([
            //     'md' => 2,
            // ])
        ];
    }


    public function getSelectDonatorComponent()
    {
        return [
            Fieldset::make(__('Type of user'))
            ->schema([
                Checkbox::make('is_intern')
                    ->label(__('Intern User'))
                    ->default(true)
                    ->reactive()
                    ->afterStateUpdated(function (Set $set, Get $get) {
                        $set('donator_id', null);
                        if ($get('is_intern')) {
                            $set('is_extern', false);
                        } else {
                            $set('is_extern', true);
                        }
                    }),

                Checkbox::make('is_extern')
                    ->label(__('Extern User'))
                    ->dehydrated(false)
                    ->reactive()
                    ->afterStateUpdated(function (Set $set, Get $get) {
                        $set('donator_id', null);
                        if ($get('is_extern')) {
                            $set('is_intern', false);
                        } else {
                            $set('is_intern', true);
                        }
                    }),
            ])->columns([
                'sm' => 2
            ]),

            ...$this->getSearchComponent(),
        ];
    }

    public function getSearchComponent()
    {
        $cm_user = auth()->user()->CMUser;
        return [
            Select::make('donator_id')
            ->label('Donator')
            ->hidden(fn(Get $get) => $get('is_intern'))
            ->required(fn(Get $get) => !$get('is_intern'))
            ->createOptionForm(
                $cm_user->can(Permission::AddUsers->value)
                ? $this->getUserFormSchema()
                : null
            )
            ->createOptionUsing(function ($data) {
                return CMUser::create($data)->id;
            })
            ->loadingMessage(__('Loading users...'))
            ->searchingMessage('Searching users...')
            ->noSearchResultsMessage(__('No users found. You could try with another term or create it.'))
            ->searchPrompt(__('Search users by their name or email'))
            ->reactive()
            ->afterStateUpdated(fn(Set $set, Get $get) => $this->handleDonatorSelection($set, $get))
            ->searchable()
            ->preload()
            ->getSearchResultsUsing(function (string $search, Get $get) {
                $results = CMUser::whereNull('user_id')->search($search, $this->searchables)->limit(15)->get();
                $results = $results->mapWithKeys(fn($el) => [$el['id'] => "{$el['name']} - {$el['email']}"])->toArray();
                // dump($search, $results);
                return $results;
            })
            ->getOptionLabelUsing(function ($value, $get) {
                $user = CMUser::find($value);

                return "{$user->name} - {$user->email}";
            })
            ->helperText(__('If you dont find the user you are looking for you can add it with the button above.')),

            Select::make('donator_id')
            ->label('Donator')
            ->hidden(fn(Get $get) => !$get('is_intern'))
            ->required(fn(Get $get) => $get('is_intern'))
            ->loadingMessage(__('Loading users...'))
            ->searchingMessage('Searching users...')
            ->noSearchResultsMessage(__('No users found. You could try with another term or create it.'))
            ->searchPrompt(__('Search users by their name, email or key'))
            ->reactive()
            ->afterStateUpdated(fn(Set $set, Get $get) => $this->handleDonatorSelection($set, $get))
            ->searchable()
            ->preload()
            ->getSearchResultsUsing(function (string $search, Get $get) {
                $results = User::search($search, [...$this->searchables, 'key'])->limit(15)->get();
                $results = $results->mapWithKeys(fn($el) => [$el['id'] => "{$el['name']} - {$el['email']}"])->toArray();
                // dump($search, $results);
                return $results;
            })
            ->getOptionLabelUsing(function ($value, $get) {
                $user = User::find($value);

                return "{$user->name} - {$user->email}";
            })
            ->helperText(__('If you dont find the user you are looking for you can add it with the button above.'))
        ];
    }

    public function getDonationComponent()
    {
        $select_donation = Fieldset::make(__('Select type donation'))
            ->schema([
                Checkbox::make('type')
                    ->label(__('Waste donation'))
                    ->reactive()
                    ->formatStateUsing(function ($state, Set $set) {
                        $default = $state ?? true;
                        $set('type_book', !$default);
                        
                        return $default;
                    })
                    ->afterStateUpdated(function (Set $set, Get $get) {
                        $set('type_book', !$get('type'));
                    }),
        
                Checkbox::make('type_book')
                    ->label(__('Book donation'))
                    ->reactive()
                    ->formatStateUsing(function ($state, Set $set) {
                        $default = $state ?? false;
                        $set('type', !$default);

                        return $state;
                    })
                    ->afterStateUpdated(function (Set $set, Get $get) {
                        $set('type', !$get('type_book'));
                    })
                    ->dehydrated(false),
                    
            ])->columns([
                'sm' => 2
            ]);
        
        $book_donation = Split::make([
            $this->getBooksComponent('books_donated', 'Books donated')
                ->required()
                ->minValue(1),

            $this->getBooksComponent('books_taken', 'Books taken')
                ->default(0)
                ->minValue(0),
        ])
        ->from('sm')
        ->hidden(fn (Get $get) => $get('type'));
        
        $waste_donation = Split::make([
            $this->getSelectWasteComponent()
                ->required()
                ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                ,
            $this->getQuantityComponent()
                ->suffix(fn (Get $get) => Waste::find($get('waste_id'))?->unit ?? ''), 
        ])
        ->from('sm')
        ->visible(fn (Get $get) => $get('type'));

        return [
            $select_donation,
            $book_donation,
            $waste_donation
        ];
    }

    private function handleDonatorSelection(Set $set, Get $get) {
        if(!filled($get('donator_id'))) {
            return $set('donations', []);
        }
    }

    public function getSelectWasteComponent()
    {
        $cm_user = auth()->user()->CMUser;
        return Select::make('waste_id')
            ->label(__('Waste'))
            ->searchable()
            ->options(Waste::all()->pluck('category', 'id'))
            ->createOptionForm(
                $cm_user->can(Permission::AddWastes->value)
                ? $this->getWasteFormSchema()
                : null
            )
            ->createOptionUsing(function ($data) {
                return Waste::create($data)->id;
            })
            ->native(false)
            ;
    }

    public function getBooksComponent($state, $label)
    {
        return TextInput::make($state)
            ->label(__($label))
            ->numeric()
            ->maxValue(255);
    }

    public function getQuantityComponent()
    {
        return TextInput::make('quantity')
            ->label(__('Quantity'))
            ->mask(RawJs::make("\$money(\$input, '.', ' ', 3)"))
            ->stripCharacters(' ')
            ->maxValue(999.999)
            ->minValue(0.100)
            ->reactive()
            ->required();
    }

    private function formatItemLabel($state) {
        $donation = $state['type'] ? __('Waste donation') : __('Book donation');

        $waste = Waste::find($state['waste_id']);

        $wasteDonation = blank($state['quantity']) || blank($state['waste_id']) 
        ? __('Pending to fullfill') 
        : $waste?->category ." ". $state['quantity'] ." ". $waste?->unit;

        $bookDonation = blank($state['books_donated']) || blank($state['books_donated']) 
        ? __('Pending to fullfill')
        : __('Donate').": {$state['books_donated']} "
        .__('Take').": {$state['books_taken']}";
        
        $content = $state['type']
            ? $wasteDonation
            : $bookDonation;

        return "$donation: $content";
    }
}


        
            // Select::make('donator_id')
            // ->label('Donator')
            // ->loadingMessage(__('Loading users...'))
            // ->searchingMessage('Searching users...')
            // ->noSearchResultsMessage(__('No users found. You could try with another term or create it.'))
            // ->searchPrompt(fn (Get $get) => !$get('is_intern') 
            //     ? __('Search users by their name or email') 
            //     : __('Search users by their name, email or key'))
            // ->live()
            // ->afterStateUpdated(fn(Set $set, Get $get) => !filled($get('donator_id')) ? $set('donations', []) : '')
            // ->searchable()
            // ->preload()
            // ->getSearchResultsUsing(function (string $search, Get $get) {
            //     $results = [];
            //     if(!$get('is_intern')) {
            //         $results = CMUser::whereNull('user_id')->search($search, $this->searchables)->limit(15)->get();
            //     } else {
            //         $results = User::search($search, [...$this->searchables, 'key'])->limit(15)->get();
            //     }
            //     $results = $results->mapWithKeys(fn($el) => [$el['id'] => "{$el['name']} - {$el['email']}"])->toArray();
            //     // dump($search, $results);
            //     return $results;
            // })
            // ->getOptionLabelUsing(function ($value, $get) {
            //     $user = $get('is_intern') ? User::find($value) : CMUser::find($value);

            //     return "{$user->name} - {$user->email}";
            // })
            // ->helperText(__('If you dont find the user you are looking for you can add it with the button above.'))

// trait HandlesUserDonations {

//     public ?CMUser $donator;
//     public ?array $donations = [];
//     private array $searchables = ['name', 'email'];

//     public function donationsForm(Form $form): Form
//     {
//         return $form
//             ->schema($this->getUserDonationsSchema())
//             ->statePath('donations')
//             ->model($this->donator)
//             ->reactive()
//             ;
//     }

//     public function saveDonations(): void
//     {
//         // dump("in save donation")
//         $data = $this->donationsForm->getState();
//         // dump($data);
//         // dd("afer in save");
//     }

//     private function donationNotification($action, $type): Notification
//     {
//         return Notification::make()
//             ->success()
//             ->title(__('ui.notifications.donations.title', compact('action')))
//             ->body(__('ui.notifications.donations.body', compact('action', 'type')));
//     }

//     public function getUserDonationsSchema()
//     {        
//         return [
//             Section::make(__('Donator'))
//                 ->description(__('Please select the type of donator for what you want to register the donation for.'))
//                 ->schema([
//                     ...$this->getSelectDonatorComponent(),
//                 ]),
            
                    
//             Repeater::make('donations')
//             ->relationship()
//             ->label(__('Donations'))
//             ->schema([
//                 ...$this->getDonationComponent(),
//             ])
//             ->reorderable(false)
//             ->collapsible()
//             ->reactive()
//             ->visible(fn (Get $get) => filled($get('donator_id')))
//             ->itemLabel(fn($state) => $this->formatItemLabel($state))
//             ->mutateRelationshipDataBeforeFillUsing(function (array $data): array {
//                 // dump("before fill");
//                 dump($data);
         
//                 return $data;
//             })
//             ->mutateRelationshipDataBeforeCreateUsing(function ($data, Get $get) {
//                 // dump("before create");
//                 // dump($data);

//                 $data['cm_user_id'] = auth()->user()->CMUser->id;
//                 $data['event_id'] = $this->event->id;

//                 $donation = $get('type') ? __('Waste donation') : __('Book donation');

//                 $this->donationNotification(__('Added'), $donation)->send();
//                 return $data;
//             })
//             ->mutateRelationshipDataBeforeSaveUsing(function (array $data): array {
//                 dump("before - save");
//                 dump($data);
         
//                 return $data;
//             })
//         ];
//     }

//     public function getSelectDonatorComponent()
//     {
//         return [
//             Fieldset::make(__('Type of user'))
//             ->schema([
//                 Checkbox::make('is_intern')
//                     ->label(__('Intern User'))
//                     ->default(true)
//                     ->reactive()
//                     ->afterStateUpdated(function (Set $set, Get $get) {
//                         $set('donator_id', null);
//                         if ($get('is_intern')) {
//                             $set('is_extern', false);
//                         } else {
//                             $set('is_extern', true);
//                         }
//                     }),

//                 Checkbox::make('is_extern')
//                     ->label(__('Extern User'))
//                     ->dehydrated(false)
//                     ->reactive()
//                     ->afterStateUpdated(function (Set $set, Get $get) {
//                         $set('donator_id', null);
//                         if ($get('is_extern')) {
//                             $set('is_intern', false);
//                         } else {
//                             $set('is_intern', true);
//                         }
//                     }),
//             ])->columns([
//                 'sm' => 2
//             ]),

//             ...$this->getSearchComponent(),
        
//             // Select::make('donator_id')
//             // ->label('Donator')
//             // ->loadingMessage(__('Loading users...'))
//             // ->searchingMessage('Searching users...')
//             // ->noSearchResultsMessage(__('No users found. You could try with another term or create it.'))
//             // ->searchPrompt(fn (Get $get) => !$get('is_intern') 
//             //     ? __('Search users by their name or email') 
//             //     : __('Search users by their name, email or key'))
//             // ->live()
//             // ->afterStateUpdated(fn(Set $set, Get $get) => !filled($get('donator_id')) ? $set('donations', []) : '')
//             // ->searchable()
//             // ->preload()
//             // ->getSearchResultsUsing(function (string $search, Get $get) {
//             //     $results = [];
//             //     if(!$get('is_intern')) {
//             //         $results = CMUser::whereNull('user_id')->search($search, $this->searchables)->limit(15)->get();
//             //     } else {
//             //         $results = User::search($search, [...$this->searchables, 'key'])->limit(15)->get();
//             //     }
//             //     $results = $results->mapWithKeys(fn($el) => [$el['id'] => "{$el['name']} - {$el['email']}"])->toArray();
//             //     // dump($search, $results);
//             //     return $results;
//             // })
//             // ->getOptionLabelUsing(function ($value, $get) {
//             //     $user = $get('is_intern') ? User::find($value) : CMUser::find($value);

//             //     return "{$user->name} - {$user->email}";
//             // })
//             // ->helperText(__('If you dont find the user you are looking for you can add it with the button above.'))
//         ];
//     }

//     public function getSearchComponent()
//     {

//         return [
//             Select::make('donator_id')
//             ->label('Donator')
//             ->hidden(fn(Get $get) => $get('is_intern'))
//             ->loadingMessage(__('Loading users...'))
//             ->searchingMessage('Searching users...')
//             ->noSearchResultsMessage(__('No users found. You could try with another term or create it.'))
//             ->searchPrompt(__('Search users by their name or email'))
//             ->reactive()
//             ->afterStateUpdated(fn(Set $set, Get $get) => $this->handleDonatorSelection($set, $get))
//             ->searchable()
//             ->getSearchResultsUsing(function (string $search, Get $get) {
//                 $results = CMUser::whereNull('user_id')->search($search, $this->searchables)->limit(15)->get();
//                 $results = $results->mapWithKeys(fn($el) => [$el['id'] => "{$el['name']} - {$el['email']}"])->toArray();
//                 // dump($search, $results);
//                 return $results;
//             })
//             ->getOptionLabelUsing(function ($value, $get) {
//                 $user = CMUser::find($value);

//                 return "{$user->name} - {$user->email}";
//             })
//             ->helperText(__('If you dont find the user you are looking for you can add it with the button above.')),

//             Select::make('donator_id')
//             ->label('Donator')
//             ->hidden(fn(Get $get) => !$get('is_intern'))
//             ->loadingMessage(__('Loading users...'))
//             ->searchingMessage('Searching users...')
//             ->noSearchResultsMessage(__('No users found. You could try with another term or create it.'))
//             ->searchPrompt(__('Search users by their name, email or key'))
//             ->reactive()
//             ->afterStateUpdated(fn(Set $set, Get $get) => $this->handleDonatorSelection($set, $get))
//             ->searchable()
//             ->getSearchResultsUsing(function (string $search, Get $get) {
//                 $results = User::search($search, [...$this->searchables, 'key'])->limit(15)->get();
//                 $results = $results->mapWithKeys(fn($el) => [$el['id'] => "{$el['name']} - {$el['email']}"])->toArray();
//                 // dump($search, $results);
//                 return $results;
//             })
//             ->getOptionLabelUsing(function ($value, $get) {
//                 $user = User::find($value);

//                 return "{$user->name} - {$user->email}";
//             })
//             ->helperText(__('If you dont find the user you are looking for you can add it with the button above.'))
//         ];
//     }

//     public function getDonationComponent()
//     {
//         $select_donation = Fieldset::make(__('Select type donation'))
//             ->schema([
//                 Checkbox::make('type')
//                     ->label(__('Waste donation'))
//                     ->default(true)
//                     ->reactive()
//                     ->afterStateUpdated(function (Set $set, Get $get) {
//                         if ($get('type')) {
//                             $set('type_book', false);
//                         } else {
//                             $set('type_book', true);
//                         }
//                     }),

//                 Checkbox::make('type_book')
//                     ->label(__('Book donation'))
//                     ->dehydrated(false)
//                     ->reactive()
//                     ->distinct()
//                     ->afterStateUpdated(function (Set $set, Get $get) {
//                         if ($get('type_book')) {
//                             $set('type', false);
//                         } else {
//                             $set('type', true);
//                         }
//                     })
//                     ,
//             ])->columns([
//                 'sm' => 2
//             ]);
        
//         $book_donation = Split::make([
//             $this->getBooksComponent('books_donated', 'Books donated')
//                 ->required()
//                 ->minValue(1),

//             $this->getBooksComponent('books_taken', 'Books taken')
//                 ->minValue(0),
//         ])
//         ->from('sm')
//         ->hidden(fn (Get $get) => $get('type'));
        
//         $waste_donation = Split::make([
//             $this->getSelectWasteComponent()
//                 ->required()
//                 ->disableOptionsWhenSelectedInSiblingRepeaterItems()
//                 ,
//             $this->getQuantityComponent()
//                 ->suffix(fn (Get $get) => Waste::find($get('waste_id'))?->unit ?? ''), 
//         ])
//         ->from('sm')
//         ->visible(fn (Get $get) => $get('type'));

//         return [
//             $select_donation,
//             $book_donation,
//             $waste_donation
//         ];
//     }

//     private function handleDonatorSelection(Set $set, Get $get) {

//         if(!filled($get('donator_id'))) {
//             return $set('donations', []);
//         }
        
//         $id = $get('donator_id');

//         if($get('is_intern')) {
//             $user = User::find($id);
            
//             if(!$user) return null;
            
//             $cm_user = !isset($user->CMUser)
//                 ? $user->CMUser()->create([
//                     'user_id' => $user->id
//                 ]) 
//                 : $user->CMUser;

//             $id = $cm_user->id;
//         }

//         $this->donator = CMUser::find($id);
//         // $this->donations = $this->donator->donations?->toArray() ?? [];
//     }

//     public function getSelectWasteComponent()
//     {
//         return Select::make('waste_id')
//             ->label(__('Waste'))
//             ->options(Waste::all()->pluck('category', 'id'))
//             ->native(false)
//             ;
//     }

//     public function getBooksComponent($state, $label)
//     {
//         return TextInput::make($state)
//             ->label(__($label))
//             ->numeric()
//             ->maxValue(255);
//     }

//     public function getQuantityComponent()
//     {
//         return TextInput::make('quantity')
//             ->label(__('Quantity'))
//             ->mask(RawJs::make("\$money(\$input, '.', ' ', 3)"))
//             ->maxValue(999.999)
//             ->minValue(0.100)
//             ->reactive()
//             ->required();
//     }

//     private function formatItemLabel($state) {
//         $donation = $state['type'] ? __('Waste donation') : __('Book donation');

//         $waste = Waste::find($state['waste_id']);

//         $wasteDonation = blank($state['quantity']) || blank($state['waste_id']) 
//         ? __('Pending to fullfill') 
//         : $waste?->category ." ". $state['quantity'] ." ". $waste?->unit;
        
//         $content = $state['type']
//             ? $wasteDonation
//             : __('Donate').": {$state['books_donated']} "
//               .__('Take').": {$state['books_taken']}";

//         return "$donation: $content";
//     }
// }