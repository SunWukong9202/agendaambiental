<?php

namespace App\Livewire\Pages\Client;

use App\Livewire\Forms\UserForm;
use App\Models\InventarioReactivos\Reactivo;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Perfil extends Component
{
    use WithPagination;

    public UserForm $form;

    public $see = 'profile';

    public $get = 'all'; //all, justOthers, withoutOthers

    //solicitudes: reactivos = true, articulos = false
    public $show_in_sol = 'reactivos';
    //donaciones: reactivos, residuos, cambalache
    public $show = 'reactivos';

    public function mount()
    {
        if (!auth()->user()) {
            return $this->redirectRoute('logout');
        }
        // $this->form->clearKeep();
        $this->form->setUser(auth()->user());
    }

    public function reactivosSolicitados()
    {
        $query = $this->form->user->solicitudesOtroReactivo();
        
        return $this->applyFilters($query, 'otro_reactivo');
    }

    public function applyFilters($query, $field)
    {
        match($this->get) 
        {   
            'justOthers' => $query->whereNull($field),
            'withoutOthers' => $query->whereNotNull($field),
            default => $query
        };
            
        return $query;
    }

    public function articulosSolicitados()
    {
        $query = $this->form->user->solicitudesOtroArticulo();

        return $this->applyFilters($query, 'otro_articulo');
    }

    public function donaciones()
    {
        $user = $this->form->user;
        return match($this->show) {
            'reactivos' => $user->reactivosDonados(),
            'residuos' => $user->donacionesDeResiduos(),
            'libros' => $user->donacionesDeLibros()
        };
    }
    
    #[Layout('components.layouts.client')]
    public function render()
    {
        $solicitudes =  $this->show_in_sol == 'reactivos'
            ? $this->reactivosSolicitados()
            : $this->articulosSolicitados();

        // $donaciones = $this->see == 'donaciones' && $this->show == 'reactivos'
        return view('livewire.pages.client.perfil', [
            'donaciones' => $this->donaciones()->paginate(10),
            'solicitudes' => $solicitudes->paginate(10),
        ]);
    }
}
