<?php

namespace App\Livewire\Pages;

use App\Livewire\Forms\Acopios\AcopioForm;
use App\Models\Evento;
use Livewire\Component;
use Livewire\WithPagination;

class Events extends Component
{
    use WithPagination;

    public AcopioForm $form;

    public $search = '';
    public $searchables = ['nombre', 'sede'];

    // #[Url]
    public $sortCol;

    // #[Url]
    public $sortAsc = false;

    public $modalOpen = false;

    public $action = '';
    public $createSuccess = false;
    public $editSuccess = false;
    public $deleteSuccess = false;

    public function create(): void
    {
        $this->form->create();
        $this->createSuccess = true;
        $this->js("console.log('acopio creado')"); 
        $this->modalOpen = false;
    }

    public function delete(Evento $acopio)
    {
        $acopio->delete();
        $this->form->acopio = $acopio;
        $this->deleteSuccess = true;
    }

    public function edit()
    {
        $this->editSuccess = true;
        $this->modalOpen = false;
        $this->form->update();
    }

    public function setAction($action, ?Evento $acopio) {
        $this->modalOpen = true;
        $this->action = $action;
        if(isset($acopio)) $this->form->setProveedor($acopio);
    }

    public function render()
    {
        $query = $this->acopios();

        return view('livewire.pages.events', [
            'acopios' => $query->paginate(10),
        ]);
    }


    //SECCION DE BUSQUEDA Y ORDENAMIENTO
    public function acopios()
    {
        $query = Evento::search($this->search, $this->searchables);

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
