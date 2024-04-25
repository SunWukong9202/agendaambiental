<?php

namespace App\Models\InventarioReactivos;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CapturaReactivo extends Model
{
    use HasFactory;

    protected $guard = [
        //asignacion en masa activada
    ];

    protected $table = 'captura_reactivos';


    
}
