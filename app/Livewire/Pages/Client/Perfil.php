<?php

namespace App\Livewire\Pages\Client;

use App\Livewire\Forms\UserForm;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Perfil extends Component
{
    public UserForm $form;

    public $seeProfile = true;

    public $seeSolicitudes = false;

    public function mount()
    {
        if (!auth()->user()) {
            return $this->redirectRoute('logout');
        }

        $this->form->setUser(auth()->user());
    }
    
    #[Layout('components.layouts.client')]
    public function render()
    {
        return view('livewire.pages.client.perfil');
    }
}
