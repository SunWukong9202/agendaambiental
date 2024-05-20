<?php

namespace App\Livewire\Forms\InventarioReactivos;

use App\Models\InventarioReactivos\Reactivo;
use Livewire\Attributes\Validate;
use App\Models\InventarioReactivos\SolicitudReactivo;
use Livewire\Form;

class SolicitudForm extends Form
{
    public ?SolicitudReactivo $solicitud;

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

    public function update($id, $withReactive): void
    {
        $reactivo = Reactivo::find($id) ?? $this->solicitud->reactivo;

        $this->validate([
            'cantidad' => [
                'required',
                'cantidad' => function ($attribute, $value, $fail) use ($reactivo) {
                    $min = min($reactivo->total, SolicitudReactivo::LIMIT);
                    if($value > $min) {
                        $fail('La cantidad aprobada no puede ser mayor a la disponible');
                    }
    
                    if($value < 0) {
                        $fail('No se permiten cantidades negativas');
                    }
                }
            ]
        ],
        [
            'cantidad.required' => 'Es Obligatorio proveer una cantidad'
        ]);

        $this->estado = true;
        $this->solicitud->reactivo_id = $reactivo->id;
        $reactivo->total -= $this->cantidad;
        $reactivo->save();
        
        if(!$withReactive) {
            $this->otro_reactivo = null;
        }

        $this->solicitud->update(
            $this->except('solicitud')
        );
    }
  
}
