<?php

namespace App\Livewire\Pages\Client;

use App\Livewire\Forms\InventarioReactivos\DonacionForm;
use App\Livewire\Forms\InventarioReactivos\ReactivoForm;
use App\Models\InventarioAcopio\Articulo;
use App\Models\InventarioAcopio\SolicitudArticulo;
use App\Models\InventarioReactivos\Reactivo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Solicitudes extends Component
{
    public DonacionForm $form;

    public string $type;

    public $founded = true;

    public $show = false;

    public $success = false;

    public $successMessage = '';

    public $id;

    public $otro = null;

    public $comentario = '';
    
    public $cantidad = 0.00;

    public function updatedId($value): void
    {
        $reactivo = Reactivo::find($value);
        $this->show = false;
        if(!$reactivo) return;

        $this->form->reactivo = $reactivo;
        $this->show = true;
    }

    public function donar(): void
    {
        $this->form->user_id = auth()->user()->id;
        $this->form->reactivo_id = $this->id;
        $this->js("console.log('{$this->form->caducidad}')");
        if(!empty($this->form->caducidad)) {
            $cad = Carbon::createFromFormat("d/m/Y", $this->form->caducidad);
            $this->form->caducidad = $cad;
        }

        $this->form->create();
        $this->success = true;

        $this->successMessage = "La Donacion fue enviada correctamente";
    }

    public function solicitar()
    {
        $this->validate([
            'id' => $this->founded ? 'required': '',
            'otro' => !$this->founded ? 'required' : '',
            'cantidad' => $this->type == 'reactivos' ? ['required', 'numeric', 'min:0', 'max:9999.99'] : '',
        ], [
            'otro.required' => 'Es obligatorio especificar el '.substr($this->type, 0, strlen($this->type) - 1).' buscado',
            'id.required' => 'Escoge un '.substr($this->type, 0, strlen($this->type) - 1).' para poder continuar'
        ]);

        $user = User::find(auth()->user()->id);
        
        $comentario = $this->comentario;
        $cantidad = $this->cantidad;

        if ($this->type === 'reactivos') {
            $otro_reactivo = $this->otro;
            // Código para el tipo 'reactivos'
            if(!$otro_reactivo) {
                $user->reactivosSolicitados()
                    ->attach($this->id, compact('comentario', 'cantidad'));
            }
            else {
                $user->solicitudesOtroReactivo()->create(
                    compact('otro_reactivo', 'comentario', 'cantidad')
                );
            }
        } 
        
        if ($this->type === 'articulos') {
            $otro_articulo = $this->otro;
            // Código para el tipo 'articulos'
            $solicitud = SolicitudArticulo::make(
                compact('comentario')
            );
            $solicitud->solicitante_id = $user->id;

            if(!$otro_articulo) {
                // $user->articulosSolicitados()
                //     ->attach($this->id, compact('comentario'));
                $solicitud->articulo_id = $this->id;
            }
            else {
                $solicitud->otro_articulo = $otro_articulo;

                // $user->solicitudesOtroArticulo()->create(
                //     compact('otro_articulo', 'comentario')
                // );
            }
            $solicitud->save();
        }

        $this->success = true;
        $this->successMessage = 'Tu solicitud fue enviada correctamente'; 
    } 


    #[Layout('components.layouts.client')]
    public function render()
    {
        $reactivos = [];
        $articulos = [];
        
        $reactivos = Reactivo::where('visible', true)->get();

        if($this->type == 'articulos') {
            $articulos = Articulo::all();
        }

        return view('livewire.pages.client.solicitudes', [
            'reactivos' => $reactivos,
            'articulos' => $articulos
        ]);
    }
}
