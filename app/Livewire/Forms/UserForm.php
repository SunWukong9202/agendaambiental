<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    public ?User $user;
    
    public $clave = '';
    public $nombre = '';
    public $ap_mat = '';
    public $ap_pat = '';
    public $genero = '';
    public $procedencia = '';
    public $correo = '';
    public $telefono = '';
    public $password = '';
    public $externo = false;

    protected $guarded = ['user', 'not_found'];

    protected $keep = ['clave'];

    public $not_found = false;

    public function setUser(User $user = null): void
    {
        $this->user = $user;

        if(!in_array('clave', $this->keep)) $this->clave = $user?->clave ?? '';
        if(!in_array('nombre', $this->keep)) $this->nombre = $user?->nombre ?? '';
        if(!in_array('ap_mat', $this->keep)) $this->ap_mat = $user?->ap_mat ?? '';
        if(!in_array('ap_pat', $this->keep)) $this->ap_pat = $user?->ap_pat ?? '';
        if(!in_array('genero', $this->keep)) $this->genero = $user?->genero ?? '';
        if(!in_array('procedencia', $this->keep)) $this->procedencia = $user?->procedencia ?? '';
        if(!in_array('correo', $this->keep)) $this->correo = $user?->correo ?? '';
        if(!in_array('telefono', $this->keep)) $this->telefono = $user?->telefono ?? '';
        if(!in_array('password', $this->keep)) $this->password = $user?->password ?? '';
        if(!in_array('externo', $this->keep)) $this->externo = $user?->externo ?? false;
    }

    public function updatedKey($clave, $silenly = false): void
    {
        if(strlen($clave) === 6) {
            $this->fetchUser($clave);
        }
        else {
            $this->resetUser();
            if(!$silenly) $this->not_found = true;
        }
    }

    public function fetchUser($clave, $silenly = false): void
    {
        $user = User::where('clave', $clave)->firstOr(fn() => null);

        if($silenly) $this->not_found = isset($user) ? false : true;

        $this->setUser($user);
    }

    public function resetUser(): void
    {
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
