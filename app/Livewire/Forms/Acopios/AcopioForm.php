<?php

namespace App\Livewire\Forms\Acopios;

use App\Models\Evento;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AcopioForm extends Form
{
    public ?Evento $acopio;
    
    #[Validate('required', message: 'El campo Nombre es obligatorio')]
    public $nombre = '';
    public $descripcion = '';
    #[Validate('required', message: 'El campo Sede es obligatorio')]
    public $sede = '';
    #[Validate('required', message: 'Es obligatorio especificar la fecha de publicacion')]
    public $ini_evento = null;

    protected $guarded = ['acopio'];

    public function setAcopio(Evento $acopio): void
    {
        $this->acopio = $acopio;

        $this->nombre = $acopio->nombre;
        $this->descripcion = $acopio->descripcion;
        $this->sede = $acopio->sede;
        $this->ini_evento = $acopio->ini_evento;
    }

    public function make(): Evento
    {
        $this->acopio = Evento::make(
            $this->except($this->guarded),
        );
        return $this->acopio;
    }

    public function create(): Evento
    {
        //Primero validamos para evitar data que no cumpla reglas
        $this->validate();

        $this->acopio = Evento::create(
            //Evitamos agregar la instancia del modelo misma
            $this->except($this->guarded),
        );

        return $this->acopio;
    }

    public function update(): void
    {
        $this->validate();

        $this->acopio->update(
            //observe create
            $this->except($this->guarded),
        );
    }
}
