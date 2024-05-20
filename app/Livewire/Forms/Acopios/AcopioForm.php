<?php

namespace App\Livewire\Forms\Acopios;

use App\Models\Evento;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AcopioForm extends Form
{
    public ?Evento $acopio;
    
    public $nombre = '';
    public $descripcion = '';
    public $sede = '';
    public $ini_evento = '';

    protected $guarded = [];

    public $programable = false;
    public $autoEnable = true;

    public function setProveedor(Evento $acopio): void
    {
        $this->acopio = $acopio;

        $this->nombre = $acopio->nombre;
        $this->descripcion = $acopio->descripcion;
        $this->sede = $acopio->sede;
        $this->ini_evento = $acopio->ini_evento;
    }

    public function create(): Evento
    {
        //Primero validamos para evitar data que no cumpla reglas
        $this->validate();

        $this->acopio = Evento::create(
            //Evitamos agregar la instancia del modelo misma
            $this->except('acopio'),
        );

        return $this->acopio;
    }

    public function update(): void
    {
        $this->validate();

        $this->acopio->update(
            //observe create
            $this->except('acopio'),
        );
    }
}
