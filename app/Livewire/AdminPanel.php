<?php

namespace App\Livewire;

use App\Livewire\Forms\UserForm;
use Livewire\Component;

class AdminPanel extends Component
{
    public UserForm $form;
    
    public $step = 1;

    public $isExtern = false;

    public $registrado = false;

    public $signUpSucces = false;

    public function registrar(): void
    {
        $this->registrado = true;
        $this->signUpSucces = true;
    }

    public function switchTab(): void
    {
        $this->isExtern = !$this->isExtern;
        $this->render();
    }

    public function render()
    {
        return view('livewire.admin-panel');
    }
}
