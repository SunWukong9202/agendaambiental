<?php

namespace App\Livewire\Pages\Acopios;

use App\Livewire\Forms\Acopios\ProveedorForm;
use App\Models\Acopio\Proveedor;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class Proveedores extends Component
{
    use WithPagination;

    public ProveedorForm $form;

    public $search = '';
    public $searchables = ['nombre', 'rfc', 'telefono', 'correo'];

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
        $this->js("console.log('proveedor creado')"); 
        $this->modalOpen = false;
    }

    public function delete(Proveedor $proveedor)
    {
        $proveedor->delete();
        $this->form->proveedor = $proveedor;
        $this->deleteSuccess = true;
    }

    public function edit()
    {
        $this->editSuccess = true;
        $this->modalOpen = false;
        $this->form->update();
    }

    public function setAction($action, ?Proveedor $proveedor) {
        $this->modalOpen = true;
        $this->action = $action;
        if(isset($proveedor)) $this->form->setProveedor($proveedor);
        if($action == 'edit') $this->form->fetchAddressData($this->form->cp);
    }

    public function updatedFormCp($value): void
    {
        $this->form->updatedPostalCode($value);
    }

    public function mount(): void
    {
        sleep(1);//Solo para mostrar los indicadores de carg
    }

    public function render()
    {
        $query = $this->proveedores();
        return view('livewire.pages.acopios.proveedores', [
            'proveedores' => $query->paginate(10)
        ]);
    }

    public function placeholder()
    {
        return view('components.table.placeholder', ['howMany' => 10, 'cols' => 9]);
    }

    //SECCION DE BUSQUEDA Y ORDENAMIENTO
    public function proveedores()
    {
        $query = Proveedor::search($this->search, $this->searchables);

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
