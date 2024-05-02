<?php

namespace App\Models\InventarioReactivos;

use App\Enums\Condicion;
use App\Enums\CRETIB;
use App\Enums\Estado;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DonacionReactivo extends Pivot
{
    use HasFactory;

    protected $table = 'donaciones_reactivos';
    public $incrementing = true;

    protected $guard = [
        //asignacion en masa activada
    ];

    protected $casts = [
        'CRETIB' => AsEnumCollection::class.':'.CRETIB::class,
        'condicion' => Condicion::class,
        'estado' => Estado::class,
        'caducidad' => 'datetime:Y-m-d H:i:s'
    ];

    protected $attributes = [
        'foto' => null,
        'envase' => 'envase',
        'peso' => 100.00,
        'cantidad' => 100.00,
        'estado' => Estado::Gaseoso,
        'condicion' => Condicion::Nuevo,
        'fac_proc' => 'hey',
        'lab_proc' => 'you',
        'caducidad' => null
        // 'responsable_id' => 0,
        // 'reactivo_id' => 0
        
    ];
}
