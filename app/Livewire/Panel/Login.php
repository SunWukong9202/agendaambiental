<?php

namespace App\Livewire\Panel;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Livewire\Component;

use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.base')]
class Login extends Component implements HasForms
{
    use InteractsWithForms;
    
    public ?array $data = [];
    
    public function mount(): void
    {
        $this->form->fill();
    }
    
    public function form(Form $form): Form
    {
        $commons = [
            
                TextInput::make('password')
                    ->label(__('form.password'))
                    ->password(),

                Checkbox::make('remember_me')
                    ->label(__('remember_me'))
                    ->
        ];

        return $form
            ->schema([
                Tabs::make('tabs')->tabs([
                    Tab::make(__('form.with_key'))->schema([

                    ]),

                    Tab::make(trans('form.with_email'))->schema([

                    ])
                ]),
                
            ])
            ->statePath('data');
    }
    
    public function create(): void
    {
        dd($this->form->getState());
    }


    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        $data = $this->form->getState();

        if (! auth()->attempt($this->getCredentialsFromFormData($data), $data['remember'] ?? false)) {
            $this->throwFailureValidationException();
        }

        $user = auth()->user();

        //add authorization later
        // if (
        //     ($user instanceof FilamentUser) &&
        //     (! $user->canAccessPanel(Filament::getCurrentPanel()))
        // ) {
        //     Filament::auth()->logout();

        //     $this->throwFailureValidationException();
        // }

        session()->regenerate();

        return app(LoginResponse::class);
    }

    protected function getRateLimitedNotification(TooManyRequestsException $exception): ?Notification
    {
        return Notification::make()
            ->title(__('filament-panels::pages/auth/login.notifications.throttled.title', [
                'seconds' => $exception->secondsUntilAvailable,
                'minutes' => $exception->minutesUntilAvailable,
            ]))
            ->body(array_key_exists('body', __('filament-panels::pages/auth/login.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/login.notifications.throttled.body', [
                'seconds' => $exception->secondsUntilAvailable,
                'minutes' => $exception->minutesUntilAvailable,
            ]) : null)
            ->danger();
    }

    public function render()
    {
        return view('livewire.panel.login');
    }
}
