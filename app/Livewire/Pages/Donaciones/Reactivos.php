<?php

namespace App\Livewire\Pages\Donaciones;

use Livewire\Component;
use Livewire\WithPagination;

class Reactivos extends Component
{
    use WithPagination;

    public $search = '';

    private $users = ['users.clave', 'users.nombre'];
    private $searchables = ['otro_reactivo'];
    private $seachablesReactivos = ['reactivos.nombre'];

    public $withReactive = true;

    public $sortCol;

    public $sortAsc = false;

    public $modalOpen = false;

    public $drawerOpen = false;

    public $action = '';

    public $createSuccess = false;
    public $editSuccess = false;
    public $deleteSuccess = false;

    public function render()
    {
        return view('livewire.pages.donaciones.reactivos');
    }
}
