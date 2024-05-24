<?php

namespace App\Livewire\Pages;

use App\Livewire\Forms\Acopios\AcopioForm;
use App\Models\Evento;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Events extends Component
{
    use WithPagination;

    public Evento $acopio;

    public $search = '';
    public $searchables = ['nombre', 'sede'];

    // #[Url]
    public $sortCol;

    // #[Url]
    public $sortAsc = false;

    public $showForm = false;

    public $action = '';
    public $actionMessage = false;
    public $deletedMessage = '';
    public $seeActives = false;

    #[Computed()]
    public function activos()
    {
        // $query = Evento::whereDate('ini_evento', Carbon::today()->toDateString());
        // Obtén la fecha actual en UTC
        $startOfTodayUtc = Carbon::today()->startOfDay();
        $endOfTodayUtc = Carbon::today('UTC')->endOfDay();

        // Consulta para eventos del día de hoy en UTC
        $query = Evento::all();
        return $query;
    }

    public function mount(): void
    {
        if(session('actionMessage')) {
            $this->actionMessage = true;
        }
    }

    public function delete(Evento $acopio)
    {
        $acopio->delete();
        $this->actionMessage = true;
        $this->deletedMessage = "El acopio <b>{$acopio->nombre}</b> fue eliminado exitosamente";
    }

    public function setAction($action,  int $id = null) {
        $params = compact('action', 'id');

        return $this->redirectRoute('admin.acopio', $params, navigate: true);
    }

    public function render()
    {
        $query = $this->acopios();

        return view('livewire.pages.events', [
            'acopios' => $query->paginate(10),
        ]);
    }


    //SECCION DE BUSQUEDA Y ORDENAMIENTO
    public function acopios()
    {
        $query = Evento::search($this->search, $this->searchables);

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
