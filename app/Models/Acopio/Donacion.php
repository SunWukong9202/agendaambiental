<?php

namespace App\Models\Acopio;

use App\Models\Evento;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Donacion extends Model
{
    use HasFactory;

    protected $table = 'donaciones';

    public function acopio(): BelongsTo
    {
        return $this->belongsTo(
            Evento::class, //id es la PK con la que compara por defecto
            'acopio_id',//FK Evento en esta tabla
            'id'
        );
    }

    public function capturista(): BelongsTo
    {
        return $this->belongsTo(User::class, 'capturista_id');
    }

    public function donador() : BelongsTo
    {
        return $this->belongsTo(User::class, 'donador_id');
    }

    public function residuos(): BelongsToMany
    {
        //por defecto se busca la FK camelcasedModelName_id
        //es decir donacion_id, PK = id por defecto
        return $this->belongsToMany(Residuo::class, 'donaciones_por_categorias', 'donacion_id', 'residuo_id')
            ->withPivot('cantidad');
    }
}
