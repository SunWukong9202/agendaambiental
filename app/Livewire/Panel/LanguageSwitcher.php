<?php

namespace App\Livewire\Panel;

use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Livewire\Component;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageSwitcher extends Component implements HasForms {
    use InteractsWithForms;
    
    public ?array $data = [];

    public $currentUrl = null;
    
    public function mount(): void
    {
        $data['language'] = auth()->user()->CMUser->locale == 'es' ? true : false;

        $this->form->fill($data);
    }

    public function switchLanguage($lang)
    {

        if (in_array($lang, ['en', 'es'])) {

            app()->setLocale($lang);

            auth()->user()->CMUser->update([
                'locale' => $lang
            ]);

            Notification::make()
                ->success()
                ->title(__('Language Changed!'))
                ->body(__('Language switched to ') . ucfirst($lang))
                ->send();

            $this->redirect($this->currentUrl, navigate: true);
        }
    }

    public function form(Form $form): Form
    {
        $toggle = Toggle::make('language')
            ->label(fn($state) => $state ? __('Spanish') : __('English'))
            ->onIcon('heroicon-m-language')
            ->offIcon('heroicon-m-language')
            ->reactive()
            ->afterStateUpdated(fn($state) => $this->switchLanguage($state ? 'es' : 'en'))
            ;

        return $form
            ->schema([
                $toggle    
            ])->statePath('data');
    }

    public function render()
    {
        return <<<'HTML'
        <div>
            {{ $this->form }}
        </div>
        HTML;
    }
}
