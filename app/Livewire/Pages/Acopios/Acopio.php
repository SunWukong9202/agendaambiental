<?php

namespace App\Livewire\Pages\Acopios;

use App\Livewire\Forms\Acopios\AcopioForm;
use App\Models\Evento;
use Carbon\Carbon;
use Livewire\Component;

class Acopio extends Component
{
    public $action = '';
    public ?Evento $acopio;
    public AcopioForm $form;

    public function create()
    {
        // $ini_evento = Carbon::parse($this->form->ini_evento)->utc();
        // dd($ini_evento);
        $this->form->create();
        session()->flash('actionMessage', "El acopio <b>{$this->form->acopio->nombre}</b> fue creado exitosamente");

        return $this->redirectRoute('admin.events', navigate: true);
    }

    public function edit()
    {
        $this->form->update();
        session()->flash('actionMessage', "El acopio <b>{$this->form->acopio->nombre}</b> fue Editado exitosamente");
        return $this->redirectRoute('admin.events', navigate: true);

    }

    public function mount($action, $id = null)
    {
        $this->action = $action;
        if($id) {
            $acopio = Evento::findOrFail($id);
            $this->form->setAcopio($acopio);
        }
    }
}
