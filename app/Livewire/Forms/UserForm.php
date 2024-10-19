<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    public ?User $user;
    
    public $clave = null;
    #[Validate('required', message: 'El campo "Nombre" es obligatorio')]
    public $nombre = '';
    #[Validate('required', message: 'El campo "Apellido Materno" es obligatorio')]
    public $ap_mat = '';
    #[Validate('required',  message: 'El campo "Apellido Paterno" es obligatorio')]
    public $ap_pat = '';
    #[Validate('required', message: 'El campo "Genero" es obligatorio')]
    public $genero = '';
    public $procedencia = '';
    #[Validate('required', message: 'El campo "Correo" es obligatorio')]
    public $correo = '';
    #[Validate('required', message: 'El campo "Telefono" es obligatorio')]
    public $telefono = '';
    public $password = '';
    public $externo = false;

    protected $guarded = ['user', 'not_found'];
    protected $keep = [];
    public $not_found = false;

    public function setUser(User $user = null): void
    {
        $this->user = $user;

        if(!in_array('clave', $this->keep)) $this->clave = $user?->clave ?? null;
        if(!in_array('nombre',$this->keep)) $this->nombre = $user?->nombre ?? '';
        if(!in_array('ap_mat',$this->keep)) $this->ap_mat = $user?->ap_mat ?? '';
        if(!in_array('ap_pat',$this->keep)) $this->ap_pat = $user?->ap_pat ?? '';
        if(!in_array('genero',$this->keep)) $this->genero = $user?->genero ?? '';
        if(!in_array('procedencia', $this->keep)) $this->procedencia = $user?->procedencia ?? '';
        if(!in_array('correo',   $this->keep)) $this->correo = $user?->correo ?? '';
        if(!in_array('telefono', $this->keep)) $this->telefono = $user?->telefono ?? '';
        if(!in_array('password', $this->keep)) $this->password = $user?->password ?? '';
        if(!in_array('externo',  $this->keep)) $this->externo = $user?->externo ?? false;
    }

    public function updatedKey($clave, $silenly = false): void
    {
        $clave = trim($clave);
        if(strlen($clave) === 6) {
            $this->fetchUserWith(['clave' => $clave]);
        }
        else {
            $this->resetUser(keep: ['clave', 'externo']);
            if(!$silenly) $this->not_found = true;
        }
    }

    public function updatedEmail($email): void
    {
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->keep = ['correo', 'externo'];
            $this->fetchUserWith([
                'correo' => $email,
                // 'externo' => true,
            ]);
        } else {
            $this->resetUser(keep: ['correo', 'externo']);
        }
    }

    public function fetchUserWith($contraints, $silenly = false): void
    {
        $query = User::query();
        foreach($contraints as $key => $value) {
            $query->where($key, $value);
        }
        $user = $query->firstOr(fn() => null);

        if($silenly) $this->not_found = !isset($user);
        if($user) {
            $this->setUser($user);
        }
    }

    public function resetUser($keep): void
    {
        $this->keep = $keep;
        //Si no preveo un usuario se resetea por default
        $this->setUser();
    }

    public function create(): User
    {
        //Primero validamos para evitar data que no cumpla reglas
        $this->validate();

        $this->user = User::create(
            //Evitamos agregar la instancia del modelo misma
            $this->except($this->guarded),
        );

        return $this->user;
    }

    public function update(): void
    {
        $this->validate();

        $this->user->update(
            //observe create
            $this->except($this->guarded),
        );
    }
}
