<?php

namespace App\Livewire\Client;

use App\Enums\Movement;
use App\Enums\Status;
use App\Livewire\Panel\Traits\HandlesItem;
use App\Models\Pivots\ItemMovement;
use App\Models\Pivots\ReagentMovement;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\Tabs\Tab;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;
use JaOcero\ActivityTimeline\Components\ActivityDate;
use JaOcero\ActivityTimeline\Components\ActivityDescription;
use JaOcero\ActivityTimeline\Components\ActivityIcon;
use JaOcero\ActivityTimeline\Components\ActivitySection;
use JaOcero\ActivityTimeline\Components\ActivityTitle;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.client')]
class Home extends Component implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;
    use HandlesItem;
    use HandlesReagentMovement;

    public $action;
    public $data = [];
    public $info = [];
    public $petition = [];
    public $donation = [];
    public $activeTab = 'tab1';

    public function mount()
    {
        $this->form->fill();
        $this->petitionForm->fill();
        $this->donationForm->fill();
    }

    public function getForms(): array
    {
        return [
            'form',
            'petitionForm',
            'donationForm'
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->getItemPetitionSchema())
            ->statePath('data')
        ;
    }

    public function petitionForm(Form $form): Form
    {
        return $form
            ->schema($this->getRagentPetition())
            ->statePath('petition');
    }

    public function donationForm(Form $form): Form
    {
        return $form
            ->schema($this->getReagentDonation())
            ->statePath('donation');
    }

    public function lastMovements(Infolist $infolist): Infolist
    {
        return $infolist
            ->state([
                // ...$this->getState()
                'title' => 'title'
            ])
            ->schema([
                Tabs::make()
                ->extraAttributes(['style' => 'flex-shrink: 0;'])
                ->schema([
                    Tab::make('Regaent petitions')
                    ->schema([
                        TextEntry::make('title')
                    ]),

                    Tab::make('Regaent donations')
                    ->schema([
                        TextEntry::make('title')
                    ]),

                    Tab::make('Reagent petitions')
                    ->schema([
                        TextEntry::make('title')
                    ])
                    ->grow()
                ])
                // ->contained(false)
            ]);
    }

    public function reagentDonation(): void
    {
        // dd($this->donationForm->getState());
        $data = $this->donationForm->getState();
        //type,status, cm_user_id, reagent_id
        $data['cm_user_id'] = auth()->user()->CMUser->id;
        $data['type'] = Movement::Donation;
        $data['status'] = Status::In_Progress;

        ReagentMovement::create($data);

        $this->donationForm->fill();

        $this->sendNotification();
    }

    public function reagentPetition()
    {
        // dd($this->petitionForm->getState());
        $data = $this->petitionForm->getState();
        $data['type'] = isset($data['reagent_id']) 
            ? Movement::Petition : Movement::Petition_By_Name;
        
        if(!isset($data['quantity'])) {
            return $this->onValidationError(ValidationException::withMessages([
                __('Please enter a valid quantity.')
            ]));
        }
        $data['cm_user_id'] = auth()->user()->CMUser->id;

        ReagentMovement::create($data);

        $this->petitionForm->fill();

        $this->sendNotification();
    }

    public function itemPetition()
    {
        $data = $this->form->getState();
        $data['cm_user_id'] = auth()->user()->CMUser->id;
        $data['status'] = Status::In_Progress;

        if(isset($data['item_id'])) {
            $data['type'] = Movement::Petition;
        } else if (isset($data['item_name'])) {
            $data['type'] = Movement::Petition_By_Name;
        } else {
            return $this->onValidationError(ValidationException::withMessages([
                __('Try again later')
            ]));
        }

        ItemMovement::create($data);

        $this->form->fill();

        $this->sendNotification();
    }

    private function sendNotification(): Notification
    {
        return Notification::make()
        ->success()
        ->title(__('Sended!'))
        ->send();
    }

    protected function onValidationError(ValidationException $exception): void
    {
        Notification::make()
            ->title($exception->getMessage())
            ->danger()
            ->send();
    }

    private function getState(): array
    {
        $logs = ItemMovement::where('cm_user_id', auth()->user()->CMUser->id)
            ->where('')
            ->get()
            ->map( function ($move) {
                $data = $move->toArray();
                $status = lcfirst($move->status->getLabel());
                $data['type'] = "{$move->type->getLabel()} - {$status}";
                
                $data['created_at'] = $move->dateTime('created_at');
        
                return $data;
            });

        return [
            'ac' => $logs->toArray()
        ];
    }

    public function infoList(Infolist $infolist): Infolist
    {
        $schema = [
            ActivityTitle::make('type'),
        
            ActivityDescription::make('observations'),
            ActivityDate::make('created_at')
                ->date(timezone: 'America/Mexico_City')
                ,
            
            ActivityIcon::make('status')
                ->icon(fn (string | null $state) => Status::tryFrom($state)?->getIcon())
                ->color(fn ($state) => Status::tryFrom($state)?->getBagdeColor())
        ];

        return $infolist
            ->state([
                ...$this->getState()
            ])
            ->schema([
                ActivitySection::make('activities')
                ->label(__('My last activities'))
                ->description('Here you can see a detail of your last activities.')
                ->schema([
                    ...$schema
                ])
                ->showItemsCount(3) 
                ->showItemsLabel('See More') // Show "View Old" as link label
                ->showItemsIcon('heroicon-m-chevron-down') // Show button icon
                ->showItemsColor('gray') // Show button color and it supports all colors
                // ->aside(true)
                ->emptyStateHeading('No activities yet.')
                ->emptyStateDescription('Check back later for activities that have been recorded.')
                ->emptyStateIcon('heroicon-o-archive-box')
                ->headingVisible(true) 
            ]);
    }

    public function render()
    {
        return view('livewire.client.home');
    }
}
