<?php

namespace App\Models\InventarioReactivos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SolicitudReactivo extends Pivot
{
    use HasFactory;
    protected $table = 'solicitudes_reactivos';
    public $incrementing = true;

    protected $guard = [
        //asignacion masiva activada 
    ];
}
