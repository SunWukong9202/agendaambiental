<?php

namespace App\Livewire\Pages\Inventarios;

use App\Models\InventarioReactivos\Reactivo;
use App\Utils\FilterableSortableSearchable;
use Livewire\Component;
use Livewire\WithPagination;

class Reactivos extends Component
{
    use WithPagination;

    public $search = '';

    public $sortCol;

    public $sortAsc = false;

    public $modalOpen = false;

    public $action = '';

    public $actionable = '';

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


    public function delete(Reactivo $reactivo)
    {
        $this->actionable = $reactivo;
    }

    public function edite(Reactivo $reactivo)
    {
        $this->modalOpen = true;
        $this->actionable = $reactivo;

        $this->action = 'edite';
    }

    public function show(Reactivo $reactivo)
    {
        $this->modalOpen = true;
        $this->actionable = $reactivo;

        $this->action = 'show';
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

    public function render()
    {
        $query = Reactivo::search($this->search)
            ->sort($this->sortCol, $this->sortAsc ? 'asc' : 'desc');
        // $query = $this->applySeach($query);
        return view('livewire.pages.inventarios.reactivos', [
            'reactivos' => $query->paginate(10),
        ]);
    }
}


    // protected function applySeach($query)
    // {
    //     return $this->search === ''
    //         ? $query
    //         : $query
    //             ->where('nombre', 'like', '%'.$this->search.'%')
    //             ->orWhere('grupo', 'like', '%'.$this->search.'%');
    // }
