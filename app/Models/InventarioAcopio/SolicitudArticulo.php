<?php

namespace App\Models\InventarioAcopio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudArticulo extends Model
{
    use HasFactory;

    protected $table = 'solicitudes_articulos';
}
