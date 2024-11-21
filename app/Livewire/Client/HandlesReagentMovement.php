<?php

namespace App\Livewire\Client;

use App\Enums\{ChemicalContainer, ChemicalState, Condition, CRETIB, Movement, Status, Units};
use App\Forms\Components\Alert;
use App\Models\Pivots\ReagentMovement;
use App\Models\Reagent;
use Carbon\Carbon;
use Filament\Forms\Components\{FileUpload, Section, Select, Split, Textarea, TextInput, CheckboxList, DatePicker, Wizard, Wizard\Step};
use Filament\Forms\{Get, Set};
use Filament\Support\Enums\Alignment;
use Filament\Support\RawJs;
use Illuminate\Support\HtmlString;

trait HandlesReagentMovement {

    private $min_per_petition = 1.000;

    public function getReagentDonation()
    {
        $description = [
            Split::make([
                $this->getPhoto(),
                Section::make([
                    $this->getExpiration()
                        ->helperText(__("To ensure the safety and effectiveness of the reagents in use, we only accept reagents with an expiration date not less than " . Carbon::now('America/Mexico_City')->addDays(7)->format('M d, Y') .".")),
                    $this->getSelectContainer()
                        ->required(),
                    $this->getSelectCondition(Condition::donationOptions())->required(),
                    $this->getWeight()
                        ->required()
                ])
            ])->from('lg')
        ];

        $hazard_classification = [
            $this->getSelectUnitPerState(),
            $this->getCRETIB()->columns(2),
            $this->getQuantity()
                ->suffix(fn(Get $get) => 
                    Units::tryFrom($get('unit'))?->getTranslatedLabel()
            )->grow(),
        ];

        $additional_info = [
            Split::make([
                $this->getProcedence('proc_lab')
                    ->required(),
                $this->getProcedence('proc_fac')
                    ->required(),
            ])->from('md'),

            $this->getComment()->grow(),
        ];

        return [
            $this->getSelectReagent()
                ->reactive(),

            Alert::make()
                ->visible(fn(Get $get) => !$get('reagent_id'))
                ->warning()
                ->title(__('Select a valid reagent'))
                ->description(__('Please select a valid reagent or check later, to see if we already have added the reagent you want to donate for.')),

            Wizard::make([
                Step::make(__('Reagent description'))
                    ->schema($description),
                Step::make(__('Hazard classification'))
                    ->schema($hazard_classification),
                Step::make(__('Additional information'))
                    ->schema($additional_info),
            ])
            ->visible(fn (Get $get) => $get('reagent_id'))
            ->submitAction(new HtmlString('<button type="submit">'.__('Submit').'</button>'))
        ];
    }

    //!fillable|petition: type,status, cm_user_id, reagent_id
    //petition_by_name: reagent_name,
    //donation:
    //description: photo_url, container, condition, weight
    //cretib, chemical_state, quantity, unit
    //proc_lab, proc_fac, comment,

    private function getPhoto()
    {
        return FileUpload::make('photo_url')
            ->label(__('Image'))
            ->image()
            ->imagePreviewHeight('250')
            ->loadingIndicatorPosition('left')
            ->panelAspectRatio('2:1')
            ->panelLayout('integrated')
            ->removeUploadedFileButtonPosition('right')
            ->uploadButtonPosition('left')
            ->uploadProgressIndicatorPosition('left')
            ->visibility('public')
            ; // Ensure validation is triggered immediately
    }

    public function getExpiration()
    {
        return DatePicker::make('expiration')
            ->translateLabel()
            ->timezone('America/Mexico_City')
            ->minDate(
                now('America/Mexico_City')
                    ->addDays(7)
                    ->format('Y-m-d')
            )
            ->native(false)
            ->required()
            ->reactive()
            ;
    }

    private function getSelectContainer()
    {
        return Select::make('container')
            ->translateLabel()
            ->options(ChemicalContainer::getOptions())
            ;
    }
    
    private function getSelectCondition($options)
    {
        return Select::make('condition')
            ->translateLabel()
            ->options(Condition::buildSelect($options));
    }

    private function getWeight()
    {
        return TextInput::make('weight')
            ->translateLabel()
            ->suffix('Kg')
            ->numeric()
            ->mask(RawJs::make("\$money(\$input, '.', ' ', 3)"))
            ->stripCharacters(' ')
            ->maxValue(999.999)
            ->minValue(.050);
    }

