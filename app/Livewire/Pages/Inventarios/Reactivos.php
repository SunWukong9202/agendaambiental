<?php

namespace App\Livewire\Pages\Inventarios;

use App\Livewire\Forms\InventarioReactivos\ReactivoForm;
use App\Models\InventarioReactivos\Reactivo;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy]
class Reactivos extends Component
{
    use WithPagination;

    public ReactivoForm $form;

    public $search = '';

    #[Url]
    public $sortCol;

    #[Url]
    public $sortAsc = false;

    public $modalOpen = false;

    public $action = '';
    private $howMany = 10;
    public $createSuccess = false;
    public $editSuccess = false;
    public $deleteSuccess = false;

    public function test(): void
    {
        $this->createSuccess = true;
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

    public function delete(Reactivo $reactivo)
    {
        $reactivo->delete();
        $this->form->reactivo = $reactivo;
        $this->deleteSuccess = true;
    }

    public function edit()
    {
        $this->editSuccess = true;
        $this->modalOpen = false;
        $this->form->update();
    }

    public function setAction(Reactivo $reactivo, $action) {
        $this->modalOpen = true;
        $this->action = $action;
        $this->form->setReactivo($reactivo);
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

    public function mount(): void
    {
        sleep(1);//Solo para mostrar los indicadores de carg
    }

    public function render()
    {

        $query = Reactivo::search($this->search)
            ->sort($this->sortCol, $this->sortAsc ? 'asc' : 'desc');
        // $query = $this->applySeach($query);
        return view('livewire.pages.inventarios.reactivos', [
            'reactivos' => $query->paginate($this->howMany),
        ]);
    }

    public function placeholder()
    {
        return view('components.table.placeholder', ['howMany' => $this->howMany, 'cols' => 6]);
    }
}
