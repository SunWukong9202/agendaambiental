<?php

namespace App\Livewire\Forms\InventarioReactivos;

use Livewire\Attributes\Validate;
use Livewire\Form;

class DonacionForm extends Form
{
    public $foto = null;
    public $envase = '';
    public $peso = '';
    public $cantidad = '';
    public $estado = '';
    public $caducidad = '';
    public $fac_proc = '';
    public $lab_proc = '';
    public $cretib = [];
    
}
