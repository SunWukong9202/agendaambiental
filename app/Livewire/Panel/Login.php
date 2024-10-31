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
        $this->form->fill();
        
        if(auth()->user()) {
            $this->redirectRoute('home');
        }
    }
    
    public function form(Form $form): Form
    {
        $commons = [
                TextInput::make('password')
                    ->label(__('form.password'))
                    ->revealable()
                    ->password()
                    ->required(),

                Checkbox::make('remember_me')
                    ->label(__('form.remember me')),
        
        ];
        //APP TITLE, ENTRE A SU CUENTA
        return $form
            ->schema([
                Tabs::make('tabs')->tabs([
                    Tab::make(__('form.with_key'))->schema([
                        TextInput::make('key')
                            ->label(__('form.key'))
                            ->minLength(6)
                            ->mask('999999')
                            ->required(fn(Get $get) => ! filled($get('email'))),
                        ...$commons
                    ]),

                    Tab::make(trans('form.with_email'))->schema([
                        TextInput::make('email')
                            ->label(__('form.email'))
                            ->email()
                            ->required(fn(Get $get) => ! filled($get('key'))),
                        ...$commons
                    ])
                ])
                ->extraAttributes([
                    'x-on:click' => '
                        if($event.target.innerText === "'.__('form.with_key').'") {
                            $wire.data.email = ""
                        }
                        if($event.target.innerText === "'.__('form.with_email').'") {
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
