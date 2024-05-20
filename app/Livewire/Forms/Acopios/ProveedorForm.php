<?php

namespace App\Livewire\Forms\Acopios;

use App\Models\Acopio\Proveedor;
use App\Services\DipomexService;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Str;

/**
 * El proposito de esta clase es abstraer la creacion y edicion
 * del modelo que represanta
 */
class ProveedorForm extends Form
{
    public ?Proveedor $proveedor;

    public $nombre = ''; 
    public $rfc = ''; 
    #[Validate()]//solo para habilitar real-time validation, para esta propiedad
    public $cp = ''; //dir
    public $calle = ''; //dir
    public $num_ext = ''; //dir

    public $num_int = ''; //dir
    public $colonia = ''; //dir
    public $municipio = ''; //dir
    public $estado = ''; //dir
    public $telefono;
    public $correo;
    public $razon_social = ''; 
    public $giro_empresa = '';

    public $colonias = [];

    protected $guarded = ['colonias', 'proveedor'];

    public function rules()
    {
        return [
            'nombre' => 'required',
            'rfc' => 'required',
            'cp' => 'required',
            'calle' => 'required',
            'num_ext' => 'required',
            'colonia' => 'required',
            'municipio' => 'required',
            'estado' => 'required',
            'telefono' => 'exclude_unless:correo,null|required',
            'correo' => 'exclude_unless:telefono,null|required',
            'razon_social' => 'required',
            'giro_empresa' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El campo Nombre es obligatorio',
            'rfc.required' => 'El campo RFC es obligatorio',
            'cp.required' => 'El campo "CP o codigo postal" es obligatorio',
            'calle.required' => 'El campo Calle es obligatorio',
            'num_ext.required' => 'El campo "Numero exterior" es obligatorio',
            'colonia.required' => 'El campo Colonia es obligatorio',
            'municipio.required' => 'El campo Municipio es obligatorio',
            'estado.required' => 'El campo Estado es obligatorio',
            'telefono.required' => 'El campo Teléfono es requerido si el Correo está vacío.',
            'correo.required' => 'El campo Correo es requerido si el Teléfono está vacío.',
            'razon_social.required' => 'El campo "Razon Social" es obligatorio',
            'giro_empresa.required' => 'El campo "Giro de la empresa" es obligatorio',
        ];
    }

    /**
     * Metodo de apoyo para setear rapidamente las propiedades
     * de la instancia de este formulario, permitiendonos, 
     * reflejar eso en un formulario de edicion/vista
     *
     * @param Proveedor $proveedor
     * @return void
     */
    public function setProveedor(Proveedor $proveedor): void
    {
        $this->proveedor = $proveedor;

        $this->nombre = $proveedor->nombre; 
        $this->rfc = $proveedor->rfc; 
        $this->cp = $proveedor->cp; 
        $this->calle = $proveedor->calle; 
        $this->num_ext = $proveedor->num_ext; 
        $this->num_int = $proveedor->num_int; 
        $this->colonia = $proveedor->colonia; 
        $this->municipio = $proveedor->municipio; 
        $this->estado = $proveedor->estado; 
        $this->telefono = $proveedor->telefono; 
        $this->correo = $proveedor->correo; 
        $this->razon_social = $proveedor->razon_social; 
        $this->giro_empresa = $proveedor->giro_empresa;
    }

    public function hasErrors(...$params): bool
    {
        foreach($params as $property) {
            if($this->getErrorBag()->has('form.'.$property)) {
                return true;
            }
        }
        return false;
        // $errors = $this->getErrorBag();
    }

    public function updatedPostalCode($value)
    {
        if (strlen($value) === 5) {
            $this->fetchAddressData($value);
        } else {
            $this->resetAddressData();
        }
    }

    public function fetchAddressData($postalCode)
    {
        $dipomex = new DipomexService();
        $response = $dipomex->getAddressByPostalCode($postalCode);

        if (isset($response) && !$response['error']) {
            $data = $response['codigo_postal'] ?? [];
            $this->colonias = $data['colonias'] ?? '';
            $this->estado = $data['estado'] ?? '';
            $this->municipio = $data['municipio'] ?? '';
        } else {
            $this->resetAddressData();
        }
    }

    public function resetAddressData()
    {
        $this->colonias = [];
        $this->municipio = '';
        $this->estado = '';
    }

    public function create(): Proveedor
    {
        //Primero validamos para evitar data que no cumpla reglas
        $this->validate();

        $this->proveedor = Proveedor::create(
            //Evitamos agregar la instancia del modelo misma
            $this->except($this->guarded),
        );

        return $this->proveedor;
    }

    public function update(): void
    {
        $this->validate();

        $this->proveedor->update(
            //observe create
            $this->except($this->guarded),
        );
    }
}
