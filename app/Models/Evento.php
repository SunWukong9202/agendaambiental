<?php

namespace App\Models;

use App\Models\Acopio\AcopioPorCategoria;
use App\Models\Acopio\Donacion;
use App\Utils\DateFormats;
use App\Utils\FilterableSortableSearchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evento extends Model
{
    use HasFactory;
    use SoftDeletes;
    use DateFormats, FilterableSortableSearchable;

    protected $table = 'eventos';

    protected $casts = [
        'ini_evento' => 'datetime',
    ];

    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(
            related: User::class,
            table: 'donaciones',//tabla intermedia/pivote
            foreignPivotKey: 'acopio_id',//FK de eventos
            relatedPivotKey: 'donador_id'//FK de users
        );
    }

    public function donaciones(): HasMany
    {
        return $this->hasMany(Donacion::class, 'acopio_id');
    }

    public function acopiosPorCategorias(): HasMany
    {
        //Fk = modelName_id, PK = id
        return $this->hasMany(AcopioPorCategoria::class, 'acopio_id');
    }
}
