<?php

namespace App\Livewire\Panel\Traits;

use App\Enums\Permission;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Spatie\Permission\Models\Role;

trait HandlesRoleModel {
    public Role $role;
    public ?array $roleData = [];

    public function roleForm(Form $form): Form
    {
        return $form
            ->schema($this->getRoleFormSchema())
            ->statePath('roleData')
            ->model($this->role)
            ;
    }

    public function setRoleData($role): array
    {
        $this->role = $role ?? new Role;
        $permissions = $this->role->permissions->pluck('name')->toArray();
        $data['name'] = $role->name ?? '';
        if(count($permissions) == 0) return $data;

        foreach(Permission::groupByEntity() as $name => $group) {
            $options = [];
            foreach($group as $option) {
                if(in_array($option->value, $permissions)) {
                    $options[] = $option->value;
                }
            }
            $data[$name] = $options;
        }
        return $data;
    }

    public function getRoleFormSchema(): array
    {
        $groups = [
            $this->getNameFormComponent()->columnSpanFull()
        ];
    
        foreach (Permission::groupByEntity() as $name => $group) {
            $options = [];
            foreach($group as $option) {
                $options[$option->value] = $option->readable();
            }

            $checkboxes = CheckboxList::make($name)
                ->label('')
                ->columns(2)
                ->options($options)
                ->bulkToggleable()
                ;

            $groups[] = Fieldset::make($name)->schema([$checkboxes]);
        }

        return $groups;
        // [
        //     Section::make()
        //     ->columns([
        //         'sm' => 2, 'lg' => 3, 'xl' => 4
        //     ])
        //     ->schema($groups)
        // ];
    }

    public function getNameFormComponent(): Component
    {
        return TextInput::make('name')
            ->label(__('form.name'))
            ->required()
            ->maxLength(64)
            ->unique(ignorable: $this->role);
    }
}