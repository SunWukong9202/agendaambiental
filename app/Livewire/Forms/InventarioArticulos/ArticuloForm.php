<?php

namespace App\Livewire\Forms\InventarioArticulos;

use App\Models\InventarioAcopio\Articulo;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ArticuloForm extends Form
{
    public ?Articulo $articulo;

    #[Validate('required', message: "El campo Nombre es obligatorio")]
    public $nombre = ''; 
    #[Validate('required', message: "El campo cantidad es obligatorio")]
    #[Validate('min:0', message: "La cantidad no puede ser menor que 0")]
    public $cantidad = 0;

    protected $guarded = ['articulo'];
    
    public function setArticulo(?Articulo $articulo = null): void
    {
        $this->articulo = $articulo;

        $this->nombre = $articulo?->nombre ?? ''; 
        $this->cantidad = $articulo?->cantidad ?? 0; 
    }


    public function create(): void
    {
        $this->validate();

        $this->articulo = Articulo::create(
            $this->except($this->guarded)
        );
    }

    public function update(): void
    {
        $this->validate();

        $this->articulo->update(
            $this->except($this->guarded)
        );
    }
}