    private function getCRETIB()
    {
        return CheckboxList::make('cretib')
            ->options(CRETIB::getOptions())
            ->descriptions(CRETIB::descriptions());
    }

    private function getProcedence($statePath)
    {
        return TextInput::make($statePath)
            ->translateLabel()
            ->maxLength(80)
            ->hint(__('form.hints.Max characters', ['max' => 80]))
            ;
    }

    public function getRagentPetition()
    {
        return [
            Split::make([
                Section::make([
                    $this->getSelectUnitPerState(),

                    Split::make([    
                        $this->getSelectReagent()
                            ->reactive()
                            ->required(fn(Get $get) => !filled($get('reagent_name')))
                            ,
                        
                        $this->getReagentName()
                            ->required(fn(Get $get) => !filled($get('reagent_id')))
                            ->visible(fn(Get $get) => !filled($get('reagent_id')))
                            ->reactive()
                            ->validationMessages([
                                'unique' => __('The :attribute already exists. Please search above.'),
                            ]),

                        Alert::make()
                            ->info()
                            ->title(__('Stock insufficient!'))
                            ->description(__('We are sorry, but we didnt count with the minimum quantity to register a petition. Try selecting other combination of chemical state, unit and reagent'))
                            ->visible(fn(Get $get) => $this->allFiltersSelected($get)),

                        $this->getQuantity()
                            ->visible(fn(Get $get) => $get('reagent_id') || filled($get('reagent_name')))
                            ->disabled(fn(Get $get) => 
                                !($this->calcultateAvailablePerUnit($get) >= $this->min_per_petition
                                && filled($get('reagent_id')) || !$get('reagent_id'))
                            )
                            ->suffix(fn(Get $get) => 
                                Units::tryFrom($get('unit'))?->getTranslatedLabel()
                            )->grow(),
                    ])
                    ->from('2xl')
                    ->visible(fn(Get $get) => 
                        filled($get('chemical_state')) && filled($get('unit'))
                    ),
                ]),
                
                Section::make([
                    $this->getComment(),
                ])

            ])->from('lg')
        ];
    }

    public function getSelectReagent()
    {
        return Select::make('reagent_id')
            ->label(__('Reagent'))
            ->placeholder(__('I can\'t find the reagent I\'m looking for.'))
            ->native(false)
            ->searchable()
            ->options(Reagent::all()->pluck('name', 'id'))
            ;       
    }

    private function filtersNotSelected(Get $get): bool
    {
        return !filled($get('chemical_state')) || 
            !filled($get('unit')) || !filled($get('reagent_id'));
    }

    private function allFiltersSelected(Get $get): bool
    {
        return !$this->filtersNotSelected($get);
    }

    private function calcultateAvailablePerUnit(Get $get)
    {
        if($this->filtersNotSelected($get)) return 0;

        [$donated, $requested] = collect([
            ReagentMovement::where('type', Movement::Donation)
                ->where('expiration', '<', now()),
            ReagentMovement::where('type', Movement::Petition)
                ->where('status', Status::Accepted)
        ])->map(fn($query) => $query
            ->where('chemical_state', $get('chemical_state'))
            ->where('unit', $get('unit'))
            ->sum('quantity')
        );

        return round($donated - $requested, 3);
    }

    public function getReagentName()
    {
        return TextInput::make('reagent_name')
            ->label(__('Reagent name'))
            ->maxLength(80)
            ->hint(__('form.hints.Max characters', ['max' => 80]))
            ->unique('reagents', 'name');
    }

    public function getQuantity()
    {
        return TextInput::make('quantity')
            ->label(__('Quantity'))
            ->numeric()
            ->mask(RawJs::make("\$money(\$input, '.', ' ', 3)"))
            ->stripCharacters(' ')
            ->maxValue(999999.999)
            ->minValue(1.000)
            ->required();
    }

    public function getComment()
    {
        return Textarea::make('comment')
            ->label(__('Comment'))
            ->hint(__('form.hints.Max characters', ['max' => 255]))
            ->maxLength(255);
    }

    public function getSelectUnitPerState()
    {
        return Split::make([
            Select::make('chemical_state')
                ->label(__('Chemical state'))
                ->options(ChemicalState::getOptions())
                ->required()
                ->reactive(),

            Select::make('unit')
                ->label(__('Unit'))
                ->options(fn(Get $get) => Units::buildOptions($get('chemical_state')))
                ->disabled(fn(Get $get) => !filled($get('chemical_state')))
                ->required()
                ->reactive()
                
        ])->from('sm');
    }
}