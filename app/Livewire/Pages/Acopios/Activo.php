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

    public $isExtern = false;

    public $registrado = false;

    public $signUpSucces = false;

    public $cache = null;

    public function updatedFormClave($value): void
    {
        $this->form->updatedKey($value);
    }

    public function switchTab()
    {
        $this->isExtern = !$this->isExtern;
        
        $this->form->updatedKey(null, silenly: true);
        $this->render();
    }

    public function registrar(): void
    {
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
