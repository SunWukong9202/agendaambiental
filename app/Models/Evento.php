<?php

namespace App\Models;

use App\Models\Acopio\AcopioPorCategoria;
use App\Models\Acopio\Donacion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';

    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(
            related: User::class,
            table: 'donaciones',//tabla intermedia/pivote
            foreignPivotKey: 'acopio_id',//FK de eventos
            relatedPivotKey: 'donador_id'//FK de users
        );
    }

    public function donaciones()
    {
        return $this->hasMany(Donacion::class, 'acopio_id');
    }

    public function acopioPorCategorias(): HasMany
    {
        //Fk = modelName_id, PK = id
        return $this->hasMany(AcopioPorCategoria::class, 'acopio_id');
    }
}
