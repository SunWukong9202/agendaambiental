<?php

namespace App\Livewire;

use App\Models\Evento;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\Attributes\Validate;

class EventRegistrationForm extends Component
{
    #[Validate('required|min:6|numeric')]
    public $clave = '';
    public ?User $user;
    public $ubicacion = '';
    public $horario = '';
    public Collection $events;

    public function render()
    {
        return view('livewire.event-registration-form');
    }

    public function mount(): void
    {
        $this->events = Evento::all();
    }

    public function updated($name, $value)
    {
        $this->user = User::where('clave', $value)->first();
    }

    public function updateEventInf($id) {
        $event = Evento::find($id);
        $this->ubicacion = $event?->ubicacion ?? '';
        $this->horario = $event?->horario ?? '';
    }

    private $nivel = ['Nivel Medio Superior', 'Licenciatura', 'Maestria', 'Doctorado', 'Otro'];
        
}
