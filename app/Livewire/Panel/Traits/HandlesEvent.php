<?php 

namespace App\Livewire\Panel\Traits;

use Carbon\Carbon;
use Filament\Forms\Components\Component;
use Filament\Forms\Form;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;

trait HandlesEvent {

    public function getEventFormSchema(): array
    {
        $inputs = [
            $this->getNameComponent(),
            $this->getFacultyComponent(),
            $this->getDescriptionComponent(),
            $this->getStartDateComponent(),
            $this->getEndDateComponent(),
            // $this->getStartDateCustom()
        ];

        return [
            ...$inputs
        ];
    }

    public function getNameComponent()
    {
        return TextInput::make('name')
            ->label(__('form.name'))
            ->maxLength(124)
            ->required();
    }

    public function getFacultyComponent()
    {
        return TextInput::make('faculty')
            ->label(__('form.faculty'))
            ->maxLength(80)
            ->required();
    }

    public function getDescriptionComponent()
    {
        return Textarea::make('description')
            ->maxLength(255)
            ;
    }

    public function getStartDateComponent()
    {
        return DateTimePicker::make('start')
            ->label(__('form.start date'))
            //by default we will evaluate if we should use stored db timezones
            ->timezone('America/Mexico_City')
            ->seconds(false)
            ->minDate(now('America/Mexico_City')->format('Y-m-d H:i'))
            ->maxDate(now('America/Mexico_City')->addDays(14)->format('Y-m-d H:i'))
            ->required()
            ->reactive()
            ;
    }

    public function getEndDateComponent()
    {
        return DateTimePicker::make('end')
            ->label(__('form.end date'))
            ->timezone('America/Mexico_City')
            // ->native(false)
            ->seconds(false)
            ->hidden(fn (Get $get) => !filled($get('start')))
            ->minDate(fn (Get $get) => Carbon::parse($get('start'))->addDay()->format('Y-m-d H:i'))
            ->maxDate(fn (Get $get) => Carbon::parse($get('start'))->addDays(15)->format('Y-m-d H:i'))
            ->required()
            // ->maxDate(fn (Get $get) => $get('start')?->addDays(15))
            ;
    }

    public function getStartDateCustom()
    {
        return Split::make([
            DatePicker::make('date')
                ->label(__('form.start date'))
                ->default(now('America/Mexico_City')->format('Y-m-d'))
                ->native(false),
            TimePicker::make('time')
                ->label('')
                ->default(now('America/Mexico_City')->format('h:i A'))
                ->seconds(false)
                // ->native(false)
        ])->verticallyAlignEnd()
        ;
    }
}

// return DateTimePicker::make('start')
//             ->label(__('form.start date'))
//             //by default we will evaluate if we should use stored db timezones
//             ->timezone('America/Mexico_City')
//             ->displayFormat('M d, Y h:i A')
//             ->native(false)
//             ->minutesStep(15)
//             ->seconds(false)
//             ->minDate(now())
//             ->maxDate(now()->addDays(14))
//             ->reactive()
//             ;