<?php

namespace App\Livewire\Forms\InventarioReactivos;

use App\Models\InventarioReactivos\DonacionReactivo;
use App\Models\InventarioReactivos\Reactivo;
use Livewire\Attributes\Validate;
use Livewire\Form;

class DonacionForm extends Form
{
    public ?DonacionReactivo $donacion = null;

    public $user_id;
    public $reactivo_id;

    public $foto = null;
    #[Validate('required', message: "El campo Envase es requerido")]
    public $envase = '';
    #[Validate('required', message: "El campo Peso es requerido")]
    public $peso = '';
    #[Validate('required', message: "El campo Cantidad es requerido")]
    public $cantidad = '';
    #[Validate('required', message: "El campo 'Estado Quimico' es requerido")]
    public $estado = '';
    #[Validate('required', message: "El campo Condicion es requerido")]
    public $condicion = '';
    #[Validate('required', message: "El campo Caducidad es obligatorio")]
    public $caducidad = '';
    public $fac_proc;
    public $lab_proc;
    public $CRETIB = [];

    public Reactivo $reactivo;

    protected $guarded = ['donacion', 'reactivo'];


    public function setDonacion(DonacionReactivo $donacion): void
    {
        $this->donacion = $donacion;

        $this->foto = $donacion->foto;
        $this->envase = $donacion->envase;
        $this->peso = $donacion->peso;
        $this->cantidad = $donacion->cantidad;
        $this->estado = $donacion->estado;
        $this->caducidad = $donacion->caducidad;
        $this->fac_proc = $donacion->fac_proc;
        $this->lab_proc = $donacion->lab_proc;
        $this->CRETIB = $donacion->CRETIB->toArray();
    }

    public function create(): void
    {
        $this->validate();

        $this->donacion = DonacionReactivo::create(
            $this->except($this->guarded)
        );
    }

    public function update(): void
    {
        $this->validate();

        $this->donacion->update(
            $this->except($this->guarded)
        );
    }
    
}
