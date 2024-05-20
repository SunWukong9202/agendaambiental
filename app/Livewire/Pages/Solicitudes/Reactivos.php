<?php

namespace App\Livewire\Pages\Solicitudes;

use App\Livewire\Forms\InventarioReactivos\SolicitudForm;
use App\Models\InventarioReactivos\Reactivo;
use App\Models\InventarioReactivos\SolicitudReactivo;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class Reactivos extends Component
{
    use WithPagination;

    public SolicitudForm $form;

    public $search = '';
    public $drawerSearch = '';

    private $users = ['users.clave', 'users.nombre'];
    private $searchables = ['otro_reactivo'];
    private $seachablesReactivos = ['reactivos.nombre'];

    public $withReactive = true;

    public $sortCol;

    public $sortAsc = false;

    public $modalOpen = false;

    public $drawerOpen = false;

    public $action = '';

    public $createSuccess = false;
    public $editSuccess = false;
    public $deleteSuccess = false;

    public $reactivo_id;

    public function test(): void
    {
        $this->createSuccess = true;
    }

    public function setCreate()
    {
        $this->action = 'create';
        $this->modalOpen = true;
    }

    public function create(): void
    {
        $this->form->create();
        $this->createSuccess = true;
        $this->js("console.log('reactivo creado')"); 
        $this->modalOpen = false;
    }

    public function delete(SolicitudReactivo $solicitud)
    {
        $solicitud->delete();
        $this->form->solicitud = $solicitud;
        $this->deleteSuccess = true;
    }

    public function edit()
    {
        $this->validate([
            'reactivo_id' => 'exclude_if:form.otro_reactivo,null|required',
        ], [
            'reactivo_id.required' => 'Escoge un reactivo para poder continuar',
        ]);

        $this->form->update($this->reactivo_id, $this->withReactive);
        $this->reactivo_id = null;
        $this->editSuccess = true;
        $this->drawerOpen = false;
    }

    public function setAction(SolicitudReactivo $solicitud, $action) {
        match($action) 
        {
            'edit' => $this->drawerOpen = true,
            default => $this->modalOpen = true
        };
        $this->action = $action;
        $this->form->setSolicitud($solicitud);
    }

    public function switchTab(): void
    {
        $this->withReactive = !$this->withReactive;
        $this->render();
    }


    public function render()
    {
        $query = $this->solicitudes();

        return view('livewire.pages.solicitudes.reactivos', [
            'solicitudes' => $query->paginate(10),
            'reactivos' => Reactivo::where('nombre', 'like', "%$this->drawerSearch%")
                ->get()
        ]);
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
            'drawer' => $this->drawerSearch = '',
            default => $this->search = ''
        };
    }

    //este metodo se llama en automatico cuando search se
    //actualiza, livewire se encarga de eso
    public function updatedSearch(): void
    {
        $this->resetPage();//<= metodo de WithPagination
    }

    public function solicitudes()
    {
        $users = 'users'; 
        $reactivos = 'reactivos';
        $solicitudes = 'solicitudes_reactivos';
        $fk_user = 'user_id';
        $fk = 'reactivo_id';

        $query = SolicitudReactivo::join($users, "$solicitudes.$fk_user", '=', "$users.id");
        
        if($this->withReactive) {
            $query->join($reactivos, "$solicitudes.$fk", '=', "$reactivos.id")
            ->select("$solicitudes.*",
                "users.clave",
                "users.nombre as user.nombre",
                "reactivos.nombre as reactivo.nombre")
            ->whereNull('otro_reactivo');
            $this->searchables = array_merge($this->seachablesReactivos, $this->users);
        }
        else {
            $query->select("$solicitudes.*",
                    "users.clave",
                    "users.nombre as user.nombre")
                ->whereNotNull('otro_reactivo');

            $this->searchables = array_merge($this->users, $this->searchables);
        }

        $query->where(function ($query) {
            foreach($this->searchables as $column) 
            {
                $query->orWhere($column, 'LIKE', '%'.$this->search.'%');
            }
        });
        
        if(!$this->withReactive && !str_starts_with($this->sortCol,'reactivo') && !empty($this->sortCol)) 
        {
            $query->orderBy($this->sortCol, $this->sortAsc ? 'asc': 'desc');
        }

        if($this->withReactive && !empty($this->sortCol)) {
            $query->orderBy($this->sortCol, $this->sortAsc ? 'asc': 'desc');
        }

        return $query;
    }
}

// private function getResults()
// {
//     $this->sortables = [];
    
//     [$table, $col] = explode('.', $this->sortCol);

//     $user_constraints = function ($query) use ($table, $col) {
//         $query->where(function ($query) {
//             foreach ($this->user_searchables as $column) {
//                 $query->orWhere($column, 'LIKE', '%' . $this->search . '%');
//             }
//         });
    
//         if($table == 'user' && $this->sortCol !== 'user.nombre') {
//             $query->orderBy($col, $this->sortAsc ? 'asc' : 'desc');
//         }
//     };
    
//     $constraints = function ($query) use ($table, $col) {
//         $query->where(function ($query) {
//             foreach ($this->reactivo_searchables as $column) {
//                 $query->orWhere($column, 'LIKE', '%' . $this->search . '%');
//             }
//         });
    
//         if($table == 'reactivo') {
//             $query->orderBy($col, $this->sortAsc ? 'asc' : 'desc');
//         }
//     };
    
//     $query = SolicitudReactivo::with(['user','reactivo'])
//         ->whereHas('reactivo', $constraints)
//         ->orWhereHas('user', $user_constraints)
//         ->orWhere('otro_reactivo', 'LIKE', '%'.$this->search.'%');

//     return $query->get();
// }


// public function _solicitudes()
// {
//     $this->sortables = [];
    
//     [$table, $col] = explode('.', $this->sortCol);

//     $user_constraints = function ($query) use ($table, $col) {
//         $query->where(function ($query) {
//             foreach ($this->user_searchables as $column) {
//                 $query->orWhere($column, 'LIKE', '%' . $this->search . '%');
//             }
//         });

//         if ($table == 'user') {
//             $query->orderBy($col, $this->sortAsc ? 'asc' : 'desc');
//         }  
//     };
    
//     $constraints = function ($query) use ($table, $col) {
//         $query->where(function ($query) {
//             foreach ($this->reactivo_searchables as $column) {
//                 $query->orWhere($column, 'LIKE', '%' . $this->search . '%');
//             }
//         });

//         if($table == 'reactivo') {
//             $query->orderBy($col, $this->sortAsc ? 'asc' : 'desc');
//         }
//     };
    
//     $query = '';

//     if($this->withReactive) {
//         $query = SolicitudReactivo::with(['user', 'reactivo'])
//             ->whereNull('otro_reactivo')
//             ->where(function ($query) use ($user_constraints, $constraints, $table, $col) {
//                 $query->whereHas('user', $user_constraints);

//                 $query->orWhereHas('reactivo', $constraints);
//             });
//     }
//     else 
//     {
//         $query = SolicitudReactivo::with(['user'])
//             ->whereNotNull('otro_reactivo')
//             ->whereHas('user', $user_constraints)
//             ->orWhere('otro_reactivo', 'LIKE', '%'.$this->search.'%');
//     }

//     if($table == 'solicitud') {
//         $query->orderBy($col, $this->sortAsc ? 'asc' : 'desc');
//     }

//     return $query;
// }
