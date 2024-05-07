<?php

namespace App\Models\InventarioReactivos;

use App\Models\User;
use App\Utils\DateFormats;
use App\Utils\FilterableSortableSearchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SolicitudReactivo extends Pivot
{
    use HasFactory;
    use DateFormats;
    use FilterableSortableSearchable;
    const LIMIT = 9999.99;

    protected $table = 'solicitudes_reactivos';
    public $incrementing = true;
    protected $guard = [
        //asignacion masiva activada 
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function reactivo(): BelongsTo
    {
        return $this->belongsTo(Reactivo::class, 'reactivo_id', 'id');
    }
}
