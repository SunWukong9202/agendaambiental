<?php

namespace App\Livewire;

use App\Livewire\Forms\Acopios\ProveedorForm;
use App\Livewire\Forms\UserForm;
use App\Models\Acopio\Proveedor;
use App\Models\InventarioAcopio\Articulo;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminPanel extends Component
{
    public ProveedorForm $form;

    public Articulo $articulo;

    public $proveedor = '';

    public $action;

    // #[On('create-proveedor-success')]
    // public function create($id): void
    // {
        
    //     dd($this->form);

    // }

    #[On('edit-proveedor')]
    public function update(): void
    {
        dd('called update');
        $this->form->update();
    }

    // public function updatedProveedor($proveedor): void
    // {
    //     // $proveedor = Proveedor::find($id);

    //     $this->form->setProveedor($proveedor);
    // }

    public function updatedProveedor($value)
    {
        $proveedor = Proveedor::find($value);

        $this->proveedor = $value;

        if(empty($value) || !isset($proveedor)) return;

        // dd($proveedor);

        $this->form->setProveedor($proveedor);

        $this->form->updatedPostalCode($proveedor->cp);
    }

    public function updatedFormCp($value): void
    {
        $this->form->updatedPostalCode($value);
    }

    public function mount(): void
    {
        // $this->proveedor = Proveedor::find(1);
        $this->articulo = Articulo::make();
        $this->articulo->nombre = 'some';
    }
    

    public function render()
    {

        return view('livewire.admin-panel', [
            'proveedores' => Proveedor::all(),
        ]);
    }
}
