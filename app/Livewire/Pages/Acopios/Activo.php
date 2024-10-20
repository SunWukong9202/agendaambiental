<?php

namespace App\Livewire\Pages\Acopios;

use App\Livewire\Forms\UserForm;
use App\Models\Evento;
use Carbon\Carbon;
use Livewire\Component;

class Activo extends Component
{
    public Evento $acopio;
    
    public UserForm $form;
    
    public $step = 1;

    public $siguiente = false;

    public $isExtern = false;

    public $type = true;

    public $registrado = false;

    public $signUpSucces = false;

    public function updatedFormClave($value): void
    {
        $this->form->updatedKey($value);
    }

    public function updatedFormCorreo($value): void
    {
        $this->form->updatedEmail($value);
    }

    public function switchTab()
    {
        $this->form->externo = !$this->form->externo;
        $this->form->resetUser(keep: ['externo']);
    }
    public function registrar(): void
    {
        $this->form->externo = true;
        // $this->form->create();
        $this->registrado = true;
        $this->signUpSucces = true;
    }

    public function render()
    {
        // $query = Evento::whereDate('ini_evento', Carbon::today()->toDateString());

        return view('livewire.pages.acopios.activo', [
            'activos' => Evento::all(),
        ]);
    }
}
