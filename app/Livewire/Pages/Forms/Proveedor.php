<?php

namespace App\Livewire\Pages\Forms;

use App\Livewire\Forms\Acopios\ProveedorForm;
use App\Models\Acopio\Proveedor as AcopioProveedor;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;

class Proveedor extends Component
{
    #[Modelable]
    public ProveedorForm $form;

    private $suffix = 'proveedor';

    #[On('create-proveedor')]
    public function create(): void
    {
        $proveedor = $this->form->create();

        $this->dispatch("create-proveedor-success", id: $proveedor->id);
    }


    public function render()
    {
        return view('livewire.pages.forms.proveedor');
    }
}
