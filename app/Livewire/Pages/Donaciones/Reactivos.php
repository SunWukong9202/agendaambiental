<?php

namespace App\Livewire\Pages\Donaciones;

use App\Livewire\Forms\InventarioReactivos\DonacionForm;
use App\Models\InventarioReactivos\DonacionReactivo;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class Reactivos extends Component
{
    use WithPagination;

    public DonacionForm $form;

    public ?DonacionReactivo $donacion = null;

    public $search = '';

    private $users = ['users.clave', 'users.nombre'];
    private $searchables = ['condicion', 'estado', 'condicion', 'envase'];
    private $seachablesReactivos = ['reactivos.nombre'];

    public $sortCol;

    public $sortAsc = false;

    public $modalOpen = false;


    public function show($id): void
    {
        $donacion = DonacionReactivo::findOrFail($id);
        $this->form->setDonacion($donacion);
        $this->modalOpen = true;
    }

    public function mount(): void
    {
        sleep(1);//Solo para mostrar los indicadores de carg
    }

    public function render()
    {
        $query = $this->donaciones();
        return view('livewire.pages.donaciones.reactivos', [
            'donaciones' => $query->paginate(10)
        ]);
    }

    public function placeholder()
    {
        return view('components.table.placeholder', ['howMany' => 10, 'cols' => 7]);
    }
    
    // SECCION DE BUSQUEDA Y ORDENAMIENTO    

    public function sortBy($column)
    {
        if($this->sortCol == $column) {
            $this->sortAsc = !$this->sortAsc;
        }
        else {
            $this->sortCol = $column;
            $sortAsc = false;
        }
    }    

    public function clear($search = 'main'): void
    {
        match($search) {
            default => $this->search = ''
        };
    }

    //este metodo se llama en automatico cuando search se
    //actualiza, livewire se encarga de eso
    public function updatedSearch(): void
    {
        $this->resetPage();//<= metodo de WithPagination
    }

    public function donaciones()
    {
        $users = 'users'; 
        $reactivos = 'reactivos';
        $donaciones = 'donaciones_reactivos';
        $fk_user = 'user_id';
        $fk = 'reactivo_id';
    
        $query = DonacionReactivo::join($users, "$donaciones.$fk_user", '=', "$users.id")
            ->join($reactivos, "$donaciones.$fk", '=', "$reactivos.id")
            ->distinct() // Asegura que los resultados sean únicos
            ->select("$donaciones.*"); // Selecciona solo las columnas de la tabla principal
    
        $this->searchables = array_merge($this->seachablesReactivos, $this->users);
    
        $this->searchables = array_merge($this->users, $this->searchables);
    
        $query->where(function ($query) {
            foreach($this->searchables as $column) 
            {
                $query->orWhere($column, 'LIKE', '%'.$this->search.'%');
            }
        });
    
        if(!empty($this->sortCol)) {
            $query->orderBy($this->sortCol, $this->sortAsc ? 'asc': 'desc');
        }
    
        return $query;
    }
    
}
