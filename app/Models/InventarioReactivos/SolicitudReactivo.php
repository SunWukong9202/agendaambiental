<?php

namespace App\Models\InventarioReactivos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolicitudReactivo extends Model
{
    use HasFactory;

    protected $guard = [
        //asignacion masiva activada 
    ];

    protected $table = 'solicitud_reactivos';

}
