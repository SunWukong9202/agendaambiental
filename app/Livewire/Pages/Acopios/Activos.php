<?php

namespace App\Livewire\Pages\Acopios;

use App\Models\Evento;
use Carbon\Carbon;
use Livewire\Component;

class Activos extends Component
{
    

    public function render()
    {
        $query = Evento::whereDate('ini_evento', Carbon::today()->toDateString());

        return view('livewire.pages.acopios.activos', [
            'activos' => $query->get()
        ]);
    }
}
