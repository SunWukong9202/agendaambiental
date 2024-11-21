<?php 

namespace App\Livewire\Panel\Traits;

use App\Models\Supplier;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Support\RawJs;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;

trait HandlesSupplier {
    public Supplier $supplier;

    // public function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             Wizard::make(
    //                 $this->getFormSchema()
    //             )
    //         ])
    //         ->statePath('data')
    //         ->model($this->supploer);
    // }

    public function getSupplierFormSchema($ignorable = null): array
    {   
        $basic = [
            $this->getNameComponent(),
            $this->getTaxIdComponent()
                ->regex('/^([A-Z]{4}[0-9]{2}(0[1-9]|1[0-2])([0-2][0-9]|3[01])[A-Z0-9]{3}|[A-Z]{3}[0-9]{2}(0[1-9]|1[0-2])([0-2][0-9]|3[01])[A-Z0-9]{2})$/i') 
                ->mask(RawJs::make(<<<'JS'
                    /^[A-Za-z]{4}/.test($input) ? 'aaaa 99 99 99 ***' : 'aaa 99 99 99 **'
                JS))
                ->stripCharacters(' ')
                ->extraAttributes([
                    'x-on:input' => '$event.target.value = $event.target.value.toUpperCase()',
                ])
                ->helperText(__('ui.helpers.rfc')),
                // ->rules([
                //     fn() => function ($attr, $val, $fail) {
                //         // dd($attr, $val, $fail);

                //         $physical = '/^[A-Z]{4}[0-9]{2}(0[1-9]|1[0-2])([0-2][0-9]|3[01])[A-Z0-9]{3}$/i';

                //         $moral = '/^[A-Z]{3}[0-9]{2}(0[1-9]|1[0-2])([0-2][0-9]|3[01])[A-Z0-9]{2})$/i';

                //         $getDateParts = fn($offset) => collect([$offset, $offset + 2, $offset + 4])->map(fn($i) => substr($val, $i, 2));

                //         if (preg_match($physical, $val)) {
                //             [$y, $m, $d] = $getDateParts(4); 

                //             if(!checkdate($m, $d, $y)) {
                //                 $fail('incorrect date format on :attribute');
                //             }
                //             return;
                //         }

                //         if (preg_match($moral, $val)) {
                //             [$y, $m, $d] = $getDateParts(3);   
                //             if(!checkdate($m, $d, $y)) {
                //                 $fail('incorrect date format on :attribute');
                //             }
                //             return;
                //         }

                //         $fail(__('validation.regex', ['attribute' => $attr]));
                //     }
                // ]),
        
            $this->getBuissnessNameComponent()->required(),
            $this->getBuissnessActivityComponent()->required(),
        ];

        $contact = [
            $this->getPhoneNumberComponent(),
            $this->getEmailComponent()
                ->unique(ignorable: $ignorable ?? $this->supplier ?? null)
        ];

        $address = [
            $this->getPostalCodeComponent(),
            $this->getStreetComponent(),
            $this->getExtNumberComponent(),
            $this->getIntNumberComponent(),
            $this->getNeighborhoodComponent(),
            $this->getTownComponent(),
            $this->getEstateComponent()->columnSpanFull(),
        ];

        return [

            // Step::make(__('form.address information'))
            //     ->schema($address)
            //     ->columns(2),
            Step::make(__('form.basic information'))
                ->schema($basic),
            Step::make(__('form.contact information'))
                ->schema($contact),
            Step::make(__('form.address information'))
                ->schema($address)
                ->columns(2),
        ];
    }

    public function getNameComponent(): Component
    {
        return TextInput::make('name')
            ->label(__('form.name'))
            ->hint(__('form.hints.Max characters', ['max' => 80]))
            ->maxLength(80)
            ->required();
    }

    public function getTaxIdComponent(): Component
    {
        return TextInput::make('tax_id')
            ->label(__('form.tax id'))
            ->required();
    }

    public function getBuissnessNameComponent(): Component
    {
        return TextInput::make('business_name')
            ->label(__('form.business name'))
            ->hint(__('form.hints.Max characters', ['max' => 128]))
            ->maxLength(128);
    }

    public function getBuissnessActivityComponent(): Component
    {
        return TextInput::make('business_activity')
            ->label(__('form.business activity'))
            ->hint(__('form.hints.Max characters', ['max' => 80]))
            ->maxLength(80);
    }

    public function getPostalCodeComponent(): Component
    {
        return TextInput::make('postal_code')
            ->label(__('form.postal code'))
            ->numeric()
            ->length(5)
            ->mask('99999')
            ->required();
    }

    public function getStreetComponent(): Component
    {
        return TextInput::make('street')
            ->label(__('form.street'))
            ->maxLength(64)
            ->hint(__('form.hints.Max characters', ['max' => 64]));
    }

    public function getExtNumberComponent(): Component
    {
        return TextInput::make('ext_number')
            ->label(__('form.ext number'))
            ->numeric()
            ->mask('999')
            ->maxValue(999)
            ->minValue(0);
    }

    public function getIntNumberComponent(): Component
    {
        return TextInput::make('int_number')
            ->label(__('form.int number'))
            ->numeric()
            ->mask('999')
            ->maxValue(999)
            ->minValue(0);
    }

    public function getNeighborhoodComponent(): Component
    {
        return TextInput::make('neighborhood')
            ->label(__('form.neighborhood'))
            ->hint(__('form.hints.Max characters', ['max' => 64]))
            ->maxLength(64);
    }


    public function getTownComponent(): Component
    {
        return TextInput::make('town')
            ->label(__('form.town'))
            ->hint(__('form.hints.Max characters', ['max' => 64]))
            ->maxLength(64);
    }

    public function getEstateComponent(): Component
    {
        return TextInput::make('state')
            ->label(__('form.estate'))
            ->hint(__('form.hints.Max characters', ['max' => 64]))
            ->maxLength(64);
    }

    public function getPhoneNumberComponent(): Component
    {
        return TextInput::make('phone_number')
            ->label(__('form.phone number'))
            ->tel();
    }

    public function getEmailComponent(): Component
    {
        return TextInput::make('email')
            ->label(__('form.email'))
            ->hint(__('form.hints.Max characters', ['max' => 80]))
            ->email()
            ->maxLength(80)
            ->required();
    }


    // public function getStreetComponent(): Component
    // {
    //     # code...
    // }public function getStreetComponent(): Component
    // {
    //     # code...
    // }

}