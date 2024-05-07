<?php

namespace App\Livewire\Forms\InventarioReactivos;

use App\Models\InventarioReactivos\Reactivo;
use Livewire\Attributes\Validate;
use App\Models\InventarioReactivos\SolicitudReactivo;
use Livewire\Form;

class SolicitudForm extends Form
{
    public ?SolicitudReactivo $solicitud;

    #[Validate('required', message: "El campo cantidad es obligatorio")]
    #[Validate('min:0', message: "No se permiten valores negativos")]
    #[Validate('numeric', message: "No se permite texto en este campo")]
    #[Validate('between:0,9999.99', message: "La maxima cantidad solicitable es 9999.99")]
    public $cantidad = 0.00;

    public $comentario = "";

    #[Validate('nullable')]
    public $otro_reactivo = null;

    public $estado = false;

    public function setSolicitud(SolicitudReactivo $solicitud): void
    {
        $this->solicitud = $solicitud;
        $this->cantidad = $solicitud->cantidad;
        $this->comentario = $solicitud->comentario;
        $this->otro_reactivo = $solicitud->otro_reactivo;
        $this->estado = $solicitud->estado;
    }

    public function create()
    {
        $this->validate();

        $this->solicitud = SolicitudReactivo::create(
            $this->except('solicitud')
        );
    }

    public function update(Reactivo $reactivo, $withReactive): void
    {
        $this->validate([
            'cantidad' => function ($attribute, $value, $fail) use ($reactivo) {
                $min = min($reactivo?->total ?? $this->solicitud->reactivo->total, SolicitudReactivo::LIMIT);
                if($value > $min) {
                    $fail('La cantidad aprobada no puede ser mayor a la disponible');
                }
            }
        ]);

        $this->estado = true;

        if($withReactive) {
            $this->solicitud->reactivo_id = $reactivo->id;
            $this->otro_reactivo = null;
        }
        
        $this->solicitud->update(
            $this->except('solicitud')
        );
    }
  
}
