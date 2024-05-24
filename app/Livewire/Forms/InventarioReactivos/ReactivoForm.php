<?php

namespace App\Livewire\Forms\InventarioReactivos;

use App\Models\InventarioReactivos\Reactivo;
use Illuminate\Support\Facades\Config;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ReactivoForm extends Form
{
    public ?Reactivo $reactivo;

    #[Validate('required|string', message: 'Por favor proporcione el nombre del reactivo')]
    public $nombre = "";
    #[Validate('required|string', message: 'Por favor Proporcione un grupo quimico')]
    public $grupo = "";
    #[Validate('required|string', message: 'Por favor Proporcione una formula quimica')]
    public $formula = "";
    #[Validate('required|string', message: 'Por favor propocione una Unidad de Medida')]
    public $unidad = "";
    public $total = '0.00';//producto_en_existencia
    public $visible = false;//
    // public $tipo_unidad="Masa";

    public function setReactivo(Reactivo $reactivo): void
    {
        $this->reactivo = $reactivo;
        
        $this->nombre = $reactivo->nombre;
        $this->grupo = $reactivo->grupo;
        $this->formula = $reactivo->formula;
        $this->unidad = $reactivo->unidad;
        $this->total = $reactivo->total;
    }

    public function create()
    {
        $this->validate();

        $this->reactivo = Reactivo::create($this->except('reactivo'));
    }

    public function update(): void
    {
        $this->validate();
        
        $this->reactivo->update(
            $this->except('reactivo')
        );
    }

    public function getUnidades(): array
    {
        $arr =  Config::get('inv-reactivos.unidades_values');
        return $arr;
    }

    // public function tiposDeUnidades(): void
    // {
    //     return Config::get('inv-reactivos.unidades')
    // }
}
