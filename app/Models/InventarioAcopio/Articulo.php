<?php

namespace App\Models\InventarioAcopio;

use App\Models\User;
use App\Utils\FilterableSortableSearchable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Articulo extends Model
{
    use HasFactory;
    use FilterableSortableSearchable;

    protected $table = 'articulos';

    protected $guarded = [];

    public function solicitantes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'solicitudes_articulos', 'articulo_id', 'solicitante_id')
            ->as('solicitud')
            ->withPivot('comentario', 'estado')
            ->withTimestamps();
            // ->using(SolicitudArticulo::class);
    }

    public function capturistas(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'capturas_articulos', 'articulo_id', 'capturista_id')
            ->as('captura')
            ->withPivot('observaciones', 'condicion')
            ->withTimestamps();
            // ->using(CapturaArticulo::class);
    }

    public function scopeRefacciones(Builder $query)
    {
        $query->where('es_refaccion', true);
    }
}
