<?php

namespace App\Livewire\Panel;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Livewire\Component;

use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.base')]
class Login extends Component implements HasForms, HasActions
{
    use InteractsWithForms, InteractsWithActions;
    
    public ?array $data = [];

    public bool $withKey = true;
    
    public function mount(): void
    {
        app()->setLocale('es');

        $this->form->fill();

        if(auth()->user()) {
            $this->redirectRoute('home');
        }
    }
    
    public function form(Form $form): Form
    {
        $commons = [
                TextInput::make('password')
                    ->translateLabel()
                    ->default("password")//
                    ->revealable()
                    ->password()
                    ->required(),

                Checkbox::make('remember me')
                    ->translateLabel(),
        
        ];
        //APP TITLE, ENTRE A SU CUENTA
        return $form
            ->schema([
                Tabs::make('tabs')->tabs([
                    Tab::make(__('with email'))
                    ->schema([
                        TextInput::make('email')
                            ->translateLabel()
                            ->email()
                            ->default("admin@gmail.com")
                            ->required(fn(Get $get) => ! filled($get('key'))),
                        ...$commons
                    ]),

                    Tab::make(__('with key'))
                    ->schema([
                        TextInput::make('key')
                            ->translateLabel()
                            ->minLength(6)
                            ->mask('999999')
                            ->required(fn(Get $get) => ! filled($get('email'))),
                        ...$commons
                    ])
                ])
                ->extraAttributes([
                    'x-on:click' => '
                        if($event.target.innerText === "'. __('with key') . '") {
                            $wire.data.email = ""
                        }
                        if($event.target.innerText === "'. __('with email') . '") {
                            $wire.data.key = ""
                        }
                    ',
                ])
                ->contained(false),
                
            ])
            
            ->statePath('data');
    }

    public function authenticate()
    {
        $this->validate();

        $data = $this->form->getState();

        $credentials = [
            'password' => $data['password'],
        ];

        if($data['email']) {
            $credentials['email'] = $data['email'];
        } else {
            $credentials['key'] = $data['key'];
        }

        if (Auth::attempt($credentials, $data['remember'] ?? false)) {
            
            session()->regenerate();

            return $this->redirectRoute('home', navigate: true);
        }

        $this->onValidationError(ValidationException::withMessages([
            __('form.auth.fail')
        ]));
    }

    protected function onValidationError(ValidationException $exception): void
    {
        Notification::make()
            ->title($exception->getMessage())
            ->danger()
            ->send();
    }

    public function render()
    {
        return view('livewire.panel.login');
    }
}
