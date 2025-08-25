<?php 

namespace App\Livewire\Panel\Traits;

use App\Enums\Movement;
use App\Enums\Role;
use App\Enums\Status;
use App\Forms\Components\Alert;
use App\Models\CMUser;
use App\Models\Item;
use App\Models\Pivots\ItemMovement;
use Carbon\Carbon;
use Closure;
use Filament\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Hidden;
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
//handles primarly rapairment
trait HandlesItemMovement {
    public $movementData = [];
    public ?ItemMovement $record;

    public function movementForm(Form $form): Form
    {  
        return $form
            ->schema([
            ...$this->getItemSchema()
            ])
            ->statePath('movementData')
            ->model($this->record);
            ;
    }

    public function getCaptureItemSchema(): array
    {
        return [

        ];
    }

    // public function get(Type $args): void
    // {
    //     # code...
    // }


    public function getRepaimentSchema($movement): array
    {
        return [
            Hidden::make('type')->formatStateUsing(fn () => $movement),

            $this->getStatusComponent($movement),

            $this->getObservationsComponent()
                ->placeholder(fn() => match($movement) {
                    Movement::Repair_Started => __('ui.helpers.repair-started'),
                    Movement::Repair_Log => __('ui.helpers.repair-log'),
                    Movement::Repair_Completed => __('ui.helpers.repair-completed'),
                }),
        ];
    }

    public function getStatusComponent(Movement $movement)
    {
        $options = Status::by($movement);

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
            collect($options)
                ->flatMap(fn($opt) => [$opt->value => $opt->getLabel()])
        );

        return $select;
    }

    public function getEditReparimentSchema(ItemMovement $record)
    {
        return [
            $this->getSelectTechnician()
                ->reactive()
                ->disableOptionWhen(function ($value) use($record) {
                    $tec = ItemMovement::where('group_id', $record->group_id)
                        ->where('status', Status::Unassigned)->first();
                    
                    return $tec?->related_id == $value; 
                }),
            
            Alert::make()
                ->warning()
                ->title(__('ui.helpers.unassign_title'))
                ->description(__('ui.helpers.unique_unassign', ['name' => $record->related->user->name]))
                ->visible(fn(Get $get) => filled($record->related_id) && $get('related_id') != $record->related_id),

            $this->getObservationsComponent('comment')
                ->placeholder(fn(Get $get) => __('ui.helpers.assign', ['name' => CMUser::find($get('related_id'))->user->name]))
                ->visible(fn (Get $get) => $get('related_id') != $record?->related_id),
            $this->getUnassignReasonComponent()
                ->placeholder(__('ui.helpers.unassign', ['name' => $record->related->user->name]))
                ->visible(fn(Get $get) => filled($record->related_id) && $get('related_id') != $record->related_id),
        ];
    }

    public function getSelectTechnician(ItemMovement $record = null)
    {
        return Select::make('related_id')
            ->label(__('Technician'))
            ->required()
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

    public function getObservationsComponent($statePath = 'observations')
    {
        $label = ucfirst($statePath);
        return Textarea::make($statePath)
            ->label(__($label))
            ->hint(__('form.hints.Max characters', ['max' => 255]))
            ->maxLength(255);
    }

    public function getUnassignReasonComponent()
    {
        return Textarea::make('reason')
            ->label(__('Reason'))
            ->hint(__('form.hints.Max characters', ['max' => 255]))
            ->maxLength(255);
    }
}