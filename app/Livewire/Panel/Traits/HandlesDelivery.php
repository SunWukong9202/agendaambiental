<?php 

namespace App\Livewire\Panel\Traits;

use App\Forms\Components\Alert;
use App\Models\Event;
use App\Models\Pivots\Delivery;
use App\Models\Pivots\Donation;
use App\Models\Supplier;
use App\Models\Waste;
use Carbon\Carbon;
use Closure;
use Filament\Forms\Components\Component;
use Filament\Forms\Form;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\View;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Support\RawJs;
use Illuminate\Support\Facades\Storage;

trait HandlesDelivery {
    public ?Delivery $delivery;

    public ?array $deliveryData = [];

    public function deliveryForm(Form $form): Form
    {
        return $form
            ->schema($this->getDeliverySchema())
            ->statePath('deliveryData')
            ;
    }

    private function deliveryNotification($action, $record): Notification
    {
        $_action = __(match($action) {
            'registered' => 'assigned',
            'deleted' => 'unassigned',
            'updated' => 'assigned',
            default => $action
        });

        $action = __($action);

        $quantity = $record->quantity;
        $_waste = Waste::find($record->waste_id);
        $unit = $_waste->unit;
        $waste = $_waste->category;

        return Notification::make()
            ->success() 
            ->title(__('ui.notifications.deliveries.title', compact('action')))
            ->body(__('ui.notifications.deliveries.body', compact('_action', 'quantity', 'unit', 'waste')));
    }

    //quantity, waste_id,cm_user_id,supplier_id,event_id
    public function getDeliverySchema(Delivery $record = null)
    {
        $this->delivery = $record;

        $inputs = [
            $this->getSelectEvenComponent()
                ->reactive()
                ->afterStateUpdated(fn(Get $get, Set $set) => $this->handleAvailableUpdate($get, $set))
                ->required(),

            $this->getSelectWasteComponent()
                ->reactive()
                ->afterStateUpdated(fn(Get $get, Set $set) => $this->handleAvailableUpdate($get, $set))
                ->required(),

            Alert::make()
                ->info()
                ->title(__("Quantity available insufficient!"))
                ->description(function (Get $get) {

                    $available = $this->calculateAvailable($get);
                    $record = Waste::find($get('waste_id'));
                    $waste = $record?->category; 
                    $unit = $record?->unit ?? 'NP';

                    $text = __('insuficient_for_a_delivery', compact('available', 'unit', 'waste'));
                    
                    return $text;
                })
                ->visible(fn(Get $get) => filled($get('waste_id')) && filled($get('event_id')) && !filled($get('available'))),

            Split::make([
                $this->getAvailableComponent()
                    ->formatStateUsing(function (Get $get) {
                        if($this->delivery) {
                            return $this->calculateAvailable($get);
                        } 
                        return null;
                    })
                    ->suffix(fn (Get $get) => Waste::find($get('waste_id'))?->unit ?? ''),

                $this->getQuantityComponent()
                    ->suffix(fn (Get $get) => Waste::find($get('waste_id'))?->unit ?? '')
                    ->disabled(fn(Get $get) => !filled($get('available')))
                    ->rules([
                        fn (Get $get) => function ($attribute, $value, Closure $fail) use ($get) {
                            $available = $this->calculateAvailable($get);
                            $attribute = __('Quantity');
                            
                            if($value > $available) {
                                $value = $available; 
                                $fail(__('validation.lte.numeric', compact('attribute', 'value')));
                            }
                        }
                    ]),
            ])
            ->from('sm')
            ->visible(fn(Get $get) => filled($get('waste_id')) && filled($get('event_id'))),
        ];

        return [
            ...$inputs,
        ];
    }

    private function handleAvailableUpdate(Get $get, Set $set)
    {
        if(!filled($get('waste_id')) || !filled($get('event_id'))) return;

        $total = $this->calculateAvailable($get);

        $min_per_delivery = 0.100;
        if($total >= $min_per_delivery) {
            $set('available', $total);
        } else {
            $set('available', null);
        }
    }

    private function calculateAvailable(Get $get)
    {
        [$donated, $delivered] = collect([
            Donation::query(),
            Delivery::query()->where('id', '<>', $this->delivery?->id)
        ])->map(function ($q) use ($get) {
            return $q->where('event_id', $get('event_id'))
                ->where('waste_id', $get('waste_id'))
                ->sum('quantity');
        });

        return round($donated - $delivered, 3);
    }

    //  = Delivery::where('event_id', $get('event_id'))
        //     ->where('waste_id', $get('waste_id'))
        //     ->sum('quantity');

    public function getSelectEvenComponent()
    {
        return Select::make('event_id')
            ->label(__('Event'))
            ->options(Event::all()->pluck('name', 'id'))
            ->searchable()
            ;
    }

    public function getSelectWasteComponent()
    {
        return Select::make('waste_id')
            ->label(__('Waste'))
            ->options(Waste::all()->pluck('category', 'id'))
            ->native(false)
            ;
    }

    public function getAvailableComponent()
    {
        return TextInput::make('available')
            ->label(__('Available'))
            ->dehydrated(false)
            ->readOnly();
    }


    public function getQuantityComponent()
    {
        return TextInput::make('quantity')
            ->label(__('Quantity'))
            ->numeric()
            ->mask(RawJs::make("\$money(\$input, '.', ' ', 3)"))
            ->stripCharacters(' ')
            ->maxValue(9999.999)
            ->minValue(1.000)
            ->required();
    }
    
    public function getUploadSignature()
    {
        return FileUpload::make('signature_url')
            ->label(__('Signature'))
            ->image()
            ->disk('public')
            ->imagePreviewHeight('120')
            ->loadingIndicatorPosition('left')
            ->panelAspectRatio('2:1')
            ->panelLayout('integrated')
            ->removeUploadedFileButtonPosition('right')
            ->uploadButtonPosition('left')
            ->uploadProgressIndicatorPosition('left')
            ;
    }

}