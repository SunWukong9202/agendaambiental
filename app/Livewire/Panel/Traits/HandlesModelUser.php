<?php 

namespace App\Livewire\Panel\Traits;

use App\Models\User;
use Closure;
use App\Forms\Components\EmptyContainer;
use App\Forms\Components\AlpineValidator;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Component;
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

trait HandlesModelUser
{
    public $user;

    public ?array $userData;

    public function userForm(Form $form): Form
    {
        return $form
            ->schema($this->getUserFormSchema())
            ->statePath('userData')
            ->model($this->user)
            ;
    }

    private function setSender(string $sender) {
        return [
            'x-on:input' => 'validate',
            'x-data' => '{}',
            'x-on:validateUser.window' => "console.log('issue received');\$dispatch('validatedUser', { valid: errorMessage, sender: '$sender' })",
        ];
    }

    public function getUserSchema(): array
    {
        $inputs = [
            AlpineValidator::make([
                $this->getKeyFormComponent()
                    ->extraAttributes($this->setSender('key'))
            ])
            ->extraAttributes([
                'x-cloak',
                'x-show' => '$wire.userData.is_intern'
            ]), 
            
            AlpineValidator::make([
                $this->getEmailFormComponent()
                    ->extraAttributes($this->setSender('email'))
            ])
            ->validationAttribute(__('form.email'))
            ->setRules([
                'required', 'email', 'max:255|string'
            ]),
            
            AlpineValidator::make([
                $this->getNameFormComponent()
                    ->extraAttributes($this->setSender('name'))
            ])
            ->validationAttribute(__('form.name'))
            ->setRules([
                'required', 'min:6|string',   
            ])
            ,

            $this->getGenderFormComponent()
                ->required(),

            // $this->getGeneratePasswordComponent()
            //     ->visible(fn(Get $get, Set $set) => $get('has_access') && $this->regenerate($set))
        ];

        return [
            Split::make([
                Section::make([
                    Checkbox::make('is_intern')
                        ->label(__('form.is Intern')),
                    
                    EmptyContainer::make([
                        Checkbox::make('has_access')
                            ->label(__('form.has access')),
                    ])->extraAttributes([
                        'x-cloak',
                        'x-show' => '$wire.userData.is_intern',
                    ]),
                ])->grow(false),
            
                Section::make([
                    ...$inputs    
                ])
            ])->from('md')
        ];
    }

    public function getUserFormSchema($statePath = 'userData'): array
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
            ->maxLength(20);
    }
    
    public function getNameFormComponent(): Component
    {
        return TextInput::make('name')
            ->label(__('form.name'))
            ->hint(__('form.hints.Max characters', ['max' => 80]))
            ->maxLength(10);
    }
    
    public function getGenderFormComponent(): Component
    {
        return Select::make('gender')
            ->label(__('form.gender'))
            ->required()
            ->options(__('form.genders'))
            // ->native(false)
            ;
    }
    
    public function getGeneratePasswordComponent(): Component
    {
        return TextInput::make('phrase_password')
            ->label(__('form.password'))
            ->readOnly()
            ->hintAction(
                Action::make('regenerate')
                    ->icon('heroicon-m-arrow-path')
                    ->extraAttributes([
                        'x-data' => '{}',
                        'x-on:click' => "\$wire.userData.phrase_password = {$this->regenerate()}"
                    ])
            )
            ->suffixAction(
                Action::make('copyPassword')
                    ->icon('heroicon-m-clipboard')
                    ->extraAttributes([
                        'x-data' => '{}',
                        'x-on:click' => 'navigator.clipboard.writeText($wire.userData.phrase_password)'
                    ])
            )
            ;
    }
    
    private function generatePassphrase($wordCount = 4): string
    {
        $words = [
            'sun', 'moon', 'star', 'sky', 'cloud',
            'river', 'tree', 'mountain', 'ocean', 'desert',
            'flower', 'grass', 'bird', 'fish', 'bear'
        ];
    
        shuffle($words);
        return implode(' ', array_slice($words, 0, $wordCount)) . '!' . rand(1, 99); // Symbol and a random number for variability
    }
    

    public function save()
    {
        $this->validate();

        $this->model->save();

        // Optionally reset the form or perform other actions
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->user = new User(); // Reset to a new instance
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