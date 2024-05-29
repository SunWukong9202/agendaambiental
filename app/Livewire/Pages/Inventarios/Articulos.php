<?php

namespace App\Livewire\Pages\Inventarios;

use App\Livewire\Forms\InventarioArticulos\ArticuloForm;
use App\Models\InventarioAcopio\Articulo;
use Livewire\Component;
use Livewire\WithPagination;

class Articulos extends Component
{       
    use WithPagination;

    public ArticuloForm $form;

    public $search = '';
    public $searchables = ['nombre'];

    // #[Url]
    public $sortCol;

    // #[Url]
    public $sortAsc = false;

    public $modalOpen = false;

    public $action = '';
    public $actionSuccess = false;
    public $actionMessage = '';

    public function create(): void
    {
        $this->form->create();
        $this->actionSuccess = true;
        $this->actionMessage = "<b>{$this->form->articulo->nombre}</b> fue agreagado correctamente"; 
        $this->modalOpen = false;
    }

    public function delete(Articulo $articulo)
    {
        $articulo->delete();
        $this->form->articulo = $articulo;
        $this->actionMessage = "El Articulo <b>$articulo->nombre</b> fue eliminado exitosamente"; 
        $this->actionSuccess = true;
    }

    public function edit()
    {
        $this->form->update();
        $this->actionSuccess = true;
        $this->actionMessage = "<b>{$this->form->nombre}</b> fue editado exitosamente"; 
        $this->modalOpen = false;
    }

    public function setAction($action, ?Articulo $articulo = null) {
        $this->modalOpen = true;
        $this->action = $action;
        $this->form->setarticulo($articulo);
    }

    public function render()
    {
        return view('livewire.pages.inventarios.articulos', [
            'articulos' => $this->articulos()->paginate(10),
        ]);
    }

    public function placeholder()
    {
        return view('components.table.placeholder', ['howMany' => 10, 'cols' => 9]);
    }

    //SECCION DE BUSQUEDA Y ORDENAMIENTO
    public function articulos()
    {
        $query = Articulo::search($this->search, $this->searchables);

        if(!empty($this->sortCol)) {
            $query->orderBy($this->sortCol, $this->sortAsc ? 'asc': 'desc');
        }

        return $query;
    }

    public function sortBy($column)
    {
        if($this->sortCol == $column) {
            $this->sortAsc = !$this->sortAsc;
        }
        else {
            $this->sortCol = $column;
            $this->sortAsc = false;
        }
    }

    public function clear(): void
    {
        $this->search = '';
    }
    
    //este metodo se llama en automatico cuando search se
    //actualiza, livewire se encarga de eso
    public function updatedSearch(): void
    {
        $this->resetPage();//<= metodo de WithPagination
    }
}
