<?php 

namespace App\Livewire\Panel\Traits;

use App\Models\User;
use Closure;
use App\Forms\Components\EmptyContainer;
use App\Forms\Components\AlpineValidator;
use App\Models\CMUser;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;

trait HandlesModelUser
{
    public ?CMUser $user = null;

    public ?array $userData;

    public function userForm(Form $form): Form
    {
        return $form
            ->schema($this->getUserFormSchema())
            ->statePath('userData')
            ->model($this->user)
            ;
    }

    public function getUserSchema($statePath = 'userData'): array
    {
        $inputs = [
            EmptyContainer::make([
                $this->getKeyFormComponent()
                    ->unique(ignorable: $this->user),
            ])->extraAttributes([
                'x-cloak' => '',
                'x-show' => "\$wire.$statePath.is_intern",
            ]),
             
            $this->getEmailFormComponent()
                ->required()
                ->unique(ignorable: $this->user)
                ,
               
            $this->getNameFormComponent()
                ->required(),
    
            $this->getGenderFormComponent()
                ->required(),

        ];
    
        return [
            Split::make([
                Section::make([
                    Checkbox::make('is_intern')
                        ->label(__('form.is Intern'))
                        ->extraAttributes([
                            'x-on:click' => "\$wire.$statePath.has_access = false",
                        ]),
                    
                    EmptyContainer::make([
                        Checkbox::make('has_access')
                            ->label(__('form.has access'))
                            ,
                    ])->extraAttributes([
                        'x-cloak' => '',
                        'x-show' => "\$wire.$statePath.is_intern",
                    ]),
                ])->grow(false),
            
                Section::make([
                    ...$inputs    
                ])
            ])->from('md')
        ];
    }

    public function getUserFormSchema($ignorable = null): array
    {
        $inputs = [
            $this->getNameFormComponent()
            ->required(),

            $this->getEmailFormComponent()
                ->required()
                ->regex('/^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,}$/')
                // ->unique(ignorable: $ignorable ?? $this->user)
                ->unique(
                    table: CMUser::class,
                    ignorable: $ignorable ?? $this->user,
                ),
    
            $this->getGenderFormComponent()
                ->required()
                ->reactive(),

            $this->getOtherGenderFormComponent()
                ->required(fn(Get $get) => $get('gender') == 'other')
                ->visible(fn(Get $get) => $get('gender') == 'other')
        ];
    
        return [
            ...$inputs
        ];
    }
    
    public function getKeyFormComponent(): Component
    {
        return TextInput::make('key')
            ->label(__('form.key'))
            ->numeric()
            ->minLength(6)
            ->minValue(0)
            ->mask('999999');
    }
    
    public function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label(__('form.email'))
            ->email()
            ->hint(__('form.hints.Max characters', ['max' => 255]))
            ->maxLength(255);
    }
    
    public function getNameFormComponent(): Component
    {
        return TextInput::make('name')
            ->label(__('form.name'))
            ->hint(__('form.hints.Max characters', ['max' => 80]))
            ->maxLength(80);
    }
    
    public function getGenderFormComponent(): Component
    {
        return Select::make('gender')
            ->label(__('form.gender'))
            ->options(__('form.genders'))
            // ->native(false)
            ;
    }

    public function getOtherGenderFormComponent(): Component
    {
        return TextInput::make('other_gender')
            ->label(__('form.gender'))
            ->maxLength(15);
    }
    
    
    private function userNotification($action, $name): Notification
    {
        return Notification::make()
            ->success()
            ->title(__('ui.notifications.users.title', compact('action')))
            ->body(__('ui.notifications.users.body', compact('action', 'name')));
    }

    public function createUser()
    {
        $data = $this->userForm->getState();
        CMUser::create($data);

        // Optionally reset the form or perform other actions
        $this->resetForm($data['name']);
    }

    public function resetForm($name)
    {
        $this->userNotification(__('Added'), $name)->send();
        $this->userForm->fill(); 
        $this->dispatch('close-modal', id: 'create-user');
    }

    public function getUploadSignature()
    {
        return FileUpload::make('signature_url')
            ->image()
            ->imagePreviewHeight('250')
            ->loadingIndicatorPosition('left')
            ->panelAspectRatio('2:1')
            ->panelLayout('integrated')
            ->removeUploadedFileButtonPosition('right')
            ->uploadButtonPosition('left')
            ->uploadProgressIndicatorPosition('left')
            ;
    }

}

// $inputs = [
//     AlpineValidator::make([
//         $this->getKeyFormComponent()
//             ->required()
//             ->extraAttributes([
//                 'x-on:input' => 'validate'
//             ])
//     ])
//     ->extraAttributes([
//         'x-cloak',
//         'x-show' => '$wire.userData.is_intern'
//     ]), 
    
//     AlpineValidator::make([
//         $this->getEmailFormComponent()
//             ->extraAttributes([
//                 'x-on:input' => 'validate'
//             ])
//     ])
//     ->validationAttribute(__('form.email'))
//     ->setRules([
//         'required', 'email', 'max:255|string'
//     ]),
       
//     AlpineValidator::make([
//         $this->getNameFormComponent()
//             ->extraAttributes([
//                 'x-on:input' => 'validate'
//             ])
//     ])
//     ->validationAttribute(__('form.name'))
//     ->setRules([
//         'required', 'min:6|string',   
//     ])
//     ,

//     $this->getGenderFormComponent()
//         ->required(),

//     // $this->getGeneratePasswordComponent()
//     //     ->visible(fn(Get $get, Set $set) => $get('has_access') && $this->regenerate($set))
// ];