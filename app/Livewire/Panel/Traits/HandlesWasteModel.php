<?php 

namespace App\Livewire\Panel\Traits;

use App\Models\Waste;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

trait HandlesWasteModel {
    public $waste;

    public ?array $wasteData;

    public function wasteForm(Form $form): Form
    {
        return $form
            ->schema($this->getWasteFormSchema())
            ->statePath('wasteData')
            ->model($this->waste);
    }

    public function getWasteFormSchema(?Waste $custom = null): array
    {
        return [
            $this->getCateogoryFormComponent()
                ->unique(
                    table: Waste::class,
                    ignorable: $custom ?? $this->waste
                ),
            $this->getUnitCategoryComponent()
        ];
    }

    public function getCateogoryFormComponent(): Component
    {
        return TextInput::make('category')
            ->label(__('form.category'))
            ->required()
            ->maxLength(32);
    }    

    public function getUnitCategoryComponent(): Component
    {
        return Select::make('unit')
            ->options(__('form.units'))
            ->label(__('form.unit'))
            ->required()
            ->default('Kg');
    }
}