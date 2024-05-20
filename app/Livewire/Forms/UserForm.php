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

    public function setUser(User $user): void
    {
        $this->user = $user;

        $this->clave = $user->clave;
        $this->nombre = $user->nombre;
        $this->ap_mat = $user->ap_mat;
        $this->ap_pat = $user->ap_pat;
        $this->genero = $user->genero;
        $this->procedencia = $user->procedencia;
        $this->correo = $user->correo;
        $this->telefono = $user->telefono;
        $this->password = $user->password;
        $this->externo = $user->externo;
    }

    public function create(): User
    {
        //Primero validamos para evitar data que no cumpla reglas
        $this->validate();

        $this->user = User::create(
            //Evitamos agregar la instancia del modelo misma
            $this->except('user'),
        );

        return $this->user;
    }

    public function update(): void
    {
        $this->validate();

        $this->user->update(
            //observe create
            $this->except('user'),
        );
    }
}
