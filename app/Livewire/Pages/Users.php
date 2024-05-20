<?php

namespace App\Livewire\Pages;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public UserForm $form;

    public $search = '';
    public $searchables = ['clave', 'nombre', 'ap_pat', 'ap_mat', 'correo'];

    // #[Url]
    public $sortCol;

    // #[Url]
    public $sortAsc = false;

    public $modalOpen = false;

    public $action = '';
    public $createSuccess = false;
    public $editSuccess = false;
    public $deleteSuccess = false;

    public function create(): void
    {
        $this->form->create();
        $this->createSuccess = true;
        $this->js("console.log('user creado')"); 
        $this->modalOpen = false;
    }

    public function delete(User $user)
    {
        $user->delete();
        $this->form->user = $user;
        $this->deleteSuccess = true;
    }

    public function edit()
    {
        $this->editSuccess = true;
        $this->modalOpen = false;
        $this->form->update();
    }

    public function setAction($action, ?User $user) {
        $this->modalOpen = true;
        $this->action = $action;
        if(isset($user)) $this->form->setUser($user);
    }

    public function render()
    {
        $query = $this->users();

        return view('livewire.pages.users', [
            'users' => $query->paginate(10),
        ]);
    }

    //SECCION DE BUSQUEDA Y ORDENAMIENTO
    public function users()
    {
        $query = User::search($this->search, $this->searchables);

        if(!empty($this->sortCol)) {
            $query->orderBy($this->sortCol, $this->sortAsc ? 'asc': 'desc');
        }

        return $query;
    }

    public function sortBy($column)
    {
        if($this->sortCol == $column) {
            $this->sortAsc = !$this->sortAsc;
        }
        else {
            $this->sortCol = $column;
            $this->sortAsc = false;
        }
    }

    public function clear(): void
    {
        $this->search = '';
    }
    
    //este metodo se llama en automatico cuando search se
    //actualiza, livewire se encarga de eso
    public function updatedSearch(): void
    {
        $this->resetPage();//<= metodo de WithPagination
    }
}
